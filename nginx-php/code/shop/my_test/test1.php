<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.0.105', 5672, 'chenyihua', '12321');
$channel = $connection->channel();

$msg = new AMQPMessage('fgf');
$channel->basic_publish($msg,'demo','test1');
//websocket
echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

?>
