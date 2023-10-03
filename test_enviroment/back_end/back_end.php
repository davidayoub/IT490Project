<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


// Include RabbitMQ library
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Get raw input data
$inputData = file_get_contents('php://input');
error_log("Raw Input Data: " . $inputData);

// Decode JSON input data
$data = json_decode($inputData, true);

// Validate JSON and input data
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['username']) || !isset($data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

// Sanitize and Validate the username and password
$username = filter_var($data['username'], FILTER_SANITIZE_STRING);
$password = filter_var($data['password'], FILTER_SANITIZE_STRING);

if (empty($username) || empty($password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    exit;
}

// Hash the password before sending to RabbitMQ (don't send/store plain-text passwords)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Securely get RabbitMQ credentials (replace with your actual credentials or environment variable calls)
$rabbitmq_host = 'localhost';
$rabbitmq_port = 5672;
$rabbitmq_user = 'guest';
$rabbitmq_pass = 'guest';

// Connect to RabbitMQ and send registration message
try {
    $connection = new AMQPStreamConnection($rabbitmq_host, $rabbitmq_port, $rabbitmq_user, $rabbitmq_pass);
    $channel = $connection->channel();
    $channel->queue_declare('register', false, false, false, false);

    $msg = new AMQPMessage(json_encode(['username' => $username, 'password' => $hashed_password]));
    $channel->basic_publish($msg, '', 'register');

    $channel->close();
    $connection->close();

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Registration in progress']);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Internal Server Error']);
}
?>