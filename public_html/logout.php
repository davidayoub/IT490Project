<?php

// Starting the session
session_start();
require(__DIR__ . "/../lib/functions.php");

reset_session();

echo("Successfully logged out");
redirect("login_register.php");