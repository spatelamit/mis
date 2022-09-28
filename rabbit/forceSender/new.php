<?php
function valiDateMTdata($message){
   $data=json_decode($message->body,true);
   $NewOtpContent['status'] =1;
		// Sender ID Ratio	   
	   $SenderId = ratioSenderId($data['sms']['sender']);
	    if($SenderId){
	    	$count = $SenderId;
	    }
 		// Check Blacklist, Whitelist, Is Spam etc
       $IsFake = rand($count, 0);
	   $dlr_mask=923;
	   $IsBlacklistSender = IsBlacklistSender($data['sms']['sender']);
	   $IsBlacklistNumber = IsBlacklistNumber($data['sms']['receiver']);
	   if($IsBlacklistSender || $IsBlacklistNumber ){
			$IsFake = 1;
			$dlr_mask=2;
	   }else{
		   $IsWhiteListNumber = IsWhiteListNumber($data['sms']['receiver']);
		   $IsWhiteSender = IsWhiteSender($data['sms']['sender']);
		   if($IsWhiteList || $IsWhiteSender){
		   		$IsFake = 0;
		   }
	   }

if($IsFake==1){
   //Is Fake or REJECT/BLACKLIST/SPAM
	foreach ($data as $key => $value) {
 		$NewSms['sms'] = $value;
	 	 if($value['smsc_id']){
				$NewSms['sms']['smsc_id'] = "WAITING";
			}
		}	
	$NewSms = json_encode($NewSms);
###################################
	 if($dlr_mask==2){
		$sms ='{
			"sms": {
			"sender": "'.$data['sms']['sender'].'",
			"receiver": "'.$data['sms']['receiver'].'", 
			"msgdata": "", 
			"time": '.$data['sms']['time'].', 
			"smsc_id": "FAILED_SMSC", 
			"foreign_id": "'.$data['sms']['dlr_url'].'", 
			"service": "'.$data['sms']['service'].'", 
			"account": "'.$data['sms']['account'].'",
			"charset": "'.$data['sms']['charset'].'", 
			"id": "'.$data['sms']['id'].'", 
			"sms_type": 3, 
			"dlr_mask": '.$dlr_mask.', 
			"dlr_url": "'.$data['sms']['dlr_url'].'", 
			"boxc_id": "'.$data['sms']['boxc_id'].'", 
			"meta_data": "'.$data['sms']['meta_data'].'"
			}
		}';
    	$ExChange = 'kannel.down.send.ex';
		send_message($sms, $ExChange);
	}
###################################
 // Q7 Down Stream exchange
 	}else{
 	    foreach ($data as $key => $value) {
	 		$NewSms['sms'] = $value;
 			$NewSms['sms']['dlr_mask'] = 923;
	 		if($value['smsc_id']){
	 			$smsc = smsc_routing_upstream($value['service']);
				$NewSms['sms']['smsc_id'] = $smsc;
			}


	


			if($value['service']){
	 			$otpuser = checkIsOtpUser($value['service']);
	 			if($otpuser){
	 				
	 				$NewOtpContent = maniPulateOtpContent($value['msgdata']);
	 				if($NewOtpContent['Status']==1){
	 					$otp = $NewOtpContent['NewMsgData'];
	 						 $RandomData = getRandomSenderContent($otp);
	 						 $RContent = $RandomData['msgdata'];
	 						 $RSender = $RandomData['sender'];

	 					 $NewSms['sms']['msgdata'] = $RContent;
		 				 $NewSms['sms']['sender'] = $RSender;
	 				  	 $NewSms['sms']['coding'] = 0;

	 				}else{
	 					 $NewSms['sms']['msgdata'] = $value['msgdata'];
		 				 $NewSms['sms']['sender'] = "SMSMSG";
		 				 $NewSms['sms']['smsc_id'] = "directself";
		 				 insertSpamContent($value);

	 				}
	 				// $NewSms['sms']['msgdata'] = $NewOtpContent['msgdata'];
	 				// $NewSms['sms']['sender'] = "TXTOTP";
	 				
	 				// if($NewOtpContent['status']==0){
		 			// 	 $NewOtpContent5 = maniPulateOtpContent2($value['msgdata'], $value);
		 			// 	 $NewSms['sms']['msgdata'] = $NewOtpContent5;
	 				// }
	 			}
				
			}

			########### Sender ID Override / Force Sender Id ##############
				#########   User Approved Sender #########
			$ApprovedStatus = CheckUserApprovedStatus($value['service']);

			if($ApprovedStatus==1){
				 $ApprovedSender = CheckUserApprovedSender($value['sender']);
				
				if($ApprovedSender==1){

				}else{
					if($value['service']=='bulksms24'){
						$NewSms['sms']['sender'] = "TXTSMS";
							
					}else{
						$NewSms['sms']['sender'] = "TXTALR";
					}
					
				}

				$NewSms['sms']['sender']  = forceSenderOverride($value['service'],  $NewSms['sms']['sender']);

			}
			#########   User Approved Sender #########

			########### Sender ID Override / Force Sender Id ##############


 		}	
 		
 			 // kannel.up.receive.ex  IS Q2 Up stream exchange
		 $NewSms = json_encode($NewSms);
		 $ExChange = 'kannel.up.receive.ex';
		 send_message($NewSms, $ExChange);

}
// if($NewOtpContent['status']==0){
// 	echo  $NewSms;
// }
	//Q5 MT Insertion Fake and Originals Both
	$MysqlExChange = 'mysql.mt.insert.ex';
	mysql_mt_insert($NewSms, $MysqlExChange);
}







	########### Sender ID Override / Force Sender Id ##############

	function forceSenderOverride($username, $sender){
	    $file = '/home/smppuser/public_html/rabbit/forceSender/forceSender.json';
	    if(file_exists($file)){
	    $file_content = file_get_contents($file);
	        $json_data = json_decode($file_content, true);
	            $overRide = 0;
	        foreach ($json_data as $key => $value) {
	            if ($username==$value['Username']) {
	                $overRide = 1;
	               return $value['ForceSender'];
	            }
	            # code...
	        }
	        if($overRide!=1){
	            return  $sender;
	        }
	    }else{
	        return $sender;
	    }
	}
	########### Sender ID Override / Force Sender Id ##############


