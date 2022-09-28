<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Session;
use App\Models\ReportModel;
use App\Models\Delivery_export_model;

class Report extends Controller{
	public function report(){
		if(session()->get('IsAdmin') != 'Y' && !session()->has('IsLoggedIn')){
           return redirect('/');
        }
        $report_model = new ReportModel;
        $data['summeryhistory'] =  $report_model->getSummaryHistory(); 
        $data['getAllMembers'] = $report_model->getSmppUsers();
         $data['ReportsList'] =  $report_model->getReportsList();
        // print_r( $data['getAllMembers']);
        return view('/Report/report',compact('data'));
	}


	public function report_data($tab){
		if(session()->get('IsAdmin') != 'Y' && !session()->has('IsLoggedIn')){
           return redirect('/');
        }

		$report_model = new ReportModel;

		if ($tab == 'summeryhistory'){
	    	$data =  $report_model->getSummaryHistory(); 
        	return view('/Report/summeryhistory', compact('data'));
		}elseif ($tab == 'deliveryreport'){
			$getAllMembers = $report_model->getSmppUsers();
        	return view('/Report/deliveryreport', compact('getAllMembers'));
		}elseif ($tab == 'reportlist'){
			$getAllMembers = $report_model->getSmppUsers();
        	return view('/Report/reportlist', compact('getAllMembers'));
		}
		
		
	}




	public function deliveryreportpdu(Request $req){
    	$Date = explode(" ", $req->from);
    	$report_model=new ReportModel;
    	$startDate=$Date[0];
    	$currentDate=date('Y-m-d',strtotime("-2 days"));
    	if(session()->get('IsAdmin') != 'Y'){
      		if($startDate < $currentDate ){
        		$DeliveryReportPdu = '';
      		}else{
        		$DeliveryReportPdu = $report_model->getDeliveryReportPdu($req);
            // dd($DeliveryReportPdu);
      		}
	    }else{
	      	$DeliveryReportPdu = $report_model->getDeliveryReportPdu($req);   
          // dd($DeliveryReportPdu);
	    }
        return view('/Report/deliveryreportpdu', compact('DeliveryReportPdu'));
	}	
    public function reportlist(Request $req){
      
        $report_model=new ReportModel;
        $result =$report_model->getUserReportsList($req);
        if($result){

        $data['ReportsList'] =  $report_model->getReportsList();
        return view('/Report/reportlist', compact('data'));
        }
    } 
    public function reportdelete($id){
    	if(!session()->has('IsLoggedIn')){
           return redirect('/');
        }
       $result= DB::table('smppreports')->where('Id',$id)->delete();
       //echo $result;
       if($result) {
        return true;
 		    //   unlink("/reports/archive/$reportpath");
       	
       }


    }
	
	//error cods

	public function error_cods(){
		$data['operator_code_list'] = DB::table('error_code')->orderBy('id', 'desc')->get();
    $data['custom_code']=DB::table('custom_error_code')->orderBy('id','desc')->get();
		return view('Report.error_cods', compact('data'));
	}

	public function add_error_code(Request $req){
 		 $report_model=new ReportModel;
        $data =$report_model->adderrorcode($req);

		
		return redirect()->back();
		
	}

	public function edit_error_code($id){
		$edit_data = DB::table('error_code')->where('id', $id)->first();
		$arr = ['edit_data' => $edit_data];
        return redirect('error_cods')->with($arr);
    }

	public function delete($id){
		DB::table('error_code')->where('id', $id)->delete();
		$report_model=new ReportModel;
       $report_model->getErrorIntoJsonFile();
        return redirect()->back();
    }

    public function upload_errorcode_csv(){
    	return view('/Report/upload_errorcode_csv');
    }

    public function csv_upload_data(Request $req){
    	$file = $req->file('uploaded_file');
    	while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
			$num = count($filedata);
			// Skip first row (Remove below comment if you want to skip the first row)
			if ($i == 0) {
				$i++;
				continue;
			}
			for ($c = 0; $c < $num; $c++) {
				$importData_arr[$i][] = $filedata[$c];
			}
			$i++;
		}
		return $importData_arr;
    }

    public function exportdeliveryreport()

  {
    $Delivery_export_model =New Delivery_export_model();

    $data['exportreport'] =  $Delivery_export_model->exportDeliveryReport();
    //redirect('viewreport');   

  }
}
