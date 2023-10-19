<?php

// Starting the session
session_start();

// Unsetting the logged_in session variable to log the user out
unset($_SESSION['logged_in']);

// Redirecting the user to the homepage or login page
header("Location: login_register.php"); // Replace "index.php" with the name of your homepage or login page
exit;

?>
