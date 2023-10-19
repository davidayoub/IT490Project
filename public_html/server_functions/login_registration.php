<?php
//require(__DIR__. "/../server_functions/login_registration.php");
//require(__DIR__ . "/../../partials/nav.php");


//LOGIN
if (isset($_POST["loginForm"]) && isset($_POST["username"]) && isset($_POST["password"])) {
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
        flash("Username or email must be set", "warning");
        $hasErrors = true;
    }
    //sanitize
    //$email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (str_contains($email, "@")) {
        $email = sanitize_email($email);
        //validate
        //if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!is_valid_email($email)) {
            flash("Invalid email address", "warning");
            $hasErrors = true;
        }
    } else {
        if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
            flash("Username must only be alphanumeric and can only contain - or _");
            $hasErrors = true;
        }
    }
    if (empty($password)) {
        flash("Password must be set");
        $hasErrors = true;
    }
    if (strlen($password) < 8) {
        //hello array _push($errors, "Password must be 8 or more characters");
        flash("Password must be at least 8 characters", "warning");
        $hasErrors = true;
    }
    if ($hasErrors) {
        //Nothing to output here, flash will do it
        //can likely flip the if condition
        //echo "<pre>" . var_export($errors, true) . "</pre>";
    } else {
        //TODO 4
        $db = getDB();
        $stmt = $db->prepare("SELECT id, name, email, password from Users where email = :email or name = :email");
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
                        //lookup potential roles
                        // example header ("Location: " . get_url("home.php"));
                        //exmple exit();
                    
                        redirect("home.php");
                        //hello die (header("Location: home.php"));
                    } else {
                        flash("Invalid password", "danger");
                    }
                } else {
                    flash("Email not found", "danger");
                }
            }
        } catch (Exception $e) {
            // hello echo  "<pre>" . var_export($e, true) . "</pre>";
            flash(var_export($e, true));
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
        $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("Successfully registered!");
            //echo '<script>window.location.reload();</script>';
          } catch (Exception $e) {
            echo($e);
        }
    }
}


?>


