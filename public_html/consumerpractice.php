<?php
require(__DIR__."/../partials/nav.php");
require_once(__DIR__.'/rabbitmqphp_example/rabbitMQLib.inc');
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


    $rabbitmqHost = 'localhost';
    $rabbitmqPort = 5672;
    $rabbitmqUser = 'test';
    $rabbitmqPass = 'test';
    $rabbitmqVhost = 'it490';
    
    // Create a connection to RabbitMQ
    $connection = new AMQPStreamConnection($rabbitmqHost, $rabbitmqPort, $rabbitmqUser, $rabbitmqPass, $rabbitmqVhost);
    
    // Create a channel
    $channel = $connection->channel();
    
    // Declare a queue to send the data
    $queueName = 'testQueue';
    $channel->queue_declare($queueName, false, true, false, false);








if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $request = array();
        $request['type'] = "login";
        $request['username'] = $username;
        $request['password'] = $password;

        $email = se($_POST, "username", "", false);
        $password = se($_POST, "password", "", false);
        $hasErrors = false;
        if (empty($email)) {
            echo("Username or email must be set");
            $hasErrors = true;
        } elseif (str_contains($email, "@")) {
            $email = sanitize_email($email);
            if (!is_valid_email($email)) {
                echo("Invalid email address");
                $hasErrors = true;
            }
        } elseif (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
            echo("Username must only be alphanumeric and can only contain - or _");
            $hasErrors = true;
        }
        if (empty($password)) {
            echo("Password must be set");
            $hasErrors = true;
        } elseif (strlen($password) < 8) {
            echo("Password must be at least 8 characters");
            $hasErrors = true;
        }

        try {
            // RabbitMQ Below
           // $client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
            // $response = $client->publish($request);
           // $response = $client->send_request($request);
            //var_dump($response);

           // $_SESSION["user"]["roles"] = $response ?: [];
            redirect("home.php");
        } catch (Exception $e) {
            echo(var_export($e, true));
        }

        //Starting from here everything was commented out
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, email, password from users where email = :email or username = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r && $user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $user["password"])) {
                    unset($user["password"]);
                    $_SESSION["user"] = $user;
                    // Just in case there is a session admin
                    //$stmt = $db->prepare("SELECT Roles.name FROM Roles JOIN UserRoles on Roles.id = UserRoles.role_id where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                    // $stmt->execute([":user_id" => $user["id"]]);
                    // $_SESSION["user"]["roles"] = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

                    // RabbitMQ Below
                    //$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
                    //$response = $client->send_request($request);
                   // var_dump($response);

                            //$dataJson = json_encode($request);
    
                            // Prepare the message
                           //$message = new AMQPMessage($request);
                        
                            //Publish the message to the combined data queue
                            //$channel->basic_publish($request);


                    redirect("home.php");

                } else {
                    echo("Invalid password");
                }
            } else {
                echo("Email not found");
            }
        } catch (Exception $e) {
            echo(var_export($e, true));
        }
        //From here and up, everything was commented out


        
        //$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
       // $response = $client->send_request($request);

        //var_dump($response);
        
    }

    // Similarly, you can handle registration here
    if (isset($_POST["register"])) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm = $_POST["confirm"];

        $request = array();
        $request['type'] = "register";
        $request['email'] = $email;
        $request['username'] = $username;
        $request['password'] = $password;
        $request['confirm'] = $confirm;

        if (!is_valid_email($email)) {
            flash("Invalid email address", "danger");
            $hasError = true;
        }
        if (!preg_match('/^[a-z0-9_-]{3,16}$/i', $username)) {
            echo("Username must only be alphanumeric and can only contain - or _");
            $hasError = true;
        }
        if (empty($password)) {
            flash("password must not be empty", "danger");
            $hasError = true;
        }
        if (empty($confirm)) {
            flash("Confirm password must not be empty", "danger");
            $hasError = true;
        }
        if (strlen($password) < 8) {
            flash("Password too short", "danger");
            $hasError = true;
        }
        if (
            strlen($password) > 0 && $password !== $confirm
        ) {
            flash("Passwords must match", "danger");
            $hasError = true;
        }



        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            echo " \n" ;
            echo " [x] Data inserted into MySQL table\n";
            echo " [x] Received Email: ", $data['email'], "\n";
            echo " [x] Received Username: ", $data['username'], "\n";
            echo " [x] Received Password: ", $data['password'], "\n";
            echo " \n" ;
        } catch (Exception $e) {
           // users_check_duplicate($e->$errorInfo);
        }
        


        //$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
        //$response = $client->send_request($request);

       // var_dump($response);

        //Incase client ^ does not work
        //$dataJson = json_encode($request);
    
        // Prepare the message
      // $message = new AMQPMessage($request);
    
        //Publish the message to the combined data queue
       // $channel->basic_publish($request);






    }
}


function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        //added 07-05-2021 to fix case where $k of $v isn't set
        //this is to kep htmlspecialchars happy
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}



$channel->basic_consume($queueName, '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

// Close the channel and connection (will not be reached in this example)
$channel->close();
$connection->close();










?>







}

