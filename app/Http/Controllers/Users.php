<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Smpp_UserModel;
use App\Http\Middleware\CheckSession;
use DB;
use App\Imports\TestImport;
use App\Imports\usersImport;
use Maatwebsite\Excel\Facades\Excel;




class Users extends Controller
{
    public function login()
    {
        if(session()->has('IsLoggedIn')){
            return redirect('/dashboard');
        }
        return view('User/login');
    }

    public function loginAction(Request $request)
    {
        $req = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if($req == true){
        $data = User::where('Username', $request->username)->where('Password', $request->password)->first();
        }
        if($data){
            $user_id = $data->Id;
            Session::put('IsLoggedIn', true);
            Session::put('Id', $user_id);
            Session::put('Name', $data->Fullname);
            
            if($data->IsAdmin == 'Y'){
                Session::put('IsAdmin', 'Y');  
            }
            
            return redirect('/dashboard')->with("Success", "Successfully Login!");
        }
        if(!Session::has('IsLoggedIn')){

            return redirect("/")->with('Login details are not valid');
        }

    }

    public function logout() {
        \Auth::logout(); // logout user
        Session::flush();
        // Redirect::back();
        return redirect(\URL::previous());
        // return redirect('/');
    }

    public function dashboard() {
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        // if(session()->get('IsAdmin') != 'Y'){
        //     return redirect('/');
        //  }

        // $from =date('Y-m-d', strtotime('-30 day'));
        // $to =date('d', strtotime('-7 day'));

        // $this->db->select('service, COUNT(service) as Count, dlr_mask', false);
        // SELECT service, count(service) as counts FROM smpp_sent_pdus PARTITION (DOM_20) group by dlr_mask, service

        
            $DOM =ltrim(date('d', strtotime('-7 day')));
            $data= DB::select("SELECT service,dlr_mask, count(dlr_mask) as counts FROM smpp_sent_pdus PARTITION (DOM_".$DOM.") group by service, dlr_mask");
            // $time = date('Y-m-d H:i:s','1663660882');
           
            foreach ($data as $value) {
                $main[$value->service]['name']=$value->service;
                $main[$value->service][$value->dlr_mask]=$value->counts;
              }
            //   dd($main);
        return view('User/dashboard', compact('main'));
    }

    public function Balance()
    {
    	if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        $data = DB::table('balance')->get();
        return view('User/balance', compact('data'));
    }

    public function BalanceHistory()
    {
    	if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
         $data = DB::table('balancehistory')
         ->leftJoin('users', 'balancehistory.UserId', '=', 'users.Id')
         ->get();

        // Customer::select('customers.*')
        // ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
        // ->whereNull('orders.customer_id')->first();



        return view('User/balance_history', compact('data'));
    }

    public function updatebalance(Request $request){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
       }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }

  // dd($request);
        $Smpp_UserModel = new Smpp_UserModel;
        $data = $Smpp_UserModel->UpdateBalance($request);
       return redirect("Balance");
       // return view('user/userbalance');
	}

    public function Dlt_Mmq_Operator(){
        $data = DB::table('smpp_dlt_templates')->orderBy('id', 'desc')->get();
        return view('User.dlt_mmq_operator', compact('data'));
    }

    public function store(Request $request)
    {
        // dd(request()->file('file'));
        Excel::import(new usersImport, request()->file('file'));
        // return 'xyz';
        return redirect("Dlt_Mmq_Operator");
    }


    public function User_Controller_History(){
    	if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        $data = DB::table('smpp_user_Controller_history')->get();
        return view('User.smpp_user_controller_history', compact('data'));
    }



    public function Otp_Section()
    {
    	if(!session()->has('IsLoggedIn')){
            return redirect('/');
       }
    	 if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        // $data = DB::table('otpsender')->get();
        $data['otpsender'] = DB::table('otpsender')->get();
        $data['smpp_spam_content'] = DB::table('smpp_spam_content')
        // ->join('users', 'smsclist.Id', '=', 'otpsender.DefaultSmsc' )
        ->orderBy('id', 'desc')->get();

        return view('User.otp_section', compact('data'));
    }

    public function Black_Keyword(Request $request)
    {
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
       }
    	 if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        $Bkeyworddata=array('BlackKeyword'=> TRIM($request->blackKeyword),
         'DateTime'=>time(), 
         'Status'=>1);

         if($request->id && $request->id != ""){
			DB::table('otpblackkeywords')->where('Id', $request->id)->update($Bkeyworddata);



		}else{
			DB::table('otpblackkeywords')->insert($Bkeyworddata);
		}

    //   $this->db->insert('otpblackkeywords', $Bkeyworddata);

      return redirect()->back();

    }

    

    public function otp_sender(Request $req)
    {
        $data = array(
			'OtpSender' => $req->otpsender,
			'OtpContent' => $req->otpcontent,
			'Description' => $req->description,
			
		);
        // dd ($data);

		if($req->id && $req->id != ""){
			DB::table('otpsender')->where('id', $req->id)->update($data);



		}else{
			DB::table('otpsender')->insert($data);
		}

         $BlackKeywords = DB::table('otpsender')->get();
           $array=array();
              foreach ($BlackKeywords as $key) {
                $array[]=$arrayName = array('sender' => $key->OtpSender,'msgdata' => $key->OtpContent);
                  
              }

     $myfile = fopen("rabbit/otpuser/RCrandom.json", "w") or die("Unable to open file!");
     fwrite($myfile, json_encode($array));
     fclose($myfile);


        return redirect("Otp_Section");
    }

    public function delete_otp_sender($id){
    	if(!session()->has('IsLoggedIn')){
            return redirect('/');
       }
    	 if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
		DB::table('otpsender')->where('Id', $id)->delete();

        
         $BlackKeywords = DB::table('otpsender')->get();
           $array=array();
              foreach ($BlackKeywords as $key) {
                $array[]=$arrayName = array('sender' => $key->OtpSender,'msgdata' => $key->OtpContent);
                  
              }

             $myfile = fopen("rabbit/otpuser/RCrandom.json", "w") or die("Unable to open file!");
             fwrite($myfile, json_encode($array));
             fclose($myfile);

        return redirect()->back();
        // return redirect("Otp_Section");
    }

}
