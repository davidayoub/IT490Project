<?php

// Starting the session
session_start();
require(__DIR__ . "/../lib/functions.php");

reset_session();

redirect("login_register.php");
echo("Successfully logged out");
