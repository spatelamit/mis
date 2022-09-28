<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report;
use App\Http\Controllers\Kannel;
use App\Http\Controllers\Users;
use App\Http\Controllers\Smpp_User;
use App\Http\Controllers\Repush;
use App\Http\Controllers\Whitelist;
use App\Http\Controllers\smsc;
use App\Http\Controllers\My_Profile;




//login
Route::get('/', [Users::class, 'login']);





Route::group(['middleware' => 'prevent-back-history'],function(){

	Route::post('/loginAction', [Users::class, 'loginAction']);

	Route::get('/logout', [Users::class, 'logout']);

	Route::get('/dashboard', [Users::class, 'dashboard']);


	// Report Section
	Route::get('/report', [Report::class, 'report']);

	Route::get('/report_data/{tab}', [Report::class, 'report_data']);

	Route::get('/deliveryreport', [Report::class, 'deliveryreport']);
	Route::post('/deliveryreportpdu', [Report::class, 'deliveryreportpdu']);
	Route::get('/summeryhistory', [Report::class, 'summeryhistory']);

	Route::post('/reportlist', [Report::class, 'reportlist']);


	Route::get('/upload_errorcode_csv', [Report::class, 'upload_errorcode_csv']);
	Route::post('/csv_upload_data', [Report::class, 'csv_upload_data']);
	Route::get('/reportdelete/{id}', [Report::class, 'reportdelete']);
	Route::get('/exportdeliveryreport', [Report::class, 'exportdeliveryreport']);

	
	//Kannel Section 
	Route::get('/kannel/{tab}', [Kannel::class, 'kannel']);


	Route::get('/kannel_status', [Kannel::class, 'kannel_status']);

	Route::get('/health_checker', [Kannel::class, 'health_checker']);

	Route::get('/kannel_data/{tab}', [Kannel::class, 'kannel_data']);



	Route::get('/ajaxrabbit', [Kannel::class, 'ajaxrabbit']);
	Route::get('/ajaxsmppbox', [Kannel::class, 'ajaxsmppbox']);
	Route::get('/ajaxupstream', [Kannel::class, 'ajaxupstream']);

	Route::get('/smppbox', [Kannel::class, 'smppbox']);
	Route::get('/smsctraffic', [Kannel::class, 'smsctraffic']);
	Route::get('/sendertraffic', [Kannel::class, 'sendertraffic']);

	Route::post('/getsenderdata', [Kannel::class, 'getsenderdata']);
	Route::post('/getsmscdata', [Kannel::class, 'getsmscdata']);

	// Smpp User


	Route::get('/smpp_user', [Smpp_User::class, 'smpp_user']);


	Route::get('/smpp_users_data/{tab}', [Smpp_User::class, 'smpp_users_data']);
	Route::post('/savesmppuser', [Smpp_User::class, 'savesmppuser']);
	Route::get('/usereyeview/{user_id}', [Smpp_User::class, 'usereyeview']);
	Route::get('/editsmppuser/{user_id}',[Smpp_User::class,'editsmppuser']);
	Route::post('/Updatesmppuser', [Smpp_User::class, 'Updatesmppuser']);
    Route::get('/smppusersavedailycounts', [Smpp_User::class, 'smppusersavedailycounts']);
	
	Route::post('/changeRouting', [Smpp_User::class, 'changeRouting']);



	// Repush

	Route::get('/repush', [Repush::class, 'repush']);
	Route::post('/getrepushdata', [Repush::class, 'getrepushdata']);



	// whitelist

	Route::get('/whitelist', [Whitelist::class, 'whitelist']);

	Route::get('/whitelist_data/{tab}', [Whitelist::class, 'whitelist_data']);

	Route::get('/deletesenderratio/{id}/{senderId}', [Whitelist::class, 'deletesenderratio']);
	Route::post('/savesenderratio', [Whitelist::class, 'savesenderratio']);
	Route::post('/add_whitelist_number',[Whitelist::class,'add_whitelist_number']);
	Route::post('/add_AUSenderId',[Whitelist::class,'add_AUSenderId']);
    Route::post('/add_Forcesender',[Whitelist::class,'add_Forcesender']);
	
	Route::get('/deletewhitelistnumber/{id}', [Whitelist::class, 'deletewhitelistnumber']);
	Route::get('/deleteAUSenderId/{id}', [Whitelist::class, 'deleteAUSenderId']);
	Route::get('/deleteForceSender/{id}', [Whitelist::class, 'deleteForceSender']);
	// Route::get('/approvedUserSender', [Whitelist::class, 'approvedUserSender']);


	// Route::get('/forceSender', [Whitelist::class, 'forceSender']);
	// Route::get('/errorCode', [Whitelist::class, 'errorCode']);
	// Route::get('/mmOperators', [Whitelist::class, 'mmOperators']);

	// Route::get('/userControlHistory', [Whitelist::class, 'userControlHistory']);
	
    // Balance
	Route::get('/Balance', [Users::class, 'Balance']);
	Route::post('/updatebalance', [Users::class, 'updatebalance']);
	Route::get('/BalanceHistory', [Users::class, 'BalanceHistory']);
	//Smsc
	Route::get('/smsc',[Smsc::class,'Index']);
	Route::post('/smscsave',[Smsc::class,'smscSave']);
	Route::get('/smscgetdata',[Smsc::class,'SmscGetData']);
	// Route::get('/smscedit/{id}',[Smsc::class,'smscEdit']);
	Route::post('/updatesmsc',[Smsc::class,'updatesmsc']);
	Route::get('deletesmsc/{id}', [Smsc::class, 'deletesmsc']);
    
    // My Profile
    Route::get('/my_profile',[My_Profile::class,'My_Profile']);

    // Route::get('/update_Password',[My_Profile::class,'updatePasswordPage']);
	Route::post('/update_Password',[My_Profile::class,'update_Password']);


	// Error_code
	Route::get('/error_cods',[Report::class,'error_cods']);
	Route::post('/add_error_code',[Report::class,'add_error_code']);
	Route::get('/edit_error_code/{id}',[Report::class,'edit_error_code']);
	Route::get('delete/{id}', [Report::class, 'delete']);

    
	//Dlt_Mmq_Operator
	Route::get('/Dlt_Mmq_Operator', [Users::class, 'Dlt_Mmq_Operator']);
	Route::post('/import-csv',[Users::class, 'store']);

	//smpp_user_controller_history
	Route::get('/User_Controller_History', [Users::class, 'User_Controller_History']);
	

	//Otp_Section
	Route::get('/Otp_Section', [Users::class, 'Otp_Section']);
	Route::post('/otp_sender', [Users::class, 'otp_sender']);
	Route::get('delete_otp_sender/{id}', [Users::class, 'delete_otp_sender']);
	Route::post('/Black_Keyword', [Users::class, 'Black_Keyword']);
	


	//Bad Data collection
	Route::get('/BadData', [Whitelist::class, 'BadData']);
	Route::post('/add_bad_data', [Whitelist::class, 'add_bad_data']);
    Route::get('/deletebaddata/{mobile}', [Whitelist::class, 'delete_bad_data']);
	
});

