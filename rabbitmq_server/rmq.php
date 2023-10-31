#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// RabbitMQ server configuration
$rabbitmqHost = 'localhost';
$rabbitmqPort = 5672;
$rabbitmqUser = 'guest';
$rabbitmqPass = 'guest';
$rabbitmqVhost = 'it490';

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $loginUsername = $data['username'];
    $loginPassword = $data['password'];

    // MySQL database configuration
    $mysqlHost = 'localhost';
    $mysqlUser = 'TestUser';
    $mysqlPass = '12345';
    $mysqlDb = 'form';
    $mysqlPort = 3306;
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
    }
    return true;
    //return false if not valid
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "registration":
    case "register":
      // return doRegister($request['username'],$request['password'])
      return;
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
