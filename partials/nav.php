<?php
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true;
//some people have issues with localhost for the cookie params
//if you're one of those people make this false
//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();
require_once(__DIR__ . "/../lib/functions.php");
//require(__DIR__ . "/flash.php");


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

    <script src="/public_html/js/form_validation.js"></script>

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


<nav class="my-navbar-color text-white shadow-md">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <a href="#" class="text-2xl font-bold">BrandName</a>
            </div>
            <div>
                <ul class="flex space-x-4">
                    <li><a href="home.php" class="hover:text-gray-300">Home</a></li>
                    <li><a href="login_register.php" class="hover:text-gray-300">Register</a></li>
                    <li><a href="services.php" class="hover:text-gray-300">Services</a></li>
                    <li><a href="contact.php" class="hover:text-gray-300">Contact</a></li>
                    <?php if(isset($_SESSION['user'])):?>
                        <li><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
                    <?php endif; ?>
                    
                </ul>
            </div>
        </div>
    </div>
</nav>
<style>
:root {
    --theme-color-primary: #8c0327;
    --theme-color-secondary: #f6d860;
}

.my-navbar-color{
    background-color: var(--theme-color-primary);

}

.my-footer-color {
    background-color: var(--theme-color-primary);
}


.btn-custom {
    background-color: #8c0327; /* Change this to your desired color */
    color: white;
}

.btn-custom:hover {
    background-color: #8c0327; /* Slightly darker shade for hover effect. Change this as needed. */
}

</style>