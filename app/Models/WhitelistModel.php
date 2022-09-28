<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WhitelistModel extends Model
{
    use HasFactory;
    public function getRatioSenders(){
        $data = DB::table('smpp_accounts')
        ->select('smpp_accounts.*', 'smsclist.SmscId as Operator')
        ->join('smsclist', 'smsclist.Id','=' ,'smpp_accounts.DefaultSmsc')
        ->orderBy('smpp_accounts.status', 'desc')
        ->get();
        return $data;
    }
    public function writeForceSenderJson() {

			$ForceSender = $this->getForceSender();
			// dd($ForceSender);
			$array = array();
			  foreach ($ForceSender as $key => $value) {
			    if($value->Status==1){
			      $array[]  = array(
			                      'Username' =>  $value->Username, 
			                      'ForceSender'=>  $value->ForceSender
			                    );
			  
			       }
			  }

			     $myfile = fopen("rabbit/forceSender/forceSender.json", "w") or die("Unable to open file!");
			       fwrite($myfile, json_encode($array));
			       fclose($myfile);
}
	public function getForceSender() {
		        $data=DB::table('ForceSender')
		        ->select('ForceSender.*','smpp_accounts.Username')
		       ->join('smpp_accounts', 'ForceSender.UserId','=' ,'smpp_accounts.UserId')
		       ->get();

		       // $this->db->order_by("Id", "ASC");
		       
		        if($data){
		            
		              return $data;
		            }
		            else{
		                return false;
		            }

}
		public function getwhitelistnumber(){

        $result=DB::table('whitelistnumber')->get();
        if($result){
        	foreach ($result as $key => $value) {
                $Numbers[] = $value->Number;
            }
            $myfile = fopen("rabbit/whitelist/whitenumbers.json", "w") or die("Unable to open file!");
            fwrite($myfile, json_encode(array_unique( $Numbers)));
        	return $result;
        }else {
        	return false;
        }

		}





   
    
}





