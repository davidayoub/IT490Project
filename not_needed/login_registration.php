<?php



//Login information 
if (isset($_POST["login"], $_POST["username"], $_POST["password"])) {
    $email = se($_POST, "username", "", false);
    $password = se($_POST, "password", "", false);
    $hasErrors = false;

    if (empty($email)) {
        flash("Username or email must be set", "warning");
        $hasErrors = true;
    } elseif (str_contains($email, "@")) {
        $email = sanitize_email($email);
        if (!is_valid_email($email)) {
            flash("Invalid email address", "warning");
            $hasErrors = true;
        }
    } elseif (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
        flash("Username must only be alphanumeric and can only contain - or _");
        $hasErrors = true;
    }

    if (empty($password)) {
        flash("Password must be set");
        $hasErrors = true;
    } elseif (strlen($password) < 8) {
        flash("Password must be at least 8 characters", "warning");
        $hasErrors = true;
    }

    if (!$hasErrors) {
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, email, password from Users where email = :email or username = :email");
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
                    redirect("home.php");
                } else {
                    flash("Invalid password", "danger");
                }
            } else {
                flash("Email not found", "danger");
            }
        } catch (Exception $e) {
            flash(var_export($e, true));
        }
    }
}




//REGISTER
//TODO 2: add PHP Code
if (isset($_POST["register"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $username = se($_POST, "username", "", false);

    //TODO 3
    $hasError = false;
    if (empty($email)) {
        flash("Email must not be empty", "danger");
        $hasError = true;
    }
    //sanitize
    $email = sanitize_email($email);
    //validate
    if (!is_valid_email($email)) {
        flash("Invalid email address", "danger");
        $hasError = true;
    }
    if (!preg_match('/^[a-z0-9_-]{3,16}$/i', $username)) {
        flash("Username must only be alphanumeric and can only contain - or _", "danger");
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
    if (!$hasError) {
        //TODO 4
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("Successfully registered!");
        } catch (Exception $e) {
            users_check_duplicate($e->$errorInfo);
        }
    }
}


// Starting a PHP session which allows you to store data to be easily accessed across pages

/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    };
    if (is_valid_email($username)){
        sanitize_input($username);
        validate_password($password);


    }
    is_valid_email();
    sanitize_email();


    login();


$db = getDB();
*/



/*
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
    <script type="text/javascript" src="../js/scripts.js"></script>

*/

?>

