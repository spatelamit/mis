<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

use App\Models\KannelModel;

class Kannel extends Controller{
	public function kannel_status(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
	        return redirect('/');
	    }
	    
        $kannel_model = new KannelModel;
        $data['smsc_data'] = $kannel_model->getSmscsTrafficSummeryHistory();
		// dd($data['smsc_data']);
        $startDate = strtotime("-70 day");
	        if(isset($_GET['day'])){
	          $startDate = strtotime("today");
	        }
	        $endDate = strtotime("-0 minutes");
	        $DOM = date('d');
	        $DOM = ltrim($DOM, "0");
	        $data['tab'] = 'sendertraffic';
			$data['operator_health'] = DB::table('operator_health')->select('*')->whereBetween('datetime', [$startDate, $endDate])->orderBy('id', 'DESC')->get();
        return view('/Kannel/kannel_status',compact('data'));
	}
	public function getsmscdata(Request $req){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
	    if(session()->get('IsAdmin') != 'Y'){
	        return redirect('/');
	    }
	    $kannel_model = new KannelModel;
	    $data1 = $kannel_model->getAllSmscsTraffic($req);
		$data2 = $kannel_model->fakeSmscsTrafficOnly($req);

		$main=array();
		$main2=array();

		foreach ($data1 as $value) {
			$main[$value['smsc_id']]['name']=$value['smsc_id'];
			$main[$value['smsc_id']][$value['dlr_mask']]=$value['Count'];
		}
		$SmscsTraffic=$main;
		
		foreach ($data2 as $value) {
			$main2[$value['smsc_id']]['name']=$value['smsc_id'];
			$main2[$value['smsc_id']][$value['dlr_mask']]=$value['Count'];
		}
		$fakeTraffic=$main2;
		return view('/Kannel/smsctraffic_ajax', compact('fakeTraffic', 'SmscsTraffic'));
	}
	


	public function getsenderdata(Request $req){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }

      // if(session()->get('IsAdmin') != 'Y'){
	  //           return redirect('/');
	  //       }
	//   dd($req);
        $kannel_model = new KannelModel;
        $data = $kannel_model->getDataSenderWise($req);

        $type = $req->type;
      	$main=array();
      	foreach ($data as $value) {
        	$main[$value->sender]['name']=$value->sender;
        	$main[$value->sender]['type']=$value->$type;
        	$main[$value->sender][$value->dlr_mask]=$value->count;
      	}
      	
      	$data['col_name']=$req->type;

      	$data['senderCounts']=$main;
        return view('/Kannel/sendertraffic_ajax', compact('data'));
	}
	

	public function ajaxrabbit(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        return view('/Kannel/ajaxrabbit');
	}

	public function ajaxsmppbox(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        return view('/Kannel/ajaxsmppbox');
	}

	public function ajaxupstream(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        return view('/Kannel/ajaxupstream');
	}

	public function smppbox(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        return view('/Kannel/ajaxsmppbox');
	}

	public function smsctraffic(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
		$kannel_model = new KannelModel;
		$data = $kannel_model->getSmscsTrafficSummeryHistory();
        return view('/Kannel/smsctraffic', compact('data'));
	}
}