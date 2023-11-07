<?php
require(__DIR__."/../partials/nav.php");
require_once(__DIR__.'/rabbitmqphp_example/rabbitMQLib.inc');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client = new rabbitMQClient(__DIR__ . "/rabbitmqphp_example/host.ini", "testServer");

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $request = array();
        $request['type'] = "login";
        $request['username'] = $username;
        $request['password'] = $password;
        
        $client = new rabbitMQClient("./rabbitmqphp_example/host.ini", "rabbitMQ");        
        $response = $client->send_request($request);
        var_dump($response);
    }

    // Similarly, you can handle registration here
    if (isset($_POST["register"])) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm = $_POST["confirm"];

        $request = array();
        $request['type'] = "register";
        $request['email'] = $email;
        $request['username'] = $username;
        $request['password'] = $password;
        $request['confirm'] = $confirm;
        
        $client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
        $response = $client->send_request($request);

        if ($response && $response["status"] === "success") {
            //redirect("home.php");
            echo("Succesfullly registered!" . $response["message"]);
        } else {
            echo "Registration failed: " . $response["message"];
        }
    }
}


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














?>
<body class="bg-white">
    <!-- Main Section -->
    <div class="p-4"> <!-- Add padding to this container -->
        <div class="text-center space-y-4">
            <h1>Welcome!</h1>
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
                        <button type="submit" name="login" value="name" class="btn btn-custom w-full" data-loading-text="Loading...">Sign In</button>
                        <p class="text-center">Forgot password? <a href="login.html">Reset</a>.</p>

                    </div>
                </form>
            </div>
        </div>

        <!-- Registration Modal -->
        <div id="registerModal" class="w-1/2 p-4">
            <div class="bg-white p-4 rounded space-y-4">
                <h5 class="text-3xl font-bold text-autumn-primary mt-4">Register now</h5>
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
                        <button type="submit" name="register" value="Register" class="btn btn-custom w-full">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<?php
require(__DIR__ . "/../partials/footer.php");
?>
