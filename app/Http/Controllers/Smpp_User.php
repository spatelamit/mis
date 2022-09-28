<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

use App\Models\Smpp_UserModel;

class Smpp_User extends Controller{


	public function smpp_user(){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        $Smpp_UserModel = new Smpp_UserModel;
        $getAllMembers =  $Smpp_UserModel->getSmppUsers();
        $SmscList =  $Smpp_UserModel->getSmscList();


        return view('/Smpp_User/smpp_user',compact('SmscList', 'getAllMembers'));
	}

	public function smpp_users_data($tab){
		if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }

        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }	

		$Smpp_UserModel = new Smpp_UserModel;

       

		if ($tab == 'addUsers') {
			$data = $Smpp_UserModel->getSmscList();
        	return view('/Smpp_User/addsmppuser', compact('data'));
		}
		elseif ($tab == 'usersList') {
			$data =  $Smpp_UserModel->getSmppUsers();
			return view('/Smpp_User/usersList', compact('data'));
		}
		elseif ($tab == 'routing') {
			$SmscList =  $Smpp_UserModel->getSmscList();
    		$getAllMembers =  $Smpp_UserModel->getSmppUsers();
        	return view('/Smpp_User/routing', compact('SmscList', 'getAllMembers'));
		}
	}

	public function savesmppuser(Request $req){
		if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }

        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }

        $Smpp_UserModel = new Smpp_UserModel;

        $Smpp_UserModel->saveUser($req);
      	 return redirect('smpp_user');
	}


	public function usereyeview($user_id){
		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        $Smpp_UserModel = new Smpp_UserModel;
        $data = $Smpp_UserModel->getSmppUserDetails($user_id);

        return view('/Smpp_User/usereyeview', compact('data'));
	}

	public function changeRouting(Request $req){

		if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
        $Smpp_UserModel = new Smpp_UserModel;
       $result= $Smpp_UserModel->changeRouting($req);

        
    	
    	if($result){
      		
            return true;
    	}
    	
    	//redirect(base_url('routing'));
    }

    public function editsmppuser($id)
    {

        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }
         $users = DB::table('smpp_accounts')
            ->leftJoin('users', 'smpp_accounts.UserId', '=' , 'users.Id')
            // ->join('balance', 'smpp_accounts.UserId', '=' , 'balance.UserId')
            ->select('smpp_accounts.*','users.*')
            
            ->where('smpp_accounts.UserId', $id)
            ->first();
            // dd($users);

        return view('Smpp_User.edit_smpp_user', compact('users'));

    }


    public function Updatesmppuser(Request $req)
    {
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        if(session()->get('IsAdmin') != 'Y'){
           return redirect('/');
        }

        $Smpp_UserModel = new Smpp_UserModel;
        $result= $Smpp_UserModel->update_smpp_user($req);

       

            return redirect('smpp_user');
            
      		
            // return view('/Smpp_User/smpp_user');
        

    }
// SMPP Daily count strore ,Cron job chalegi
    public function smppusersavedailycounts()
  {
  
  
   $Date=date('2022-09-22',strtotime("-1 days"));
    $Smpp_UserModel = new Smpp_UserModel;
  
  $data=  $Smpp_UserModel->getCurrentCountsSummary($Date);
    $data1=  $Smpp_UserModel->getCurrentCountsSummary1($Date);
  // dd( $data1);
         $main=array();
        if($data){

          foreach ($data as $value) {
            $main[$value->service]['name']=$value->service;
            $main[$value->service][$value->dlr_mask]=$value->Count;
          }
          // dd($main);
         $data['saveSummery'] =  $Smpp_UserModel->saveUsersSummary($main, $Date);
        }else{
          echo "Records not found";
        }
    


  }
    

}



