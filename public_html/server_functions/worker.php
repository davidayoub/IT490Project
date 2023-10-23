<?php

// server_functions/worker.php

require(__DIR__.'/../rabbitmqphp_example/rabbitMQLib.inc');
require(__DIR__.'/../../lib/db.php'); // Assuming this file contains the DB functions

$client = new rabbitMQClient("../rabbitmqphp/testRabbitMQ.ini", "testServer");

while (true) {
    $request = $client->get_request();  // Consume message from RabbitMQ

    if ($request) {
        if ($request['type'] === 'Login') {
            $result = checkLogin($request['username'], $request['password']);
            $client->send_response($result);  // Send response back to RabbitMQ
        } elseif ($request['type'] === 'Register') {
            $result = registerUser($request['email'], $request['username'], $request['password'], $request['confirm']);
            $client->send_response($result);  // Send response back to RabbitMQ
        }
    }

    sleep(1);  // Delay for 1 second before checking again
}


?>