<?php
define('DBSERVER', '127.0.0.1'); //Database server
define('DBUSERNAME', 'root'); //Database username
define('DBPASSWORD', ''); //Database password
define('DBNAME', 'demo'); //Database name


$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

if($db === false)
{
    die("Error: connection error. " . mysqli_connect_error());
}
?>