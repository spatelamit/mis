<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/function.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
$connection_consume = new AMQPStreamConnection('10.10.1.37', 5672, 'kannel', 'DSFLJ@3333$');
$channel_consume = $connection_consume->channel();


function process_message($message)
{
    // Insert MT In database Directly 
   $data=json_decode($message->body,true);
	  // $msgData = insertSmppMessagesMysql($message->body);
   $msgData = insertSMPPDatauser($message->body);
	  if($msgData==true){
	  	$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
	  }
}

$channel_consume->basic_qos(null, 100, null);
$channel_consume->basic_consume('smysql.mt.insert', 'APPL', false, false, false, false, 'process_message');

function shutdown($channel_consume, $connection_consume)
{
    $channel_consume->close();
    $connection_consume->close();
}






function insertSMPPDatauser($message){
// echo  "\n------\n";
// print_r($message);
// echo  "\n------\n";
 $data = json_decode($message);
 $number  = $data->sms->receiver;
 $msgdata  = $data->sms->msgdata;



	$conn = mysqli_connect('p:localhost', 'smppuser', 'SeCuRe@LocalHost#890','smppdb');

	if (!$conn) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		return false;
	    exit;
	}else{
$string = $msgdata;
echo "\n--------\n";
echo $string;
echo "\n--------\n"; 
$insert = 0;



if (strpos($string, 'bhopal') !== false ) {
	$insert =1;
	$city = 'bhopal';
	$state = "MP";
}elseif(strpos($string, 'ujjain') !== false ) {
	$insert =1;
	$city = 'ujjain';
	$state = "MP";
}elseif(strpos($string, 'jabalpur') !== false ) {
	$insert =1;
	$city = 'jabalpur';
	$state = "MP";
}elseif(strpos($string, 'dewas') !== false ) {
	$insert =1;
	$city = 'dewas';
	$state = "MP";
}elseif(strpos($string, 'bank') !== false ) {
	$insert =1;
	$city = 'bank';
	$state = "banking";
}elseif (strpos($string, 'indore') !== false ) {
	$insert =1;
	$city = 'indore';
	$state = "MP";
}





if ($insert==1) {
		#############
		  $query = "INSERT IGNORE INTO `smpp_data` (`number`, `city`, `state`, `address`) VALUES ( '".$number."',  '".$city."',  '".$state."',  '".$state."') ";
		 //    echo "\n--------\n";
   // echo $query;
   // echo "\n--------\n"; 
		  if(mysqli_query($conn , $query)){
				return true;
			}
			mysqli_close($conn);


 
		############

}else{
	echo  ".";
	return true;

}


		
	}

}

register_shutdown_function('shutdown', $channel_consume, $connection_consume);

// Loop as long as the channel has callbacks registered

while ($channel_consume->is_consuming()) {
    $channel_consume->wait();
}

?>
