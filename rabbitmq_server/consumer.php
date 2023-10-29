<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// RabbitMQ server configuration
$rabbitmqHost = 'localhost';
$rabbitmqPort = 5672;
$rabbitmqUser = 'guest';
$rabbitmqPass = 'guest';
$rabbitmqVhost = 'it490';

// MySQL database configuration
$mysqlHost = 'localhost';
$mysqlUser = 'TestUser';
$mysqlPass = '12345';
$mysqlDb = 'form';
$mysqlPort = 3306;

// Create a connection to RabbitMQ
$connection = new AMQPStreamConnection($rabbitmqHost, $rabbitmqPort, $rabbitmqUser, $rabbitmqPass, $rabbitmqVhost);

// Create a channel
$channel = $connection->channel();

// Declare the queue to consume messages
$queueName = 'testQueue';
$channel->queue_declare($queueName, false, true, false, false);

echo " [*] Waiting for messages. To exit, press Ctrl+C\n";

$callback = function ($message) use ($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb) {
    $data = json_decode($message->body, true);

    if ($data['type'] === 'registration') {
        // Insert the registration data into the MySQL table
        $mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb, $mysqlPort);
        echo $mysqli;

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $username = $mysqli->real_escape_string($data['username']);
        $name = $mysqli->real_escape_string($data['name']);
        $email = $mysqli->real_escape_string($data['email']);
        $password = $mysqli->real_escape_string($data['password']);

        $query = "INSERT INTO students (username, name, email, password) VALUES ('$username', '$name', '$email', '$password')";

        if ($mysqli->query($query) === true) {
            echo " \n" ;
            echo " [x] Data inserted into MySQL table\n";
            echo " [x] Received Username: ", $data['username'], "\n";
            echo " [x] Received Name: ", $data['name'], "\n";
            echo " [x] Received Email: ", $data['email'], "\n";
            echo " [x] Received Password: ", $data['password'], "\n";
            echo " \n" ;
        } else {
            echo " [x] Error: " . $query . "\n" . $mysqli->error;
        }

        $mysqli->close();
    } elseif ($data['type'] === 'login') {
        // Handle login data
        $loginUsername = $data['username'];
        $loginPassword = $data['password'];

        // Check login credentials against the database (modify this part as per your authentication logic)
        $mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $loginUsername = $mysqli->real_escape_string($loginUsername);
        $loginPassword = $mysqli->real_escape_string($loginPassword);

        $query = "SELECT * FROM users WHERE username = '$loginUsername' AND password = '$loginPassword'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            // Login is successful
            // Set a session or cookie to indicate that the user is logged in
            echo " \n" ;
            echo " [x] Login is successful\n";

            //header("Location: https://urldefense.com/v3/__http://localhost:3006/home.php__;!!DLa72PTfQgg!NFlYTJSjj10Q07NyLDFih_J-JdfITGGj9jsw5mwSdnQumYc1KyIziOIqZKpQYNDQUuTTIp-zdfVIL_Fhx1pWUtJD$ ");
        } else {
            // Login failed, you can handle this scenario as needed
            echo " \n" ;
            echo " [x] Login failed\n";
        }

        $mysqli->close();
    }
};

// Consume messages from the queue
$channel->basic_consume($queueName, '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

// Close the channel and connection (will not be reached in this example)
$channel->close();
$connection->close();
?>