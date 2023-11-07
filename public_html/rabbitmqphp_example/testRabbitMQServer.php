<?php

require_once(__DIR__.'/../rabbitmqphp_example/path.inc');
require_once(__DIR__.'/../rabbitmqphp_example/get_host_info.inc');
require_once(__DIR__.'/../rabbitmqphp_example/rabbitMQLib.inc');
require_once(__DIR__.'/../../lib/functions.php');

function requestProcessor($request)
{
    echo "Received request".PHP_EOL;
    var_dump($request);

    if(!isset($request['type'])) {
        return ["status" => "error", "message" => "Unsupported request type"];
    }

    switch($request['type']) {
        case "login":
            return doLogin($request['username'], $request['password']);
        case "register":
            return doRegister($request['email'], $request['username'], $request['password'], $request['confirm']);
        default:
            return ["status" => "error", "message" => "Unsupported request type"];
    }
}

// Process the login request
function doLogin($email, $password){
    $response = ["status" => "error", "message" => ""];

    if (empty($email)) {
        $response["message"] = "Username or email must be set";
        return $response;
    }

    if (str_contains($email, "@")) {
        $email = sanitize_email($email);
        if (!is_valid_email($email)) {
            $response["message"] = "Invalid email address";
            return $response;
        }
    } else {
        if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
            $response["message"] = "Username must only be alphanumeric and can only contain - or _";
            return $response;
        }
    }

    if (empty($password) || strlen($password) < 8) {
        $response["message"] = "Password must be set and at least 8 characters long";
        return $response;
    }

    $db = getDB();
    $stmt = $db->prepare("SELECT id, username, email, password FROM users WHERE email = :email OR username = :email");
    try {
        $r = $stmt->execute([":email" => $email]);
        if ($r) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $response["status"] = "success";
                    $response["user"] = $user;
                } else {
                    $response["message"] = "Invalid password";
                }
            } else {
                $response["message"] = "Email not found";
            }
        }
    } catch (Exception $e) {
        $response["message"] = var_export($e, true);
    }

    return $response;
}

// Process the register request
function doRegister($email, $username, $password, $confirm){
    $response = ["status" => "error", "message" => ""];

    if (empty($email) || empty($username) || empty($password) || empty($confirm)) {
        $response["message"] = "All fields must be filled";
        return $response;
    }

    $email = sanitize_email($email);
    if (!is_valid_email($email)) {
        $response["message"] = "Invalid email address";
        return $response;
    }

    if (!preg_match('/^[a-z0-9_-]{3,16}$/i', $username)) {
        $response["message"] = "Username must only be alphanumeric and can only contain - or _";
        return $response;
    }

    if (strlen($password) < 8) {
        $response["message"] = "Password too short";
        return $response;
    }

    if ($password !== $confirm) {
        $response["message"] = "Passwords must match";
        return $response;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES(:email, :password, :username)");
    try {
        $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
        $response["status"] = "success";
        $response["message"] = "Successfully registered new user.";
    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }

    return $response;
}

$server = new rabbitMQServer(__DIR__ . '/../rabbitmqphp_example/host.ini', "testServer");
$server->process_requests('requestProcessor');

?>
