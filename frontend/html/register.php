<!doctype html>
    <html lang="en">
      <head>
         
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CDN -->
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
          
          <!--    Bootstrap local      -->
          <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css">
          
        <!-- Google fonts -->
<!--        <link href="https://fonts.googleapis.com/css?family=Barlow:400,700" rel="stylesheet">-->

        <!-- Custom CSS  -->
        <link rel="stylesheet" href="../css/styles.css">

      </head>
      <body>
</nav>

        <div class="container-fluid">
            <div class = "row">
                <div class = "col-sm-12" id = "main-holder">
                    <div class="row">
                        <div class = "col-sm-12" id = "welcome-heading">
                            Welcome! 
                        </div>
                    </div>

                    <div class="row">
                        <div class = "col-sm-12" id = "welcome-message">
                            Welcome to our website!
                        </div>
                    </div>

                    <!-- Row for  Register model buttons  -->
                    <div class = "row">
                        <div class = "col-sm-12" id = "register-button-holder">
                            <button>
                            <a href="login.html" data-toggle="modal" id = "login-modal-opener" data-target="#exampleModalCenter">Login</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<form onsubmit="return validate(this)" method="POST">
    <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

        <label for="email">Email</label>
        <input type="email" placeholder="Enter Email" name="email" required />
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" placeholder="Enter Username" name="username" required maxlength="30" />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" placeholder="Enter Password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" placeholder="Confirm Password" name="confirm" required minlength="8" />
        <hr>
        <input type="submit"><button class="block">Register
    </div>
    

    <div class="container signin">
            <p>Already have an account? <a href="login.html">Sign in</a>.</p>
          </div>

</form>


<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        return true;
    }
</script>
<?php
 //This is going to be a helper for redirecting to our base project path since it's nested in another folder


 function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        //added 07-05-2021 to fix case where $k of $v isn't set
        //this is to kep htmlspecialchars happy
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}
function flash($msg = "", $color = "info")
{
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}

function sanitize_email($email = "")
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
function is_valid_email($email = "")
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}


//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $username = se($_POST, "username", "", false);
    //TODO 3


    //$errors = [];
    $hasError = false;
    if (empty($email)) {
        flash("Email must not be empty");
        $hasError = true;
    }
    //$email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = sanitize_email($email);
    //validate
    //if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (!is_valid_email($email)) {
        flash("Invalid email");
        $hasError = true;
    }
    if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $username)) {
        flash("Username must only be alphanumeric and can only contain - or _");
        $hasError = true;
    }
    if (empty($password)) {
        flash("password must not be empty");
        $hasError = true;
    }
    if (empty($confirm)) {
        flash("Confirm password must not be empty");
        $hasError = true;
    }
    if (strlen($password) < 8) {
        flash("Password too short");
        $hasError = true;
    }
    if (strlen($password) > 0 && $password !== $confirm) {
        flash("Passwords must match");
        $hasError = true;
    }
    if ($hasError) {
        //flash("<pre>" . var_export($errors, true) . "</pre>");
    } else {
        //flash("Welcome, $email"); //will show on home.php
        $hash = password_hash($password, PASSWORD_BCRYPT);
        //$db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("You've registered, yay...");
        } catch (Exception $e) {
            /*flash("There was a problem registering");
            flash("<pre>" . var_export($e, true) . "</pre>");*/
            //users_check_duplicate($e->errorInfo);
        }
    }
}
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>git 