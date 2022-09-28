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
	  $msgData = insertSmppMessagesMysql($message->body);
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


register_shutdown_function('shutdown', $channel_consume, $connection_consume);

// Loop as long as the channel has callbacks registered

while ($channel_consume->is_consuming()) {
    $channel_consume->wait();
}

?>