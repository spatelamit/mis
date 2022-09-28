<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RepushModel extends Model
{
    use HasFactory;

    public function getRepushData($req) {
        $startDate =   $req->ReStartDate;
        $endDate   =   $req->ReEndDate;

        $DOM = date('d', $startDate);
        $DOM = ltrim($DOM, "0");
        $DOM = $DOM;

        $where_data = " ";

        if($req->ReUsername !='all' && $req->ReUsername && $req->ReUsername != ""){
            $where_data .= "service = '".$req->ReUsername."' and ";
        }
        
        if($req->ReSender && $req->ReSender !=""){
            $where_data .= "sender = '" . $req->ReSender."' and ";
        }

        if($req->ReReceiver && $req->ReReceiver !=""){
            $where_data .= "receiver = '".$req->ReReceiver."' and ";
        }

        if($req->SMSC && $req->SMSC !=""){
            $where_data .= "smsc_id = '".$req->SMSC."' and ";
        }

        $where_data .= "dlr_mask != 1 and dlr_mask != 2 and dlr_mask != 16 and";

        $where_data .= "time between ".$startDate." and ".$endDate." ";


        $que = "SELECT 'time', sender,receiver, dlr_url, dlr_receipt, service, dlr_mask FROM smpp_sent_pdus PARTITION (DOM_".$DOM.") where ". $where_data ." limit ". $req->Limit;

        return $req;

        // $query =  DB::select(DB::raw($que));
      
    }

    public function getWhiteListNumbers() {
        $result =  DB::table('whitelistnumber')->where('Status', 1)->orderBy("DateTime", "DESC")->get();
        foreach ($result as $key => $value) {
            $Numbers[] = $value->Number;
        }
        $myfile = fopen("rabbit/whitelist/whitenumbers.json", "w") or die("Unable to open file!");
        fwrite($myfile, json_encode(array_unique( $Numbers)));
        return $result;
            
    }

    public function SendMessageMQSMPP($msgData, $WhiteNumbers=array()){

        $w = $v = 0;
        for ($i=0; $i <count($WhiteNumbers) ; $i++) { 
            $WhiteNumbers1[] = $WhiteNumbers[$i]['Number'];

        }
        $connection = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
        $channel = $connection->channel();
        $dlr_mask = $_REQUEST['dlr_mask'];
        foreach ($msgData as $key => $data) {
            if(in_array($data['receiver'], $WhiteNumbers1)){
                $w +=1;
            }else{
                $v +=1;
                $msgContent= hex2bin($data['dlr_receipt']);
                $sms ='{
                    "sms": {
                    "sender": "'.$data['sender'].'",
                    "receiver": "'.$data['receiver'].'", 
                    "msgdata": "'.$msgContent.'", 
                    "time": '.time().', 
                    "smsc_id": "VIDEOCON_PRE", 
                    "foreign_id": "'.$data['dlr_url'].'", 
                    "service": "'.$data['service'].'", 
                    "account": "'.$data['service'].'",
                    "id": "'.$data['dlr_url'].'", 
                    "sms_type": 3, 
                    "dlr_mask": '.$dlr_mask.', 
                    "dlr_url": "'.$data['dlr_url'].'", 
                    "boxc_id": "KANNELMQ", 
                    "meta_data": "?orig_msg?dlr_mask=923&?smpp?dlr_err=%03%00%00&"
                    }
                }';
                $msg = new AMQPMessage($sms);
                $channel->basic_publish($msg, MO3_EX, '');
            }
        }
        $channel->close();
        $connection->close();
        echo "Whitelisted : " . $w . " <br>Pushed : " . $v;
        return true;
    }
}