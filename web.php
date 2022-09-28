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

	
	Route::post('/changeRouting', [Smpp_User::class, 'changeRouting']);



	// Repush

	Route::get('/repush', [Repush::class, 'repush']);
	Route::post('/getrepushdata', [Repush::class, 'getrepushdata']);



	// whitelist

	Route::get('/whitelist', [Whitelist::class, 'whitelist']);

	Route::get('/whitelist_data/{tab}', [Whitelist::class, 'whitelist_data']);

	Route::get('/deletesenderratio/{id}', [Whitelist::class, 'deletesenderratio']);
	Route::post('/savesenderratio', [Whitelist::class, 'savesenderratio']);
	// Route::get('/approvedUserSender', [Whitelist::class, 'approvedUserSender']);


	// Route::get('/forceSender', [Whitelist::class, 'forceSender']);
	// Route::get('/errorCode', [Whitelist::class, 'errorCode']);
	// Route::get('/mmOperators', [Whitelist::class, 'mmOperators']);

	// Route::get('/userControlHistory', [Whitelist::class, 'userControlHistory']);
	
    // Balance
	Route::get('/Balance', [Users::class, 'Balance']);
	//Smsc
	Route::get('/smsc',[Smsc::class,'smsc']);
    
    // My Profile
    Route::get('/My_Profile',[My_Profile::class,'My_Profile']);
	

}); 



        
        
        
        
