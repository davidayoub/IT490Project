<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Create a connection to RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Declare a queue
$channel->queue_declare('hello', false, false, false, false);

// Create a message
$msg = new AMQPMessage('Hello, RabbitMQ!');

// Publish the message to the queue
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello, RabbitMQ!'\n";

// Close the channel and the connection
$channel->close();
$connection->close();
