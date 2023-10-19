<?php
require(__DIR__ . "/../../partials/nav.php");
require(__DIR__. "/../server_functions/login_registration.php");

?>

<body class="bg-white">
    <!-- Main Section -->
    <div class="p-4"> <!-- Add padding to this container -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl font-bold text-var(--theme-color-primary) mt-4">Welcome!</h1>
        </div>
    </div>

    <!-- Login and Registration Modals -->
    <div class="flex justify-center">
        <!-- Login Modal -->
        <div id="loginModal" class="w-1/2 p-4">
            <div class="bg-white p-4 rounded space-y-4">
                <h5 class="text-3xl font-bold text-var(--theme-color-primary) mt-4">Login</h5>
                <!-- Add your login form here -->
            </div>
        </div>

        <!-- Registration Modal -->
        <div id="registerModal" class="w-1/2 p-4">
            <div class="bg-white p-4 rounded space-y-4">
                <h5 class="text-3xl font-bold text-var(--theme-color-primary) mt-4">Register now</h5>
                <!-- Add your registration form here -->
            </div>
        </div>
    </div>
</body>

<?php
require(__DIR__ . "/../../partials/footer.php");
?>