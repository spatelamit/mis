<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Session;
class ReportModel extends Model
{
    use HasFactory;
    public function getSmppUsers(){
        $query = DB::table('smpp_accounts')
        ->select('smpp_accounts.*', 'smsclist.SmscId as Operator')
        ->leftjoin('smsclist', 'smsclist.Id','=' ,'smpp_accounts.DefaultSmsc')
        ->orderBy('smpp_accounts.status', 'desc');
     if(session()->get('IsAdmin') != 'Y'){
            $query->where('smpp_accounts.UserId', session()->get('Id'));
          }
    // $result= $query->get();
     // DB::enableQueryLog();

 $query= $query->get();

// dd(DB::getQueryLog()
        return $query;
    }

    public function getDeliveryReportPdu($req)
    {
       
        
        $startDate =  strtotime($req->from);
         $Date = explode(" ",  $req->from );
        $endDate = strtotime($req->to);
        // print_r( $Date);
        // echo "<br>";
        // echo $Date[0];
        $day = 0;
        $today =   strtotime(date('Y-m-d')."12:00:00 AM");

        $dsql = 'select fn_get_day_of_half_year("'.$Date[0].'") as DAY';
        $dquery = DB::select($dsql) ;

             // echo($dquery[0]->DAY);
              $DAY = $dquery[0]->DAY +1;

// echo $DAY;
// die();  
        if($startDate < $today){
            $day = 1;          
        }
       
        $where1=$where2=$where3=$where4=$where5=$where6=$where7="";
        if($req->Username!='all'){
            if($req->Username && $req->Username!="" ){
                // $que= $que->where('service', $req->Username);
                $where1=" and service = '".$req->Username."'";
            }
        }

        if($req->MsgId && $req->MsgId!="" ){
            // $que= $que->where('dlr_url', $req->MsgId);
            $where2=" and dlr_url = '".$req->MsgId."'";
        }
              
        if($req->Sender && $req->Sender != ""){
            // $que= $que->where('sender', $req->Sender);
            $where3=" and sender = '".$req->Sender."'";
        }

        if($req->type && $req->type !=""){
            // $que= $que->where('dlr_mask', $req->type);
             $where4=" and dlr_mask = '".$req->type."'";
        }

        $d1  = $startDate;
        $d2 =  strtotime('-2 days');

        if($d1<$d2){
            // $this->db->from('smpp_sent_pdus_archive PARTITION(DAY_'.$DAY.')');
            $DateTimeold = str_replace(" AM", "",$req->from);
            $DateTimeold = str_replace(" PM", "", $DateTimeold);
    


            if($req->Mobile && $req->Mobile !=""){
                $mobilelnth = strlen($req->Mobile);
                // $que= $que->where('receiver', $req->Mobile);
                $where5=" and receiver = ".$req->Mobile;
            }
         $que = "select * from smpp_sent_pdus_archive PARTITION(DAY_".$DAY.")  where 1=1 ".$where1. $where2 .$where3. $where4. $where5." LIMIT 50" ;
        // echo $que;
         $result=DB::select($que);
         

                        // dd($page1);
         if($result){

                 return $result;
                 }else{
                    return false;
                }
        }else{
            if($req->Mobile && $req->Mobile !=""){
                // $que= $que->where('receiver', $req->Mobile);  
                 $where6=" and receiver = ".$req->Mobile;
            }

            $DOM = date('d');
            $DOM = ltrim($DOM, "0");
            $DOM = $DOM-$day;
            // $this->db->from($this->sentTbl);
            // $que= $que->whereBetween('time', [$startDate, $endDate]);
             $where7=" and time between  ".$startDate." and ".$endDate. " order by time desc LIMIT 50";
            
                $query = "select * from smpp_sent_pdus  where 1=1 ".$where1. $where2 .$where3. $where4. $where6.$where7;
              //  echo $query;
         $result=DB::select($query);
                 if($result){

                 return $result;
                 }else{
                    return false;
                }
        }

        
    }

    public function getSummaryHistory(){
        $startDate =date('Y-m', strtotime(" -4 month")).'-01';
        $endDate = date('Y-m', strtotime(" 0 month")).'-31';
        $data = DB::table('smpp_user_summery')
        ->select('*')
        ->whereBetween('Date', [$startDate, $endDate])
        ->where('Status',1)
        ->orderBy("Date", "DESC")
        ->groupBy('Date', 'Username')
        ->paginate(25);
        return $data;
    }
    public function getReportsList(){
         $data = DB::table('smppreports')
        ->select('*')
        ->where('UserId',Session::get('Id'))
        ->orderBy("RequestedDate", "DESC")
        ->paginate(25);
       
    
        return $data;

    }
     public function getUserReportsList($req){
        $date=$req->Date;
        $Username=$req->Username;

         if($req->Sender && $req->Sender!=""){
                    $Sender =$req->Sender;
      }else{
        $Sender = "ALL";
      }

         $smpp_user_summery = DB::table('smpp_user_summery')
        ->select('*')
        ->where('Username',$Username)
         ->where('Date',$date)
        ->first();
        $Submit=0;
        if($smpp_user_summery){
            $Submit=$smpp_user_summery->Submit;
        }
        $data = array( 
        'UserId'=>Session::get('Id') ,
        'Username'=>$Username ,
        'Date'=> $date,
        'Sender'=> $Sender,
        'RequestedDate'=> date('Y-m-d h:i:s A'),
        'ReportStatus'=> 'Pending',
        'ReportPath'=> 'N/A',
        'Status'=> '0',
        'datasize'=> $Submit + 10,
    );
        $insertdata=DB::table('smppreports')->insert($data);
    if($insertdata){
        return true;
    }

    }
    public function get_error_cods(){
        $data = DB::table('error_code')->orderBy('id', 'desc')->get();
        return $data;
    }

    public function adderrorcode($req){
        
        $code_des=DB::table('custom_error_code')
                    ->select('description','self_description')
                    ->where('status','1')
                    ->where('custom_code',$req->custom_code)
                    ->first();

        $data = array(
            'operator_code' => $req->operator_code,
            'custom_code' => $req->custom_code,
            'description' => $code_des->description,
            'selfdescription' => $code_des->self_description
        );

        if($req->id && $req->id != ""){
            $Upresult=DB::table('error_code')->where('id', $req->id)->update($data);
            if($Upresult){
                 $this->getErrorIntoJsonFile();
                return true;
            }else{
                return false;
            }

        }else{
            $Insresult= DB::table('error_code')->insert($data);
            if($Insresult){
                 $this->getErrorIntoJsonFile();
                return true;
            }else{
                return false;
            }
        }
    }

    public function getErrorIntoJsonFile()
{
        $data =DB::table('error_code')
        ->select('custom_code','operator_code','selfdescription')
        ->get();
       
        if($data){
            
      
        
        $error_json=array();
        $error_json_bssp=array();
        foreach ($data as  $error) {
              $error_json[$error->operator_code]=$error->custom_code;
              $error_json_bssp[$error->operator_code]=$error->selfdescription;
        }
           
         file_put_contents("rabbit/pdus/errorcode.json", json_encode($error_json));
         file_put_contents("rabbit/pdus/errorcode_description.json", json_encode($error_json_bssp));
   }
}
   
    
}





