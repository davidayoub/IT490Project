<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
   <!-- Registration Form -->
    <form method="post"> 
        <h2>Registration Form</h2>
        Username: <input type="text" name="username"><br>
        Name: <input type="text" name="name"><br>
        Email: <input type="text" name="email"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Send to RabbitMQ">
    </form>

    <br>

    <!-- Login Form -->
    <form method="post">
        <h2>Login Form</h2>
        Username: <input type="text" name="login_username"><br>
        Password: <input type="password" name="login_password"><br>
        <input type="submit" value="Log In">
    </form>
    </body>
</html>

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
    
    // Create a connection to RabbitMQ
    $connection = new AMQPStreamConnection($rabbitmqHost, $rabbitmqPort, $rabbitmqUser, $rabbitmqPass, $rabbitmqVhost);
    
    // Create a channel
    $channel = $connection->channel();
    
    // Declare a queue to send the data
    $queueName = 'testQueue';
    $channel->queue_declare($queueName, false, true, false, false);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
            // Registration Form Data
            $username = $_POST['username'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $data = [
                'type' => 'registration',
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ];
        } elseif (isset($_POST['login_username']) && isset($_POST['login_password'])) {
            // Login Form Data
            $username = $_POST['login_username'];
            $password = $_POST['login_password'];
    
            $data = [
                'type' => 'login',
                'username' => $username,
                'password' => $password,
            ];
        }
    
        // Convert the data to a JSON string
        $dataJson = json_encode($data);
    
        // Prepare the message
        $message = new AMQPMessage($dataJson);
    
        // Publish the message to the combined data queue
        $channel->basic_publish($message, '', $queueName);
    }
    
    // Close the channel and connection
    $channel->close();
    $connection->close();
?>