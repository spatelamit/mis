<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
$connection_consume = new AMQPStreamConnection('10.10.1.37', 5672, 'kannel', 'DSFLJ@3333$');
$connection_publish = new AMQPStreamConnection('10.10.1.37', 5672, 'kannel', 'DSFLJ@3333$');
$channel_consume = $connection_consume->channel();
$channel_publish = $connection_publish->channel();

function send_message_down($message)
{
    global $channel_publish;
    $data=json_decode($message->body,true);

    // echo "\n-------\n";
    // echo $message->body;
    // echo "\n-------\n";s
    
  
    if($data['sms']['dlr_mask']!=8){
         
        $NewDlrPdu =  manipulateDLRPDU($data);

        $msg = new AMQPMessage($NewDlrPdu);
        // Publish MO msg To down stream 
        //$channel_publish->basic_publish($msg, 'mysql.mo.update.ex', '');
        $channel_publish->basic_publish($msg, 'skannel.down.send.ex' , '');
     }
     return true;
}


function manipulateDLRPDU($NewDlrPdu)
{
$NewSms = array();
foreach ($NewDlrPdu['sms'] as $key => $value) {
    echo "\n--------\n";
    print_r($NewDlrPdu);
    echo "\n--------\n";


if ($key=='msgdata') {
    $Pdu = explode(' ', $NewDlrPdu['sms']['msgdata']); 
    if ($Pdu[8]=='err:000') {
        if ($Pdu[7]=='stat:REJECTD') {
            $Pdu[7] = 'stat:DNDNumber';
             $Pdu[8] = 'err:102';
        }
        //if($NewDlrPdu['sms']['service']=='service'){
         //$Pdu[8] = 'err:0000';
        //}
    }
    // if ($Pdu[8]=='err:520' || $Pdu[8]=='err:4106' || $Pdu[8]=='err:604') {
    //          $Pdu[8] = 'err:444';
    // }
    

    $NewPdu = implode(' ', $Pdu);
    $NewSms['sms'][$key] = $NewPdu;
    }else{
        $NewSms['sms'][$key] = $value;
    }

}
  // echo "\n--------\n";
  //   print_r($NewSms);
  //   echo "\n--------\n";

return json_encode($NewSms);

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

$channel_consume->basic_qos(null, 100, null);
$channel_consume->basic_consume('skannel.up.send', 'APPL', false, false, false, false, 'process_message');
function shutdown($channel_consume, $channel_publish, $connection_consume, $connection_publish)
{
    $channel_consume->close();
    $channel_publish->close();
    $connection_consume->close();
    $connection_publish->close();
}
register_shutdown_function('shutdown', $channel_consume, $channel_publish, $connection_consume, $connection_publish);

// Loop as long as the channel has callbacks registered
while ($channel_consume->is_consuming()) {
    $channel_consume->wait();
}



//kannel.up.send.ex should be bind mysql.mo.update
?>


