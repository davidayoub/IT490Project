<?php
//require(__DIR__. "/../server_functions/login_registration.php");
//require(__DIR__ . "/../../partials/nav.php");


//LOGIN
if (isset($_POST["login"]) && isset($_POST["username"]) && isset($_POST["password"])) {
    //get the email key from $_POST, default to "" if not set, and return the value
    //$email = se($_POST, "email", "", false);
    //same as above but for password
    //$password = se($_POST, "password", "", false);
    //TODO 3: validate/use
    //$errors = [];
    $email = ($_POST["username"]);
    $password = ($_POST["password"]);
    $hasErrors = false;
    if (empty($email)) {
        echo("Username or email must be set");
        $hasErrors = true;
    }
    //sanitize
    //$email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (str_contains($email, "@")) {
        $email = sanitize_email($email);
        //validate
        //if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!is_valid_email($email)) {
            echo("Invalid email address");
            $hasErrors = true;
        }
    } else {
        if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
            echo("Username must only be alphanumeric and can only contain - or _");
            $hasErrors = true;
        }
    }
    if (empty($password)) {
        echo("Password must be set");
        $hasErrors = true;
    }
    if (strlen($password) < 8) {
        //hello array _push($errors, "Password must be 8 or more characters");
        echo("Password must be at least 8 characters");
        $hasErrors = true;
    }
    if ($hasErrors) {
        //Nothing to output here, echo will do it
        //can likely flip the if condition
        //echo "<pre>" . var_export($errors, true) . "</pre>";
    } else {
       
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, email, password FROM users WHERE email = :email OR username = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        ///echo "Weclome $email";
                        $_SESSION["user"] = $user;

                        //header(("Location: home.php"));
                        //exit();
                        //echo(get_url("home.php"));
                        redirect("home.php");
                        
                        //header("Location: home.php");
                        //exit();

                    } else {
                        echo("Invalid password");
                    }
                } else {
                    echo("Email not found");
                }
            }
        } catch (Exception $e) {
            // hello echo  "<pre>" . var_export($e, true) . "</pre>";
            echo(var_export($e, true));
        }
    }
}




//REGISTER
if (isset($_POST["register"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $username = $_POST["username"];

    //TODO 3
    $hasError = false;
    if (empty($email)) {
        echo("Email must not be empty");
        $hasError = true;
    }
    //sanitize
    $email = sanitize_email($email);
    //validate
    if (!is_valid_email($email)) {
        echo("Invalid email address");
        $hasError = true;
    }
    if (!preg_match('/^[a-z0-9_-]{3,16}$/i', $username)) {
        echo("Username must only be alphanumeric and can only contain - or _");
        $hasError = true;
    }
    if (empty($password)) {
        echo("password must not be empty");
        $hasError = true;
    }
    if (empty($confirm)) {
        echo("Confirm password must not be empty");
        $hasError = true;
    }
    if (strlen($password) < 8) {
        echo("Password too short");
        $hasError = true;
    }
    if (
        strlen($password) > 0 && $password !== $confirm
    ) {
        echo("Passwords must match");
        $hasError = true;
    }
    if (!$hasError) {
        //TODO 4
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            //header(("Location: login_registration.php"));
            echo("Succesfully generated new account.");
            //echo("Successfully registered!");

            //echo '<script>window.location.reload();</script>';
          } catch (Exception $e) {
            echo($e);
        }
    }
}


?>


