<?php
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
        if ($stmt = $con->prepare('SELECT id FROM users WHERE name = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            // If the username is taken, display an error message
            if ($stmt->num_rows > 0) {
                flash($_SESSION, 'Username Already Exists. Try Again');
            } else {
                // Otherwise, try to insert the new user into the database
                if ($stmt = $con->prepare('INSERT INTO users (name, password, email) VALUES (?, ?, ?)')) {
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


if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($stmt = $con->prepare('SELECT password FROM users WHERE name = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        if ($stmt->fetch()) {
            if (password_verify($password, $hashedPassword)) {
                // Login successful. Redirect to home page.
                header('Location: home.php');
                exit();
            } else {
                flash($_SESSION, 'Incorrect password', 'danger');
            }
        } else {
            flash($_SESSION, 'Username not found', 'danger');
        }
        $stmt->close();
    } else {
        flash($_SESSION, 'Error Occurred', 'danger');
    }
}
?>