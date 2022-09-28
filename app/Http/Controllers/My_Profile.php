<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



use App\Models\My_ProfileModel;
use Hash;
use HasFactory;
use Auth;


class My_Profile extends Controller
{
    public function My_Profile()
    {

        if (!session()->has('IsLoggedIn')) {

            return redirect('/');
        }

        $user_id = Session::get('Id');
        $users = DB::table('users')->where('Id', $user_id)->get();

        return view('My_Profile.my_profile', compact('users'));
    }


    


    public function update_Password(Request $request)
    {
        if (!session()->has('IsLoggedIn')) {

            return redirect('/');
        }

        // $user = users::find($id);
        // if (Hash::check('passwordToCheck', $user->Password)) {
        // // Success
        // }


        $CurrentPassword = $request->CurrentPassword;
        $NewPassword = $request->NewPassword;
        $ConfirmPassword = $request->ConfirmPassword;
        if ($NewPassword == $ConfirmPassword) {
            $data = array('Password' => $request->NewPassword);

            DB::table('users')->where('id', $request->Id)->update($data);

            return redirect()->back();
        }
    }
}
