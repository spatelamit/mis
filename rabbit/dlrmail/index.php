<?php

require_once '../vendor/autoload.php';
require_once '../config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;



$json_object=file_get_contents('php://input');

// $myfile = fopen("../../logs/mail/mailer-dlr-".date('d-m-y').".txt", "a") or die("Unable to open file!");
// fwrite($myfile, $json_object."\n\n");
// fclose($myfile);




// $connection = new AMQPStreamConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS);
// $channel = $connection->channel();

// $msg = new AMQPMessage($json_object);
// $channel->basic_publish($msg, 'mailer.mo.ex', '');



/// COde secureip ke liye DLR
$connection = new AMQPStreamConnection("10.10.1.158", MQ_PORT, "mautic", "Tfy@#92H");
$channel = $connection->channel();
$msg = new AMQPMessage($json_object);
$channel->basic_publish($msg, 'mailer.mo.update.ex', '');
/// COde secureip ke liye DLR



$channel->close();
$connection->close();
return true;

?>
