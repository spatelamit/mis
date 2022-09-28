<?php
date_default_timezone_set("Asia/Kolkata");   

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/function.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
$connection_consume = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$connection_publish = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
$channel_consume = $connection_consume->channel();
$channel_publish = $connection_publish->channel();

function send_message($message, $ExChange)
{
    global $channel_publish;

   // echo ".";
	$msg = new AMQPMessage($message);
	// Publish MT msg upstream ex and If Fake so DownStream Ex
	$channel_publish->basic_publish($msg, $ExChange);
}

function mysql_mt_insert($message, $ExChange)
{
    global $channel_publish;
	$msg = new AMQPMessage($message);
		// Publish Mt msg mysql insert ex
	$channel_publish->basic_publish($msg, $ExChange);
}

  
function process_message($message)
{
	// echo "\n--------------------\n";
	// echo $message->body;
	// echo "\n--------------------\n";
	     //echo ".-";

	// mysql validate MT Data Routing, Ratio, whitelist, Blacklist etc.
	$result = valiDateMTdata($message);
	//if($result==true){
    	$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    //}
}

///kannel.down.send IS (Q1) MT  || tps  = qos value * 25 current = 500
$channel_consume->basic_qos(null, 22, null);
$channel_consume->basic_consume(MT1, 'APPL', false, false, false, false, 'process_message');

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

?>
