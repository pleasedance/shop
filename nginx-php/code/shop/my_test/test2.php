<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$callback = function($msg) {
    echo " [x] Received ", $msg->body, "\n";
};

$connection = new AMQPStreamConnection('192.168.0.105', 5672, 'chenyihua', '12321');
$channel = $connection->channel();

$channel->basic_consume('queue_demo1', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

?>
