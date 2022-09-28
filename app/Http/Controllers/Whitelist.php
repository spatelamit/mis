<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

use App\Models\WhitelistModel;

class Whitelist extends Controller
{
	public function whitelist()
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}

		$data['senderratio'] = DB::table('smpp_senderratio')->get();
		$WhitelistModel = new WhitelistModel;
		$data['whitelist_number'] = $WhitelistModel->getwhitelistnumber();


		$data['approved_User_SenderIds'] = DB::table('approvedUserSenderIds')->where('status', '1')->get();

		$data['ForceSender'] = DB::table('ForceSender')->get();





		return view('/Whitelist/whitelist',  compact('data'));
	}



	public function whitelist_data($tab)
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		if ($tab == 'senderratio') {

			$senderratio = DB::table('smpp_senderratio')->get();
			return view('/Whitelist/senderratio', compact('senderratio'));
		}
	}

	public function deletesenderratio($id, $senderId)
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		$delSender = DB::table('smpp_senderratio')->where('Id', $id)->delete();
		if ($delSender) {
			$file = "rabbit/senderid/" . $senderId . ".json";
			unlink($file);
		}
		// return view('/Whitelist/senderratio', compact('senderratio'));


	}

	public function add_whitelist_number(Request $req)
	{
		$data = array(

			'Number' => $req->Number
		);

		if ($req->id && $req->id != "") {
			DB::table('whitelistnumber')->where('id', $req->id)->update($data);
		} else {
			DB::table('whitelistnumber')->insert($data);
		}
		$WhitelistModel = new WhitelistModel;
		$WhitelistModel->writeForceSenderJson();
		return redirect()->back();
	}

	public function add_AUSenderId(Request $req)
	{
		$data = array(

			'senderId' => $req->senderid,
		);


		$result = DB::table('approvedUserSenderIds')->insertOrIgnore($data);

		if ($result) {
			$variable = DB::table('approvedUserSenderIds')->where('status', '1')->get();
			foreach ($variable as $key => $value) {
				$array[] =  $value->senderId;
			}
			$myfile = fopen("rabbit/Userapproved/userapprovedsender.json", "w") or die("Unable to open file!");
			fwrite($myfile, json_encode($array));
			fclose($myfile);
		}
		return redirect()->back();
	}

	public function add_Forcesender(Request $req)
	{
		$data = array(

			'ForceSender' => $req->ForceSender,
			'UserId' => $req->UserId,
			'Status' => $req->Status
		);

		if ($req->id && $req->id != "") {
			DB::table('ForceSender')->where('id', $req->id)->update($data);
		} else {
			DB::table('ForceSender')->insert($data);
		}
		return redirect()->back();
	}

	public function deletewhitelistnumber($id)
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		DB::table('whitelistnumber')->where('WhiteListId', $id)->delete();



		// return view('/Whitelist/senderratio', compact('senderratio'));


	}

	public function deleteAUSenderId($id)
	{

		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		$result =	DB::table('approvedUserSenderIds')->where('Id', $id)->delete();
		if ($result) {
			$variable = DB::table('approvedUserSenderIds')->where('status', '1')->get();
			foreach ($variable as $key => $value) {
				$array[] =  $value->senderId;
			}
			$myfile = fopen("rabbit/Userapproved/userapprovedsender.json", "w") or die("Unable to open file!");
			fwrite($myfile, json_encode($array));
			fclose($myfile);
		}


		// return view('/Whitelist/senderratio', compact('senderratio'));

	}



	public function deleteForceSender($id)
	{

		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		DB::table('ForceSender')->where('Id', $id)->delete();



		// return view('/Whitelist/senderratio', compact('senderratio'));

	}




	public function savesenderratio(Request $req)
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}

		if ($req->Id && $req->Id != 0) {

			$SenderId = strtoupper($req->SenderId);
			$Ratio = $req->Ratio;

			$data = array(
				'SenderId' => $SenderId,
				'Ratio' => $Ratio,
				'LastUpdate' => date('Y-m-d h:i:s'),
				'Status' => '1'
			);
			$que = DB::table('smpp_senderratio')->where('Id', $req->Id)->update($data);
			if ($que) {
				#############################################
				$array  = array(
					$SenderId => 'SenderId',
					$Ratio => 'Ratio'
				);
				$myfile = fopen("rabbit/senderid/" . $SenderId . ".json", "w") or die("Unable to open file!");
				fwrite($myfile, json_encode($array));
				fclose($myfile);
				return true;
			} else {
				return false;
			}
		} else {

			$SenderId = strtoupper($req->SenderId);
			$Ratio = $req->Ratio;

			$data = array(
				'SenderId' => $SenderId,
				'Ratio' => $Ratio,
				'DateTime' => date('Y-m-d h:i:s'),
				'Status' => '1'
			);
			$insertratio = DB::table('smpp_senderratio')->insert($data);

			if ($insertratio) {

				$array  = array(
					$SenderId => 'SenderId',
					$Ratio => 'Ratio'
				);
				$myfile = fopen("rabbit/senderid/" . $SenderId . ".json", "w") or die("Unable to open file!");
				fwrite($myfile, json_encode($array));
				fclose($myfile);
				return true;
			}
		}
	}


	public function BadData()
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		if(session()->get('IsAdmin') != 'Y'){
			return redirect('/');
		 }

		$baddata = DB::table('bad_data')->get();

		return view('Whitelist.bad_data' , compact('baddata'));
	}


	// public function add_bad_data(Request $req)
	// {
	// 	$data = array(

	// 		'mobile' => $req->mobile,
	// 		'code' => $req->code,
	// 	);


	// 	$result = DB::table('bad_data')->insertOrIgnore($data);
       
	// 	if($result == true){
	// 	return redirect()->back();
	// 	}
	// }

	public function delete_bad_data($mobile)
	{
		if (!session()->has('IsLoggedIn')) {
			return redirect('/');
		}
		DB::table('bad_data')->where('mobile', $mobile)->delete();

		return redirect()->back();
	}
}
