<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SmscModel;

class smsc extends Controller
{
   public function Index(){
    if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
         $smsclist = DB::table('smsclist')->get();
         // dd($smsclist);

       return view('Smsc.smsc',compact('smsclist'));
    }

    public function smscSave(Request $req){

        if(session()->has('IsAdmin') != 'Y'){
            return redirect('/');
        }
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
        
         $SmscModel= new SmscModel;
         $data=  $SmscModel->smscS($req);
         if($data){

         return redirect('smsc');
         }
    }
     public function smscEdit($id){

         if(session()->has('IsAdmin') != 'Y'){
            return redirect('/');
        }
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }

         $user = smsclist::find($id);
        return view('Smsc.editsmsc',compact('user'));
    }

    public function updatesmsc(Request $req){


        // dd($req);

        if(session()->has('IsAdmin') != 'Y'){
            return redirect('/');
        }
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }

        $SmscModel = new SmscModel;
        $result= $SmscModel->update_smsc($req);
        return redirect()->back();

    }


     public function deletesmsc($id){
        if(session()->has('IsAdmin') != 'Y'){
            return redirect('/');
        }
        if(!session()->has('IsLoggedIn')){
            return redirect('/');
        }
  
       
       DB::table('smsclist')->where('Id',$id)->delete();
      
       return redirect()->back();
        

    }




}

