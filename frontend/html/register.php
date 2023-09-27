<!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CDN -->
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
          
          <!-- Bootstrap local -->
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
        

        <!-- Register Model -->
        <form onsubmit="return validate(this)" method="POST">
        <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
        
            <label for="email"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="Username" id="Username" required maxlength="30">
        
            <label for="pw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required minlength="8">
        
            <label for="confirm"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required minlength="8">
            <hr>
            <input type="submit"><button class="block">Register
          </div>
        
          <div class="container signin">
            <p>Already have an account? <a href="login.html">Sign in</a>.</p>
          </div>
        </form>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<!--        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
          
          
          <!--Local Bootstrap JS -->
          <script src = "../bootstrap/js/bootstrap.min.js">
              
          </script>


        <!-- Local bootstrap -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        
        <script type="text/javascript" src="../js/scripts.js">

        </script>


      </body>
    </html>
    <?php
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
?>



