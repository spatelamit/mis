<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/function.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
$connection_consume = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$connection_publish = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$connection_publish2 = new AMQPStreamConnection(MQ2_HOST, MQ2_PORT, MQ2_USER, MQ2_PASS);

$channel_consume = $connection_consume->channel();
$channel_publish = $connection_publish->channel();
$channel_publish2 = $connection_publish2->channel();

function send_message_down($message)
{
    global $channel_publish;
    global $channel_publish2;
    $data=json_decode($message->body,true);
         
    // if($data['sms']['service']=='newnumeric'){
    //     if($data['sms']['dlr_mask']==1 || $data['sms']['dlr_mask']==2){
    //         // echo "okok";
    //         // echo "\n";
    //         $data['sms']['dlr_mask']==8;
    //         //return true;
    //     }
    // }  
    //if($data['sms']['dlr_mask']!=8){
          
        // Publish MO msg To down stream 
        //$channel_publish->basic_publish($msg, 'mysql.mo.update.ex', '');

       //if($data['sms']['service']=='coderapp'){
        //$is_retry = 0;
            // if($data['sms']['dlr_mask']==2 && $data['sms']['receiver']==917697588851){
            //     $check_route = getRetryRoute();
            //     if($check_route!=$data['sms']['smsc_id']){
            //            $msg2 = retryFailedSms($check_route, $data, $data['sms']['dlr_url']);  
            //             if($msg2){
            //                 $is_retry = 1;
            //               echo   $msg2  = json_encode($msg2);
            //                 //$channel_publish->basic_publish($msg2, MT2_EX, '');
            //            } 
            //     }
            // }
           // echo "\n\n\n";
            // echo "\n-------\n";
            // echo $message->body;
            // echo "\n-------\n";
            // if($is_retry==0){
                // $channel_publish->basic_publish($msg, MO5_EX, '');  // bsspold data
            // }
        ///}else 

       
         

           // $is_retry = 0;
            $is_retry = false;

            if($data['sms']['dlr_mask']==2){
                $Pdu = explode(' ', $data['sms']['msgdata']); 
                $PduCode = explode(':', $Pdu[8]); 
                $PduCode = $PduCode[1];
                if($PduCode=='0032'){
                    echo $PduCode;
                    $is_retry = true;
                    echo "\n";
                }
              $is_retry = false;


                if($is_retry==true ){
                    //$data['sms']['dlr_mask']==2 &&

                    $check_route = getRetryRoute();
                    if($check_route!=$data['sms']['smsc_id']){
                           $msg2 = retryFailedSms($check_route, $data, $data['sms']['dlr_url']);  
                            if($msg2){
                                //$is_retry = 1;
                                
                                $msg2  = json_encode($msg2);
                                echo "\n-------\n";
                                echo $msg2;
                                echo "\n-------\n"; 

                                $fp = fopen('logs/sms-error-'.date('Y-m-d').'.txt', 'a');//opens file in append mode.
                                fwrite($fp, $msg2."\n\n");
                                fclose($fp);



                               $msg = new AMQPMessage($msg2);            
                               $channel_publish2->basic_publish($msg, MT2_EX, '');
                               //$channel_publish2->basic_publish($msg, "zz.amit.ex", '');
                               return true;
                           } 
                    }
                }
            }


     if($data['sms']['service']=='coderapp' || $data['sms']['service']=='routetest'  || $data['sms']['service']=='bsspapp'){
            
            // echo "\n-------\n";
            // echo $message->body;
            // echo "\n-------\n";
            $msg = new AMQPMessage($message->body);

            $channel_publish2->basic_publish($msg, MO6_EX, '');
            return true;
        }else{

            if($data['sms']['dlr_mask']==1 || $data['sms']['dlr_mask']==8){
                $msg = new AMQPMessage($message->body);
            }else{
                $NewDlrPdu =  manipulateDLRPDU($data);
                
                // echo "\n-------\n";
                // echo $NewDlrPdu;
                // echo "\n-------\n";
                 //echo ".-";
 
                $msg = new AMQPMessage($NewDlrPdu);            
            }

            $channel_publish->basic_publish($msg, "skannel.down.send.stopped.ex", '');
            //skannel.down.send.stopped.ex
            return true;
        }
     //}
     
}

