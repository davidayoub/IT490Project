<?php

// Starting a PHP session which allows you to store data to be easily accessed across pages
session_start();

// Function to display a flash message, given a session and message parameters
function flash(&$session, $msg = "", $color = "info") {
    // Creating a message array with text and color
    $message = ["text" => $msg, "color" => $color];

    // If flash session variable is not set, initialize it as an empty array
    if (!isset($session['flash'])) {
        $session['flash'] = [];
    }
    // Add the new message to the flash session variable
    array_push($session['flash'], $message);
}


// Function to sanitize email addresses by removing illegal characters
function sanitize_email($email = "") {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

// Function to validate email addresses
function is_valid_email($email = "") {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}

// Database connection parameters
$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'TestUser';
$DATABASE_PASS = '12345';
$DATABASE_NAME = 'form';

// Creating a connection to the database
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Checking if the connection failed, and if so, exiting the script with an error message
if (mysqli_connect_error()) {
    exit('Error connecting to the database' . mysqli_connect_error());
}

// Checking if the necessary POST variables are set
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    // Sanitizing and storing POST variables
    $email = sanitize_email($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $username = $_POST["username"];

    // Flag to determine if there are any validation errors
    $hasError = false;

    // Series of validation checks
    if (empty($email)) {
        flash($_SESSION, "Email must not be empty");
        $hasError = true;
    }

    if (!is_valid_email($email)) {
        flash($_SESSION, "Invalid email");
        $hasError = true;
    }

    if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $username)) {
        flash($_SESSION, "Username must only be alphanumeric and can only contain - or _");
        $hasError = true;
    }

    if (empty($password)) {
        flash($_SESSION, "Password must not be empty");
        $hasError = true;
    }

    if (empty($confirm)) {
        flash($_SESSION, "Confirm password must not be empty");
        $hasError = true;
    }

    if (strlen($password) < 8) {
        flash($_SESSION, "Password too short");
        $hasError = true;
    }

    if ($password !== $confirm) {
        flash($_SESSION, "Passwords must match");
        $hasError = true;
    }

    // If there are no validation errors
    if (!$hasError) {
        // making sure DB exists after validation
        try {
            // if it fails we don't have a db named forms.users
            $query = $con->prepare('SELECT id FROM users');
            $query->execute();
            $query->store_result();
        }

        catch(Exception $e) { // storing the specific exception in $e
            if(empty($query)) { // redundant?
                $query = $con->prepare("CREATE TABLE form.users (
                id INT NOT NULL AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
                )");
                $query->execute();
            }
        }
        // Check if the username is already taken
        if ($stmt = $con->prepare('SELECT id FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            // If the username is taken, display an error message
            if ($stmt->num_rows > 0) {
                flash($_SESSION, 'Username Already Exists. Try Again');
            } else {
                // Otherwise, try to insert the new user into the database
                if ($stmt = $con->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->bind_param('sss', $username, $hashedPassword, $email);
                    $stmt->execute();
                    flash($_SESSION, 'Successfully Registered');
                } else {
                    flash($_SESSION, 'Error Occurred');
                }
            }
            $stmt->close();
        } else {
            flash($_SESSION, 'Error Occurred');
        }
    }
}

// Close the database connection
$con->close();

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register</title>
    <link rel="icon" href="path_to_favicon.ico">
    <meta name="description" content="Description of your website.">
    <meta name="keywords" content="keyword1, keyword2, keyword3">
    <meta name="author" content="Your Name or Company Name">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- DaisyUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui/dist/full.css" rel="stylesheet">

    <!-- DaisyUI Autumn Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@1.10.2/themes/autumn.min.css" rel="stylesheet">

    <script src="js/form_validation.js"></script>

    <!-- If you want your site to be displayed nicely when shared on social platforms -->
    <!-- Open Graph tags -->
    <meta property="og:title" content="Title Here">
    <meta property="og:description" content="Description Here">
    <meta property="og:image" content="URL to your image">
    <meta property="og:url" content="URL of your website">

    <!-- Twitter Card tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Title Here">
    <meta name="twitter:description" content="Description Here">
    <meta name="twitter:image" content="URL to your image">
</head>

<body class="bg-white">
    <!-- Main Section -->
    <div class="p-4"> <!-- Add padding to this container -->
        <div class="text-center space-y-4">
            <h1>Welcome!</h1>
            <h2>Welcome to our website!</h2>
        </div>
    </div>

    <!-- Login and Registration Modals -->
    <div class="flex justify-center">
        <!-- Login Modal -->
        <div id="loginModal" class="w-1/2 p-4">
            <div class="bg-white p-4 rounded space-y-4">
                <h5 class="text-3xl font-bold text-autumn-primary mt-4">Login</h5>
                <form method="POST" action="" accept-charset="UTF-8" id="loginForm" onsubmit="return validate(this)">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <!-- You might want to replace this with a suitable icon from a library like FontAwesome, as glyphicon is from Bootstrap -->
                            <i class="icon-placeholder"></i>
                            <input class="input input-bordered w-full bg-beige" type="text" name='username' id="username" placeholder="Username">
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="icon-placeholder"></i>
                            <input class="input input-bordered w-full bg-beige" type="password" id="password" name='password' placeholder="Password">
                        </div>
                        <label class="cursor-pointer select-none">
                            <input type="checkbox" name="remember" value="1">
                            Remember Me
                        </label>
                        <button type="submit" class="btn btn-primary w-full">Sign In</button>
                        <p class="text-center">Forgot password? <a href="login.html">Reset</a>.</p>

                    </div>
                </form>
            </div>
        </div>

        <!-- Registration Modal -->
        <div id="registerModal" class="w-1/2 p-4">
            <div class="bg-white p-4 rounded space-y-4">
                <h5 class="text-3xl font-bold text-autumn-primary mt-4">Register</h5>
                <form onsubmit="return validate(this)" method="POST">
                    <div class="space-y-4">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" class="input input-bordered w-full bg-beige" placeholder="Enter Email" name="email" required>
                        </div>
                        <div>
                            <label for="username">Username</label>
                            <input type="text" class="input input-bordered w-full bg-beige" placeholder="Enter Username" name="username" required maxlength="30">
                        </div>
                        <div>
                            <label for="pw">Password</label>
                            <input type="password" class="input input-bordered w-full bg-beige" placeholder="Enter Password" id="pw" name="password" required minlength="8">
                        </div>
                        <div>
                            <label for="confirm">Confirm</label>
                            <input type="password" class="input input-bordered w-full bg-beige" placeholder="Confirm Password" name="confirm" required minlength="8">
                        </div>
                        <button type="submit" class="btn btn-info w-full">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/scripts.js"></script>
</body>
</html>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>

