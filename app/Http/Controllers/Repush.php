<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

use App\Models\RepushModel;
use App\Models\Smpp_UserModel;

class Repush extends Controller{


	


	public function repush(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        $smpp_user_model = new Smpp_UserModel;
		$getAllMembers = $smpp_user_model->getSmppUsers();
		$SmscList = $smpp_user_model->getSmscList();
        return view('/Repush/repush', compact('getAllMembers', 'SmscList'));
	}
	
	

	
	public function getrepushdata(Request $req){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }

        if (session()->get('IsAdmin')!="Y") {
      		return redirect('/');
    	}
    	$smpp_user_model = new Smpp_UserModel;
		$RepushData = $smpp_user_model->getRepushcounts($req);
		$SmscList = $smpp_user_model->getSmscList();


        return view('/Repush/getrepushdata', compact('RepushData', 'SmscList'));
	}

	public function pushselecteddata(Request $req)
  	{     
  		$RepushModel = new RepushModel;

  		$RepushData = $RepushModel->getRepushData($req);
		$WhiteNumbers = $RepushModel->getWhiteListNumbers();
		// $RepushModel->SendMessageMQSMPP($RepushData, $WhiteNumbers);
		return true;

		
  	}
}