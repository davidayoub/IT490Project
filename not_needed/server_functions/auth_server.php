<?php
require_once(__DIR__.'/../rabbitmqphp_example/path.inc');
require_once(__DIR__.'/../rabbitmqphp_example/get_host_info.inc');
require_once(__DIR__.'/../rabbitmqphp_example/rabbitMQLib.inc');
require(__DIR__.'/../../lib/functions.php');

function requestProcessor($request)
{
    echo "Received request".PHP_EOL;
    var_dump($request);

    if (!isset($request['type'])) {
        return ["status" => "error", "message" => "Unsupported request type"];
    }

    $response = null;
    switch ($request['type']) {
        case "login":
            $response = doLogin($request['username'], $request['password']);
            break;
        case "register":
            $response = doRegister($request['email'], $request['username'], $request['password'], $request['confirm']);
            break;
        default:
            $response = ["status" => "error", "message" => "Unsupported request type"];
            break;
    }

    // Check the response and redirect if successful
    if ($response && $response["status"] === "success") {
        redirect("home.php");
    } else {
<<<<<<< HEAD:not_needed/server_functions/auth_server.php
        // Handle the error or unsuccessful operation
=======
<<<<<<< HEAD:public_html/server_functions/login_registration.php
=======
        // Handle the error or unsuccessful operation
>>>>>>> 0d36871 (change the server rabbit and client):public_html/server_functions/auth_server.php
>>>>>>> 0e1cbd0 (change the server rabbit and client):public_html/server_functions/auth_server.php
        echo "Error: " . $response["message"];
    }

    // Return the response for further processing if needed
    return $response;
}


function doLogin($email, $password){
    
    $response = ["status" => "error", "message" => ""];
    
    if (empty($email)) {
        $response["message"] = "Username or email must be set";
        return $response;
    }
    
    //sanitize
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
                $hash = $user["password"];
                if (password_verify($password, $hash)) {
<<<<<<< HEAD:not_needed/server_functions/auth_server.php
=======
<<<<<<< HEAD:public_html/server_functions/login_registration.php
                    $_SESSION["user"] = $user; // Store user info in the session
                    redirect("home.php"); // Redirect to home page
=======
>>>>>>> 0e1cbd0 (change the server rabbit and client):public_html/server_functions/auth_server.php
                    $_SESSION["user"] = [
                        "id" => $user["id"],
                        "username" => $user["username"],
                        "email" => $user["email"]
                    ]; // Store user info in the session
                    
<<<<<<< HEAD:not_needed/server_functions/auth_server.php
=======
>>>>>>> 0d36871 (change the server rabbit and client):public_html/server_functions/auth_server.php
>>>>>>> 0e1cbd0 (change the server rabbit and client):public_html/server_functions/auth_server.php
                } else {
                    $response["message"] = "Invalid password";
                    return $response;
                }
            } else {
                $response["message"] = "Email not found";
                return $response;
            }
        }
    } catch (Exception $e) {
        $response["message"] = var_export($e, true);
        return $response;
    }
    
    return $response;
}

function doRegister($email, $username, $password, $confirm)
{
    $response = ["status" => "error", "message" => ""];

    $hasError = false;

    // Check for empty fields
    if (empty($email)) {
        $response["message"] = "Email must not be empty";
        return $response;
    }
    if (empty($username)) {
        $response["message"] = "Username must not be empty";
        return $response;
    }
    if (empty($password)) {
        $response["message"] = "Password must not be empty";
        return $response;
    }
    if (empty($confirm)) {
        $response["message"] = "Confirm password must not be empty";
        return $response;
    }

    // Sanitize email
    $email = sanitize_email($email);

    // Validate email and username
    if (!is_valid_email($email)) {
        $response["message"] = "Invalid email address";
        return $response;
    }
    if (!preg_match('/^[a-z0-9_-]{3,16}$/i', $username)) {
        $response["message"] = "Username must only be alphanumeric and can only contain - or _";
        return $response;
    }

    // Check password length
    if (strlen($password) < 8) {
        $response["message"] = "Password too short";
        return $response;
    }

    // Check password confirmation
    if ($password !== $confirm) {
        $response["message"] = "Passwords must match";
        return $response;
    }

    // If no errors, proceed with database insertion
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES(:email, :password, :username)");

    try {
        $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
        $response["status"] = "success";
        $response["message"] = "Successfully generated new account.";
    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }

    //return $response;
}



<<<<<<< HEAD:public_html/server_functions/login_registration.php
$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

=======
$server = new rabbitMQServer("host.ini", "rabbitMQ");
>>>>>>> 0d36871 (change the server rabbit and client):public_html/server_functions/auth_server.php
// Set up the callback function to process requests
$server->process_requests('requestProcessor');

?>


