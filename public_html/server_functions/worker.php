<?php

// server_functions/worker.php

require(__DIR__.'/../rabbitmqphp_example/rabbitMQLib.inc');
require(__DIR__.'/../../lib/db.php'); // Assuming this file contains the DB functions

$client = new rabbitMQClient("../rabbitmqphp/testRabbitMQ.ini", "testServer");

while (true) {
    try {
        // wait for a message from RabbitMQ
        $response = $client->send_request(['type' => 'wait']);

        if ($response) {
            // Assuming the 'type' and other required keys are part of the message body after decoding the JSON
            if ($response['type'] === 'Login') {
                $result = checkLogin($response['username'], $response['password']);
            } elseif ($response['type'] === 'Register') {
                $result = registerUser($response['email'], $response['username'], $response['password'], $response['confirm']);
            }

            // send the result back as a response to the queue specified in the 'reply_to' property of the request
            if (isset($result)) {
                $client->publish($result);
            }
        }
    } catch (Exception $e) {
        // log error message
        error_log($e->getMessage());
    }

    sleep(1);  // Delay for 1 second before processing the next message
}

function checkLogin($username, $password) {
    $db = getDB(); // getDB() should return a PDO instance connected to your database
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        return ['status' => 'success', 'message' => 'Login successful', 'user' => $user];
    } else {
        // Login failed
        return ['status' => 'error', 'message' => 'Login failed'];
    }
}


function registerUser($email, $username, $password, $confirm) {
    if ($password !== $confirm) {
        // Passwords do not match
        return ['status' => 'error', 'message' => 'Password confirmation does not match.'];
    }

    $db = getDB(); // getDB() should return a PDO instance connected to your database
    $stmt = $db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    try {
        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword
        ]);
        // Registration successful
        return ['status' => 'success', 'message' => 'User registered successfully.'];
    } catch (PDOException $e) {
        // Handle SQL error
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}



?>




