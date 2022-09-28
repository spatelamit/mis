<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Smpp_UserModel extends Model
{
  use HasFactory;
  public function getSmscList()
  {
    $data = DB::table('smsclist')
      ->select('*')
      ->orderBy('SmscId', 'ASC')
      ->get();

    return $data;
  }

  public function getRepushcounts($req)
  {
    $Username = $req->Username;
    $sender = $req->sender;
    $receiver = $req->receiver;
    $SmscId = $req->SmscId;
    $DateTime = explode(" - ", $req->datetimes);

    $startDate =   strtotime($DateTime[0]);
    $endDate   =   strtotime($DateTime[1]);

    $DOM = date('d', $startDate);
    $DOM = ltrim($DOM, "0");
    $DOM = $DOM;

    $where_data = " ";

    if ($req->Username != 'all' && $req->Username && $req->Username != "") {
      $where_data .= "service = '" . $req->Username . "' and ";
    }

    if ($req->SmscId != 'all' && $req->SmscId && $req->SmscId != "") {
      $where_data .= "smsc_id = '" . $req->SmscId . "' and ";
    }

    if ($req->sender && $req->sender != "") {
      $where_data .= "sender = '" . $req->sender . "' and ";
    }

    if ($req->receiver && $req->receiver != "") {
      $where_data .= "receiver = '" . $req->receiver . "' and ";
    }

    $where_data .= "time between " . $startDate . " and " . $endDate . " ";
    $que = "SELECT dlr_mask, count(*) as Count FROM smpp_sent_pdus PARTITION (DOM_" . $DOM . ") where " . $where_data . " group by dlr_mask";

    $query =  DB::select(DB::raw($que));

    $data['RepushCounts'] = $query;
    $data['RepushEnquire'] = array(
      'Username' => $Username,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'sender' => $sender,
      'receiver' => $receiver,
      'SmscId' => $SmscId
    );
    return $data;
  }




  public function changeRouting($req)
  {

    $data = ['DefaultSmsc' => $req->DefaultSmsc];

    $query = DB::table('smpp_accounts')
      ->where('UserId', $req->UserId)
      ->update($data);

    if ($query) {
      $smppuser = array(
        'Username' => $req->Username,
        'DefaultSmsc' => $req->DefaultSmsc,
        'Ratio' => ''
      );
      $this->smsc_routing_file_write($smppuser);
      return true;
    }
  }


  public function getSmppUsers()
  {
    $que = DB::table('smpp_accounts')->select('smpp_accounts.*', 'smsclist.SmscId as Operator');

    // if(session()->get('IsAdmin') == 'Y'){
    //     $que = $que->where('smpp_accounts.UserId', session()->get('Id'));
    // }
    $data = $que->leftjoin('smsclist', 'smsclist.Id', '=', 'smpp_accounts.DefaultSmsc')
      ->orderBy('smpp_accounts.status', "DESC")
      ->orderBy('smpp_accounts.Username', "ASC")
      ->get();


    return $data;
  }

  public function getSMPPUserDetails($user_id)
  {

    $result = DB::table('smpp_accounts')->where('UserId', $user_id)->first();
    return $result;
  }


  public function saveUser($req)
  {
    $MISdata = array(
      'Username' => $req->UsernameMIS,
      'Password' => $req->PasswordMIS,
      'Status' => $req->StatusMIS,
      'ParentId' => '0',
      'Fullname' => $req->Fullname,
      'Mobile' => $req->Mobile,
      'Email' => $req->Email,
      'CompanyOrganization' => $req->CompanyOrganization,
      'City' => $req->City,
      'Country' => $req->Country,
      'State' => $req->State,
      'Address' => $req->Address,
      'CreationDate' => date('Y-m-d h:i:s A'),
      'UserType' => 'user',
      'IsAdmin' => 'N'
    );

    $UserId = DB::table('users')->insertGetId($MISdata);

    $SMPPdata = array(
      'UserId' => $UserId,
      'Username' => $req->Username,
      'Password' => $req->Password,
      'IpAddress' => $req->IpAddress,
      'Mode' => $req->Mode,
      'Throughput' => $req->Throughput,
      'ThroughputIn' => $req->ThroughputIn,
      'ThroughputOut' => $req->ThroughputOut,
      'MaxInstances' => $req->MaxInstances,
      'MaxTransceiverInstances' => $req->MaxTransceiverInstances,
      'MaxTransmitterInstances' => $req->MaxTransmitterInstances,
      'MaxReceiverInstances' => $req->MaxReceiverInstances,
      'SessionTimeout' => $req->SessionTimeout,
      'SmscId' => $req->SmscId,
      'DefaultSmsc' => $req->DefaultSmsc,
      'Status' => $req->Status,
      'LowBalanceLimit' => 10,
      'Ratio' => $req->Ratio
    );
    $smscwrite = $this->smsc_routing_file_write($SMPPdata);

    $Balancedata = array(
      'Username' => $req->Username,
      'Credits' => '0',
      'ActualCredits' => '0',
      'UserId' => $UserId
    );
    DB::table('smpp_accounts')->insert($SMPPdata);



    if (DB::table('balance')->insert($Balancedata)) {
      session()->flash('success', 'Success: New User Added Successfully!');
      return redirect('smpp_user');
    }
  }


  public function update_smpp_user($req)

  {
    // return $req;
    $updatesuser = array(

      'Username' => $req->UsernameMIS,
      'Status' => $req->StatusMIS,
      'Fullname' => $req->Fullname,
      'Mobile' => $req->Mobile,
      'Email' => $req->Email,
      'CompanyOrganization' => $req->CompanyOrganization,
      'City' => $req->City,
      'Country' => $req->Country,
      'State' => $req->State,
      'Address' => $req->Address
    );


    $userssmpp = DB::table('users')->where('Id', $req->id)->update($updatesuser);

    // if($userssmpp = true){

    // }

    if ($req->IsOTPUer) {
      $otpstatus = 1;
    } else {
      $otpstatus = 0;
    }

    if ($req->IsApprovedSender) {
      $IsApprovedSender = 1;
    } else {
      $IsApprovedSender = 0;
    }

    $updatesuser1 = array(

      'Username' => $req->Username,
      'IpAddress' => $req->IpAddress,
      'Mode' => $req->Mode,
      'Throughput' => $req->Throughput,
      'ThroughputIn' => $req->ThroughputIn,
      'ThroughputOut' => $req->ThroughputOut,
      'MaxInstances' => $req->MaxInstances,
      'MaxTransceiverInstances' => $req->MaxTransceiverInstances,
      'MaxTransmitterInstances' => $req->MaxTransmitterInstances,
      'MaxReceiverInstances' => $req->MaxReceiverInstances,
      'SessionTimeout' => $req->SessionTimeout,
      'SmscId' => $req->SmscId,
      'DefaultSmsc' => $req->DefaultSmsc,
      'Status' => $req->Status,
      'Ratio' => $req->Ratio,
      'dnd' => $req->dnd,
      'IsOTPUser' => $otpstatus,
      'IsApprovedSender' => $IsApprovedSender,
      'LowBalanceLimit' => $req->LowBalanceLimit


    );

    // dd($updatesuser1);

    $userssmpp1 = DB::table('smpp_accounts')->where('UserId', $req->id)->update($updatesuser1);

    if ($userssmpp1 = true) {
      $this->otp_user_file_write();
      $this->dndUserWriteFile();
      $this->approved_senderId_file_write();
    }
  }


  public function smsc_routing_file_write($smppuser)
  {
    $DefaultSmsc = $this->getSmscId_smpp($smppuser['DefaultSmsc']);

    $array  = array(
      $DefaultSmsc->SmscId =>  $smppuser['Username'],
      $smppuser['Ratio'] =>  'Ratio'
    );
    $myfile = fopen("rabbit/esme/" . $smppuser['Username'] . ".json", "w") or die("Unable to open file!");

    fwrite($myfile, json_encode($array));
    fclose($myfile);
  }


  public function getSmscId_smpp($SmscId)
  {
    $result = DB::table('smsclist')->where('Id', $SmscId)->first();
    return $result;
  }
  public function UpdateBalance($request)
  {

    $totalbalance = $request->TotalBalance;

    $user_id = $request->MemberId;
    $FundType = $request->FundType;
    $add_balance = $request->Balance;
    $date = $request->DateTime;
    $Description = $request->Description;
    if ($FundType == "Add") {
      $newbalance = $totalbalance + $add_balance;
    } elseif ($FundType == "Reduce") {
      $newbalance = $totalbalance - $add_balance;
    }

    $balance_update = array(
      'Credits' => $newbalance,
      'ActualCredits' => $newbalance,
    );
    //    dd($balance_update);
    if ($date == "") {
      $DateTime = date('Y-m-d H:i:s a');
    } else {

      $DateTime = $date;
    }

    $balancehistory = array(
      'Balance' => $add_balance,
      'NewBalance' => $newbalance,
      'Description' => $Description,

      'FundType' => $FundType,
      'UserId' => $user_id,
      'DateTime' => $DateTime,
      'PaymentBy' => session()->has('Name'),
    );
    // DB::enableQueryLog();
    $update_balance = DB::table('balance')->where('UserId', $user_id)->update($balance_update);
    // dd(DB::getQueryLog());
    if ($update_balance) {

      // $UserId = DB::table('balancehistory')->insert($balancehistory); // comment due to table structure in not proper
      return true;
    } else {
      return false;
    }
  }

  /////////////############*** OTP SECTION START HERE ***########################

  public function otp_user_file_write()
  {

    $smppuser = DB::table('smpp_accounts')->select('smpp_accounts.username')
      ->where('IsOTPUser', 1)
      ->get();

    if ($smppuser) {

      $array = array();
      foreach ($smppuser as $key) {
        $array[] = $key->username;
      }
    }

    $myfile = fopen("rabbit/otpuser/otpuserlist.json", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($array));
    fclose($myfile);
  }
  public function dndUserWriteFile()
  {

    $users = DB::table('smpp_accounts')
      ->select('username')
      ->where('dnd', 1)
      ->get();

    if ($users) {

      $array = array();
      foreach ($users as $key) {
        $array[] = $key->username;
      }
    }

    $myfile = fopen("rabbit/dnd/dnduserlist.json", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($array));
    fclose($myfile);
  }
  public function approved_senderId_file_write()
  {
    $users = DB::table('smpp_accounts')
      ->select('username')
      ->where('IsApprovedSender', 1)
      ->get();

    if ($users) {

      $array = array();
      foreach ($users as $key) {
        $array[] = $key->username;
      }
    }



    $myfile = fopen("rabbit/Userapproved/approvedstatus.json", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($array));
    fclose($myfile);
  }

  ### Current Counts OF all Users/ for Dashbaord Controller
  public function getCurrentCountsSummary($date)
  {
    echo $date;
    $startDate =  strtotime($date . "12:00:00 AM");
    $endDate = strtotime($date . "11:59:59 PM");

    $DOM = date('d', $startDate);
    $DOM = ltrim($DOM, "0");
    //echo $DOM;

    // $dsql = 'select fn_get_day_of_half_year("'.$date.'") as DAY';
    // $dquery = DB::select($dsql) ;
    // $DAY = $dquery[0]->DAY +1;

    $summary_table = 'select service, COUNT(service) as Count, dlr_mask from smpp_sent_pdus PARTITION(DOM_' . $DOM . ') where time between "' . $startDate . '" and "' . $endDate . '" group by service,dlr_mask';


    $result = DB::select($summary_table);



    if ($result) {

      return $result;
    } else {
      return false;
    }
  }
  public function saveUsersSummary($SmppUserSummery, $Date)
  {


    $D = 0;
    $F = 0;
    $R = 0;
    $S = 0;
    $sub = 0;
    $Submit = 0;
    foreach ($SmppUserSummery as $value) {
      // dd($value);
      $Delivered = (isset($value['1']) && $value['1']) ? $value['1'] : '0';
      $Failed = (isset($value['2']) && $value['2']) ? $value['2'] : '0';
      $Reject = (isset($value['16']) && $value['16']) ? $value['16'] : '0';
      $sent1 = (isset($value['923']) && $value['923']) ? $value['923'] : '0';
      $sent2 = (isset($value['8']) && $value['8']) ? $value['8'] : '0';
      $Submition = $Delivered + $Failed + $Reject + $sent1 + $sent2;

      $SummeryCounts[] = array(
        'Username' => $value['name'],
        'Date' => $Date,
        'Submit' => $Submition,
        'Delivered' => $Delivered,
        'Failed' => $Failed + $Reject,
        'Pending' => $sent1 + $sent2,
        'RequestedDate' => date('Y-m-d h:i:s A'),
        'Status' => 1

      );

      $D += $Delivered;
      $F += ($Failed + $Reject);
      //$R+=$Reject;
      $S += ($sent1 + $sent2);
      $sub += $Submition;
    }
    $alldata = array(
      'Username' => 'ALL',
      'Date' => $Date,
      'Submit' => $sub,
      'Delivered' => $D,
      'Failed' => $F,
      'Pending' => $S,
      'RequestedDate' => date('Y-m-d h:i:s A'),
      'Status' => 1
    );
    $SummeryCounts[] = $alldata;
    print_r($SummeryCounts);
    //////////////// Delete record if already having in smpp_user_summery table. /////////////////////

    foreach ($SummeryCounts as  $value) {
      // dd($value['Username']);
      DB::table('smpp_user_summery')->where(array('Username' => $value['Username'], 'Date' => $Date))->delete();
      // $this->db->delete('smpp_user_summery', array('Username' => $value['Username'],'Date' => $Date));
    }

    //////////////// insert daily count in smpp_user_summery table. /////////////////////

    DB::table('smpp_user_summery')->insert($SummeryCounts);
  }


  public function getCurrentCountsSummary1($date)
  {

    $startDate =  strtotime($date . "12:00:00 AM");
    $endDate = strtotime($date . "11:59:59 PM");
    echo "<br>";
    echo $startDate;
    echo "<br>";
    echo $endDate;
    $DOM = date('d', $startDate);
    $DOM = ltrim($DOM, "0");

    echo $date;

    $dsql = 'select fn_get_day_of_half_year("' . $date . '") as DAY';
    $dquery = DB::select($dsql);
    $DAY = $dquery[0]->DAY + 1;
    echo "<br>";
    echo $DAY;
    $summary_table = 'select service, COUNT(service) as Count, dlr_mask from `smpp_sent_pdus_dlr_uda_data_22-sep` PARTITION(DOM_' . $DOM . ') where time between "' . $startDate . '" and "' . $endDate . '" group by service,dlr_mask';
    dd($summary_table);

    $result = DB::select($summary_table);



    if ($result) {

      return $result;
    } else {
      return false;
    }
  }
}