function manipulateDLRPDU($NewDlrPdu)
{
    $NewSms = array();
    foreach ($NewDlrPdu['sms'] as $key => $value) {

        if($key=='msgdata' && $NewDlrPdu['sms']['dlr_mask']==2) {
            $Pdu = explode(' ', $NewDlrPdu['sms']['msgdata']); 
            $PduCode = explode(':', $Pdu[8]); 
            $PduCode = $PduCode[1];
            $PduCode = getNewPduCode($PduCode);
            
            if($PduCode){
                $Pdu[8] = 'err:'.$PduCode;
                $NewPdu = implode(' ', $Pdu);
                $NewSms['sms'][$key] = $NewPdu;
            }else{
                 $NewSms['sms'][$key] = $value;
            }
            // if ($Pdu[8]=='err:520') {
            //  $Pdu[8] = 'err:444';
            // } 
            //$NewSms['sms'][$key] = $NewPdu;
        }else{
            $NewSms['sms'][$key] = $value;
        }

      // if( $NewDlrPdu['sms']['sender']=='GovtTS'){
                // $NewSms['sms']['dlr_mask'] = 1;
       // }
    }

return json_encode($NewSms);

} 

function getNewPduCode($pdu)
{
    $pdu = ltrim($pdu, "0"); 
    
 $file = '/home/smppuser/public_html/rabbit/pdus/errorcode.json';
if(file_exists($file)){
    $file_content = file_get_contents($file);
    //print_r($file_content);
     $array = json_decode($file_content, true);
      if (array_key_exists($pdu,$array)){
           //  echo "\n--------\n";  
        //print_r($pdu);
        return $array[$pdu];   

     }else{
        // if($pdu==666){
        //     return 666;
        // }
        return '34';
        //return $array[$pdu];
    }
}
}

function retryFailedSms($smsc_id, $data, $dlr_url )
{   
   // print_r($data);
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        return true;
        exit;
    }else{

            $sql = "select * from smpp_sent_pdus where dlr_url = '".$dlr_url."' ";
            $query = mysqli_query($conn , $sql);
            $result =  mysqli_fetch_assoc($query);
            if(!$result){
                return true;
            }
            // return json_encode($result);
            //   $result['sender'];

            $message = hex2bin($result['msgdata']);
            $mclass  = null; 
            if($result["coding"]==2){
                $coding = 2;
            }
            else{
                $coding = 0;
            }
    
            $smsData["sender"]=$result["sender"];
            $smsData["receiver"]=$result["receiver"];
            $smsData["msgdata"]=$message;
            $smsData["time"]= intval($result["time"]);
            $smsData["smsc_id"]=$smsc_id;
            $smsData["service"]=$result["service"];
            $smsData["account"]=$result["service"];
            $smsData["id"]=md5(uniqid());
            $smsData["sms_type"]=2;
            $smsData["coding"]=$coding;
            $smsData["compress"]=0;
            $smsData["dlr_mask"]=923;
            $smsData["dlr_url"]=$dlr_url;
            $smsData["pid"]=0;
            $smsData["priority"]=0;
            $smsData["alt_dcs"]=0;
            $smsData["charset"]="UTF-8";
            $smsData["boxc_id"]="AMQP-DOWN";
            $smsData["meta_data"]="?smpp?TEST=xxx&".$result['udhdata']."&?smsbox?smsc-id=AMQP-DOWN&";
            $sms['sms'] = $smsData;
            return $sms;
            
      }
     mysqli_close($conn);

}



function getRetryRoute(){   
$file = '/home/smppuser/public_html/rabbit/retry_route/retry_route.json';
    if(file_exists($file)){
         $file_content = file_get_contents($file);
        return json_decode($file_content, true)[0];
     }


}
function process_message($message)
{   
    // Publish MO msg for BOTH
    // echo "\n--------------------\n";
    // echo $message->body;
    // echo "\n--------------------\n";

    $result = send_message_down($message);
    if($result==true){
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }
}

//TPS  = qos value * 25 | CURRENT = 750
$channel_consume->basic_qos(null, 40, null);
$channel_consume->basic_consume(MO3, 'APPL', false, false, false, false, 'process_message');
function shutdown($channel_consume, $channel_publish, $connection_consume, $connection_publish)
{
    // , $channel_publish2,$connection_publish2
    $channel_consume->close();
    $channel_publish->close();

    $connection_consume->close();
    $connection_publish->close();

    // $channel_publish2->close();
    // $connection_publish2->close();
}
register_shutdown_function('shutdown', $channel_consume, $channel_publish, $connection_consume, $connection_publish);

//, $channel_publish2,$connection_publish2

// Loop as long as the channel has callbacks registered
while ($channel_consume->is_consuming()) {
    $channel_consume->wait();
}



//kannel.up.send.ex should be bind mysql.mo.update
?>
