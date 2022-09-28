<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/function.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
$connection_consume = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$connection_publish = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$connection_publish2 = new AMQPStreamConnection(MQ2_HOST, MQ2_PORT, MQ2_USER, MQ2_PASS);

$channel_consume = $connection_consume->channel();
$channel_publish = $connection_publish->channel();
$channel_publish2 = $connection_publish2->channel();

function send_message_down($message)
{
    global $channel_publish;
    global $channel_publish2;
    $data=json_decode($message->body,true);
    
            ///echo "\n\n\n ja toh ra hai ";
            // echo "\n-------\n";
             //echo $message->body;
            // echo "\n-------\n";
                  //echo ".-";

          if($data['sms']['dlr_mask']==8){
           // return true;
          }

     if($data['sms']['service']=='coderapp' || $data['sms']['service']=='routetest'){
        
            ///echo "\n\n\n ja toh ra hai ";
            // echo "\n-------\n";
            // echo $message->body;
            // echo "\n-------\n";
            
            // echo "\n-------\n";
            // echo $message->body;
            // echo "\n-------\n";
                          //echo ".-";


            $msg = new AMQPMessage($message->body);

            $channel_publish2->basic_publish($msg, MO6_EX, '');
            return true;
        }else{


            // Already Manipulated no need to manipulation

            $msg = new AMQPMessage($message->body);

            $channel_publish->basic_publish($msg, MO4_EX, '');
            //skannel.down.send.stopped.ex
            return true;
        }
     //}
     
}

function manipulateDLRPDU($NewDlrPdu)
{
$NewSms = array();
foreach ($NewDlrPdu['sms'] as $key => $value) {
    // echo "\n--------\n";
    // print_r($value);
    // echo "\n--------\n";


if ($key=='msgdata' && $NewDlrPdu['sms']['dlr_mask']==2) {
    $Pdu = explode(' ', $NewDlrPdu['sms']['msgdata']); 
    
    $PduCode = explode(':', $Pdu[8]); 
    $PduCode = $PduCode[1];
    $PduCode = getNewPduCode($PduCode);
    if($PduCode){
            $Pdu[8] = 'err:'.$PduCode;
            $NewPdu = implode(' ', $Pdu);
            $NewSms['sms'][$key] = $NewPdu;
            // if( $NewDlrPdu['sms']['sender']=='GovtTS'){
            //   $NewSms['sms']['dlr_mask'] = 1;
            // }
            //print_r($Pdu);
    }else{
             $NewSms['sms'][$key] = $value;
        // if( $NewDlrPdu['sms']['sender']=='GovtTS'){
        //       $NewSms['sms']['dlr_mask'] = 1;
        //     }
    }
    
    // if ($Pdu[8]=='err:000') {
    //     if ($Pdu[7]=='stat:REJECTD') {
    //         $Pdu[7] = 'stat:DNDNumber';
    //          $Pdu[8] = 'err:102';
    //     }
    //     //if($NewDlrPdu['sms']['service']=='service'){
    //      //$Pdu[8] = 'err:0000';
    //     //}
    // }
    // if ($Pdu[8]=='err:520' || $Pdu[8]=='err:4106' || $Pdu[8]=='err:604') {
    //          $Pdu[8] = 'err:444';
    // } 
    
    //$NewSms['sms'][$key] = $NewPdu;
    
    }else{
        $NewSms['sms'][$key] = $value;
    }

   if( $NewDlrPdu['sms']['sender']=='GovtTS'){
            // $NewSms['sms']['dlr_mask'] = 1;
    }
}
  // echo "\n--------\n";  
  //   print_r($NewSms);
  //   echo "\n--------\n";
//die;
return json_encode($NewSms);

} 
 
function getNewPduCode($pdu)
{
    $pdu = ltrim($pdu, "0"); 
    
 $file = '/home/smppuser/public_html/rabbit/pdus/errorcode.json';
if(file_exists($file)){
    $file_content = file_get_contents($file);
    //print_r($file_content);
     $array = json_decode($file_content, true);
      if (array_key_exists($pdu,$array)){
           //  echo "\n--------\n";  
        //print_r($pdu);
        return $array[$pdu];   

     }else{
        // if($pdu==666){
        //     return 666;
        // }
        return '34';
        //return $array[$pdu];
    }
}
}

function retryFailedSms($smsc_id, $data, $dlr_url )
{   
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        return true;
        exit;
    }else{

            $sql = "select * from smpp_sent_pdus where dlr_url = '".$dlr_url."' ";
            $query = mysqli_query($conn , $sql);
            $result =  mysqli_fetch_assoc($query);
            if(!$result){
                return true;
            }
            // return json_encode($result);
            //   $result['sender'];

            $message = hex2bin($result['msgdata']);
            $message=str_replace("\r\n", "\n", $message);
            $message=str_replace("&lt;", "<", $message);
            $mclass  = null; 

            if($result["coding"]==2){
                $coding = 2;
            }
            else{
                $coding = 0;
            }
    
            $smsData["sender"]=$result["sender"];
            $smsData["receiver"]=$result["receiver"];
            $smsData["msgdata"]=$message;
            $smsData["time"]= intval($result["time"]);
            $smsData["smsc_id"]=$smsc_id;
            $smsData["service"]=$result["service"];
            $smsData["account"]=$result["service"];
            $smsData["id"]=md5(uniqid());
            $smsData["sms_type"]=2;
            $smsData["coding"]=$coding;
            $smsData["compress"]=0;
            $smsData["dlr_mask"]=923;
            $smsData["dlr_url"]=md5(uniqid()).'dd';
            $smsData["pid"]=0;
            $smsData["priority"]=100;
            $smsData["alt_dcs"]=0;
            $smsData["charset"]="UTF-8";
            $smsData["boxc_id"]="AMQP-DOWN";
            $smsData["meta_data"]="?smpp?TEST=xxx&".$result['udhdata']."&?smsbox?smsc-id=AMQP-DOWN&";
            // $smsData["validity"]="CMT";
            $sms['sms'] = $smsData;
            return $sms;
            
      }
     mysqli_close($conn);

}



function getRetryRoute(){   
$file = '/home/smppuser/public_html/rabbit/retry_route/retry_route.json';
    if(file_exists($file)){
         $file_content = file_get_contents($file);
        return json_decode($file_content, true)[0];
     }


}
function process_message($message)
{   
    // Publish MO msg for BOTH
    // echo "\n--------------------\n";
    // echo $message->body;
    // echo "\n--------------------\n";

    $result = send_message_down($message);
    if($result==true){
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }
}

///kannel.down.send IS (Q1) MT  || tps  = qos value * 25 current = 625

$channel_consume->basic_qos(null, 15, null);
$channel_consume->basic_consume("skannel.down.send.stopped", 'APPL', false, false, false, false, 'process_message');
function shutdown($channel_consume, $channel_publish, $connection_consume, $connection_publish)
{
    // , $channel_publish2,$connection_publish2
    $channel_consume->close();
    $channel_publish->close();

    $connection_consume->close();
    $connection_publish->close();

    // $channel_publish2->close();
    // $connection_publish2->close();
}
register_shutdown_function('shutdown', $channel_consume, $channel_publish, $connection_consume, $connection_publish);

//, $channel_publish2,$connection_publish2

// Loop as long as the channel has callbacks registered
while ($channel_consume->is_consuming()) {
    $channel_consume->wait();
}



//kannel.up.send.ex should be bind mysql.mo.update
?>