############### Sender Id Approval case User Wise ########################

function CheckUserApprovedStatus($username){

 $file = '/home/smppuser/public_html/rabbit/Userapproved/approvedstatus.json';
if(file_exists($file)){
$file_content = file_get_contents($file);
 $json_data = json_decode($file_content, true);
	if (in_array($username, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
  }else{
	return false;
 }
}

function CheckUserApprovedSender($Sender){

 $file = '/home/smppuser/public_html/rabbit/Userapproved/userapprovedsender.json';
if(file_exists($file)){
$file_content = file_get_contents($file);
 $json_data = json_decode($file_content, true);
	if (in_array($Sender, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
  }else{
	return false;
 }
}


############### Sender Id Approval case User Wise ########################


######### WE FOR OTP MANIPULATION ##############



function maniPulateOtpContent($OtpContent){
 
    $OldMsg = preg_replace( "/\r|\n/", " ", $OtpContent);
    $tpl = " [UVideo]";
	//$OtpContent = str_replace('[UVideo]', $tpl, $OtpContent);
	$OldMsg = str_replace('[UVideo]', $tpl, $OtpContent);
	//$OtpContent = str_replace('码', " 码 ", $OtpContent);
	$OldMsg = str_replace('码', " 码 ", $OtpContent);




    $wordsArray =  json_decode(strtolower(json_encode(array("verification","code","confirmation","verify","confirm", "code:", "activation","कोड","कन्फ़र्मेशन","प्रमाणीकरण", "code.","પુષ્ટિકરણ","પુષ્ટિ","passcodes","passcodes:", "passcodes","OTP:","authentication","two-factor","કોડ", "स्वीकृती","otp","<#>OTP","passcode","password","কোড","কোড।","குறியீடாகும்","Googleप्रमाणीकरणकोड","కోడ్","నిర్ధారణ","kode","സ്ഥിരീകരണ","കോഡ്","कोड:","குறியீடு:","કોડ:","ಕೋಡ್:","ਕੋਡ:","কোড:","kodun","رمز","కోడ్:","ಕೋಡ್","کوڈ","ਕੋਡ","குறியீடாகும்.","କୋଡ୍‌", "കോഡാണ്","പാസ്‌വേഡ്","ক'ড","ଅଟେ","One-Time-Passcode","PIN","PASSCODE:","കോഡ്:","Kod","Код","Cod","Kodu:","Código","codigo","Snapping!","Snapping","OTP。","کد", "account", "password,","Lark,","[UVideo]","UVideo","OTP.","confidential.","(OTP).","One-time","कन्फर्म","Facebook-kode","குறியீ","confirm,","code","குறியீடு","verifikasi","Likee","<#>Likee","码", "सत्यापित","Facebook-aanmeldkode.","କୋଡ଼","codice","koduyla","verificar","توثیق"))),true);

   // print_r($wordsArray);

      

    $ContentArray = explode(" ", strtolower($OldMsg));
        //print_r($ContentArray);

    $result  = array_intersect($wordsArray, $ContentArray);
    if(sizeof($result)>0){
        // $NewMsg  = $this->keywordReplacer($OtpContent);
        // $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";

        // $NewMsg  = preg_replace($regex, ' ', $NewMsg);
        // print_r($NewMsg);
        //die;
          $arrayName =   numericChcker($OldMsg, $NewMsg);


        //echo $OtpContent;
        // $arrayName = array('OldMsg' => $OtpContent,
        //                     'NewMsg' => $NewMsg,
        //                     'Status' => 1);
                return $arrayName;
    } else{
        $arrayName = array('OldMsgData' => $OldMsg,
                            'NewMsgData' => 0,
                            'Status' => 0);
                return $arrayName;

    } 
}





function numericChcker($OldMsg, $NewMsg){

    $dataMsg =  explode(' ', $OldMsg);

    $data= array();
    preg_match_all('!\d+!', $OldMsg, $matches);
      $i = 0;
      //print_r($matches[0]);
      foreach ($matches[0] as $key => $value) {
        if(strlen($value)>=3){
        $newArray[] = $value;
        }
          # code...
      }
      
      $OtpType = 0;

      foreach ($newArray as $key => $value) {
         if(strlen($value)==3){ $OtpType =1; if($i<=1){   $data[]  =$value; 
          
         } }
         if(strlen($value)>3){ if($i<=0){  $data[]  =$value; } }
        $i++;
      }

    $newotp = implode(" ", $data);

      if($OtpType==1){
        
        if(sizeof($data)==1){
        print_r(($data));
          echo sizeof($data);
            $newotp = 0;
        } 

      }


    if($newotp!=""){
        
                $newotp = implode(" ", $data);

                $Newcontent = $newotp;
                $NewMsg  =$Newcontent;
         $arrayName = array('OldMsgData' => $OldMsg,
                            'NewMsgData' => $NewMsg,
                            'Status' => 1);
              

    }else{

    	 $fbarray  = explode(" " , strtolower($OldMsg));
        if(sizeof($fbarray)==5){
            if($fbarray[1]=="is" &&  $fbarray[2]=="your" && $fbarray[3]=="facebook" && $fbarray[4]=="code" ){
                $Newcontent = $fbarray[0];
                $NewMsg  =$Newcontent;
         $arrayName = array('OldMsgData' => $OldMsg,
                            'NewMsgData' => $NewMsg,
                            'Status' => 1);
              
            }
          }
          else{
          $arrayName = array('OldMsg' => $OldMsg,
                            'NewMsg' => 0,
                            'Status' => 0);
                }


        // $arrayName = array('OldMsgData' => $OldMsg,
        //                     'NewMsgData' => 0,
        //                     'Status' => 0);
               

    }
     return $arrayName;
    //return $Newcontent = "Your verification code : " .$newotp;
}



function getRandomSenderContent($Otp){
	$file = '/home/smppuser/public_html/rabbit/otpuser/RCrandom.json';
	if(file_exists($file)){
		$file_content = file_get_contents($file);
		$array = json_decode($file_content, true);
		$Index = array_rand($array);
  		$Data = $array[$Index];


  		$msgdata = str_replace('##OTP##', $Otp, $Data['msgdata']);

  		return $result  = array('sender' => $Data['sender'],
  								'msgdata' => $msgdata 
  							);
	}
}




function getRandomSender()
{
 $file = '/home/smppuser/public_html/rabbit/otpuser/rsender.json';
if(file_exists($file)){
	$file_content = file_get_contents($file);
	$array = json_decode($file_content, true);
}else{

	$array  =array('TXTAPP');
}
if(sizeof($array)<1){
	$array  =array('TXTAPP');

}

$section = array_rand($array);
return $sender = $array[$section];

}




function getRandomContent()
{
 $file = '/home/smppuser/public_html/rabbit/otpuser/rcontent.json';
if(file_exists($file)){
	$file_content = file_get_contents($file);
	$array = json_decode($file_content, true);
}else{

	$array  =array('is your OTP , Please do not share this with anyone. Thank You!');
}
if(sizeof($array)<1){
	$array  =array('is your OTP , Please do not share this with anyone. Thank You!');

}

$section = array_rand($array);
return $sender = $array[$section];

}



// function maniPulateOtpContent2($OtpContent, $value){

// 	insertSpamContent($value);

// 		preg_match_all('!\d+!', $OtpContent, $matches);
// 			$i = 0;
// 			foreach ($matches[0] as $key => $value) {
// 				 if(strlen($value)==3){ if($i<=1){	 $data[]  =$value; } }
// 				 if(strlen($value)>3){ if($i<=0){	 $data[]  =$value; } }
// 			 	$i++;
// 			}
// 		$newotp = implode(" ", $data);
// 		return $Newcontent = "Your verification code : " .$newotp;
// }






function checkIsOtpUser($username){

 $file = '/home/smppuser/public_html/rabbit/otpuser/otpuserlist.json';
if(file_exists($file)){
$file_content = file_get_contents($file);
 $json_data = json_decode($file_content, true);
	if (in_array($username, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
  }else{
	return false;
 }
}






function smsc_routing_upstream($username){
	$file = '/home/smppuser/public_html/rabbit/esme/'.$username.'.json';
	if(file_exists($file)){
	$file_content = file_get_contents($file);
		$json_data = json_decode($file_content, true);
		$smsc = array_search($username,$json_data);
		if($smsc){
			return $smsc;
		}else{
			// RETURN PERMANENT SMSC If FILE NOT EXISTS
			return "tester";
		}
	}else{
		return "tester";
	}
}


function IsBlacklistSender($sender){
 $file = '/home/smppuser/public_html/rabbit/blacklist/blacksenders.json';
if(file_exists($file)){
$file_content = file_get_contents($file);
 $json_data = json_decode($file_content, true);
	if (in_array($sender, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
  }else{
	return false;
 }
}

function IsBlacklistNumber($number){
$file = '/home/smppuser/public_html/rabbit/blacklist/blacklistnumbers.json';
if(file_exists($file)){
$file_content = file_get_contents($file);
 $json_data = json_decode($file_content, true);
	if (in_array($number, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
	}
  {
  	return false;
  }
}




// Check Ratio  User Wise 
function ratioSenderId($SenderId){
	$file = '/home/smppuser/public_html/rabbit/senderid/'.strtoupper($SenderId).'.json';
	if(file_exists($file)){
		$file_content = file_get_contents($file);
		$json_data = json_decode($file_content, true);
			$Ratio = array_search('Ratio', $json_data);
			 if($Ratio){
			 	return $Ratio;
			 }else{
			 	// RETURN 0 If RATIO FILE NOT EXISTS FOR RATIO
			 	return 0;
			 }
		   }
		   else {
	  			return 0;
	  		}
}

function IsWhiteListNumber($number){
	$file = '/home/smppuser/public_html/rabbit/whitelist/whitenumbers.json';
	if(file_exists($file)){
		 $file_content = file_get_contents($file);
		 $json_data = json_decode($file_content, true);
		if (in_array($number, $json_data))
		  {
			 return true;
		  }
		else
		  {
		  	return false;
		  }
		}else{
			return false;
		}
}


function IsWhiteSender($sender){
$file = '/home/smppuser/public_html/rabbit/whitelist/whitesenders.json';
if(file_exists($file)){
 $file_content = file_get_contents();
 $json_data = json_decode($file_content, true);
	if (in_array($sender, $json_data))
	  {
		 return true;
	  }
	else
	  {
	  	return false;
	  }
	}else{
		return false;
	}
}

function insertSpamContent($message){
	$sender = $message['sender'];
	$receiver = $message['receiver'];
	$msgdata = $message['msgdata'];
	$time = $message['time'];
	$service = $message['service'];
	$dlr_url = $message['dlr_url'];

	$conn = mysqli_connect('p:localhost', 'syssmpp', 'SeCuRe@LocalHost#890','smppdb');

	if (!$conn) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		return false;
	    exit;
	}else{

	  $query = "INSERT INTO `smpp_spam_content` (`SenderId`, `receiver`, `msgData`, `time`, `service`, `dlr_url`) VALUES ( '".$sender."',  '".$receiver."',  '".bin2hex($msgdata)."',  '".$time."', '".$service."' , '".$dlr_url."') ";


	  if(mysqli_query($conn , $query)){
			return true;
		}
		mysqli_close($conn);
	}

}


function insertSmppMessagesMysql($message){

// echo "\n\n------\n\n";
// echo $message;
// echo "\n\n------\n\n";

$data = json_decode($message);
$sender  = $data->sms->sender;
$receiver  = $data->sms->receiver;
$udhdata  = $data->sms->udhdata;
$msgdata  = $data->sms->msgdata;
$time  = $data->sms->time;
$smsc_id  = $data->sms->smsc_id;
$service  = $data->sms->service;
$account  = $data->sms->account;
$id  = $data->sms->id;
$compress  = $data->sms->compress;
$sms_type  = $data->sms->sms_type;
$coding  = $data->sms->coding;
$dlr_mask  = $data->sms->dlr_mask;
if($dlr_mask=="" ||  $dlr_mask==0 ){
	$dlr_mask=923 ;
}
$dlr_time  = 0;
$dlr_url  = $data->sms->dlr_url;
$pid  = $data->sms->pid;
$alt_dcs  = $data->sms->alt_dcs;
$charset  = $data->sms->charset;
$boxc_id  = $data->sms->boxc_id;
$binfo  = "xyz";
$priority  = $data->sms->priority;
$meta_data = $data->sms->meta_data;
$foreign_id = $data->sms->id;
$msg_length   = 0;
$dlr_receipt = bin2hex('Submit');
 
	$conn = mysqli_connect('p:localhost', 'syssmpp', 'SeCuRe@LocalHost#890','smppdb');

	if (!$conn) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		return false;
	    exit;
	}else{

if($sender=="2,3BHK"){
		$sender = "23BHK";
}

	// $query = "INSERT INTO `smpp_sent_pdus` (`sender`, `receiver`, `udhdata`, `msgdata`, `time`, `smsc_id`, `service`, `account`, `id`, `sms_type`, `coding`, `dlr_mask`, `dlr_time`, `dlr_url`,  `foreign_id`) VALUES ( '".$sender."',  '".$receiver."',  '".$udhdata."',   '".bin2hex($msgdata)."',  '".$time."',  '".$smsc_id."', '".$service."', '".$account."',  '".$id."',  '".$sms_type."',  '".$coding."', '".$dlr_mask."', '".$dlr_time."', '".$dlr_url."', '".$foreign_id."') ";

$query = "call  	prc_insert_smpp_sent_pdus ( '".$sender."',  '".$receiver."',  '".$udhdata."',   '".bin2hex($msgdata)."',  '".$time."',  '".$smsc_id."', '".$service."', '".$account."',  '".$id."',  '".$sms_type."',  '".$coding."', '".$dlr_mask."', '".$dlr_time."',  '".$dlr_receipt."','".$dlr_url."', '".$foreign_id."') ";

// if(strlen($receiver)>=15 || strlen($receiver)<=5){
// 				return true;

// }




	// $NewQuery = "INSERT INTO `smpp_sent_pdus` (`sender`, `receiver`, `udhdata`, `msgdata`, `time`, `smsc_id`, `service`, `sms_type`, `coding`, `dlr_mask`, `dlr_time`,`dlr_receipt`, `dlr_url`, ) VALUES ( '".$sender."',  '".$receiver."',  '".$udhdata."',   '".bin2hex($msgdata)."',  '".$time."',  '".$smsc_id."', '".$service."','".$sms_type."',  '".$coding."', '".$dlr_mask."', '".$dlr_time."',  '".$dlr_receipt."', '".$dlr_url."') ";

// if($smsc_id=='SPAMCONTENT'){
	echo  "\n------\n";
	echo $query;
	echo  "\n------\n";
// 	echo $smsc_id;
// 	}

	  if(mysqli_query($conn , $query)){
			return true;
		}
		 else{
		// $queryBounce = "UPDATE smpp_sent_pdus SET  `udhdata`  = '".$udhdata."' WHERE dlr_url = '".$dlr_url."' " ;
		// 	if(mysqli_query($conn , $queryBounce)){
		// 		return true;
		// 	}else
		// 	{
		  		return false;	
		  	// }
		  }
		mysqli_close($conn);
	}
}


function updateSmppMessagesMysql($message){

// echo "\n\n------\n\n";
// echo $message;
// echo "\n\n------\n\n";
 
 $data = json_decode($message);
 $sender  = $data->sms->sender;
 $receiver  = $data->sms->receiver;
 $udhdata  = $data->sms->udhdata;
 $msgdata  = $data->sms->msgdata;
 $time  = $data->sms->time;
 $smsc_id  = $data->sms->smsc_id;
 $service  = $data->sms->service;
 $account  = $data->sms->account;
 $id  = $data->sms->id;
 $sms_type  = $data->sms->sms_type;
 $compress  = $data->sms->compress;
 $coding  = $data->sms->coding;
 if($coding==""){
     $coding = 0;
 }
 $dlr_mask  = $data->sms->dlr_mask;
 $dlr_receipt  = $data->sms->msgdata;

 $dlr_time  = $data->sms->time;
 $dlr_url  = $data->sms->dlr_url;
 $pid  = $data->sms->pid;
 $alt_dcs  = $data->sms->alt_dcs;
 $charset  = $data->sms->charset;
 $boxc_id  = $data->sms->boxc_id;
 $binfo  = "xyz";
 $priority  = $data->sms->priority;
 $meta_data = $data->sms->meta_data;
 $foreign_id = $data->sms->foreign_id;
 $msg_length   = 0;

	$conn = mysqli_connect('p:localhost', 'syssmpp', 'SeCuRe@LocalHost#890','smppdb');
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	return false;
    exit;
}else{
  sleep(0.9);

 
$id = md5(uniqid('', true));
      // $query = "INSERT INTO `smpp_sent_pdus_dlr` (`sender`, `receiver`,  `time`, `smsc_id`, `service`,  `id`,  `dlr_mask`, `dlr_receipt`, `dlr_url`,`foreign_id`) VALUES ( '".$sender."',  '".$receiver."',   '".$time."',  '".$smsc_id."', '".$service."',   '".$UUid."',   '".$dlr_mask."',  '".bin2hex($dlr_receipt)."', '".$dlr_url."', '".$foreign_id."') ";
      
  
  $query = "call  prc_insert_smpp_sent_pdus_dlr( '".$sender."',  '".$receiver."',  '".$time."',  '".$smsc_id."', '".$service."',   '".$id."',   '".$dlr_mask."',   '".bin2hex($dlr_receipt)."','".$dlr_url."', '".$foreign_id."') ";



  if($smsc_id=="VIDEOCON_PRE"){
  	$dlr_receipt = bin2hex('Delivered');

  	// I AM RUNS IN CASE OF FAKE PUSH DLR
		 $query =  "UPDATE smpp_sent_pdus SET  `dlr_mask`  = 1, `dlr_time` = '".$dlr_time."', `dlr_receipt` = '".$dlr_receipt."', `smsc_id` = '".$smsc_id."'  WHERE dlr_url = '".$dlr_url."' and dlr_mask != 1 " ; 
		 // echo "\n--------\n";
  //echo $query;
  ///echo "\n--------\n";
  }

   echo "\n--------\n";
   echo $query;
   echo "\n--------\n";
  

$Update = mysqli_query($conn , $query);
if($Update){
	 return true;
  }else{
  		 $queryBounce2 = "UPDATE smpp_sent_pdus SET  `dlr_mask`  = '".$dlr_mask."' WHERE dlr_url = '".$dlr_url."' " ;
  		//echo $dlr_mask."\n";
			if(mysqli_query($conn , $queryBounce2)){
				return true;
			}else
			{
				return false;	
			}
  }
 mysqli_close($conn);
 }
}
 
 
 
 
// // Check Ratio  User Wise 
// function ratioESME($username){
// 	$file_content = file_get_contents('esme/'.$username.'.json');
// 	$json_data = json_decode($file_content, true);
// 	$Ratio = array_search('Ratio', $json_data);
// 	 if($Ratio){
// 	 	return $Ratio;
// 	 }else{
// 	 	// RETURN 0 If RATIO FILE NOT EXISTS FOR RATIO
// 	 	return 0;
// 	 }
// }



// function IsSpamContent($message){
// 	$file_content = file_get_contents('blacklist/blackcontent.json');
// 	$arrayDBsPam = json_decode(strtolower($file_content), true);
// 	$arrayMsg =  explode(' ', strtolower($message));

// 	$TotalMatch = array_intersect($arrayMsg, $arrayDBsPam);
//     $TotalMatch  = count($TotalMatch);
//     //$arrayDBsPam  = count($arrayDBsPam);
//     //$final  =  $TotalMatch/$arrayDBsPam*100;

//  if ($TotalMatch>3)
//   {
// 	 return true;
//   }
// else
//   {
//   	return false;
//   }
// }

// DELETE FROM `send` WHERE msg_timestamp BETWEEN 1 and 1575158399 LIMIT 1000 


?> 