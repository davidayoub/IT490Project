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
    <style>
        :root {
            --theme-color-primary: #8c0327;
            --theme-color-secondary: #f6d860;
        }
        .my-navbar-color{
            background-color: var(--theme-color-primary);
        }
        .btn-custom {
            background-color: #8c0327;
            color: white;
        }
        .btn-custom:hover {
            background-color: darken(#8c0327, 10%);
        }
        /* Additional styles */
    </style>

</head>

<div class="bg-black">
    <div class="max-w-screen-xl mx-auto px-4 py-3 text-white sm:text-center md:px-8">
        <p class="font-medium">
            Free crypto for referral! 
        </p>
    </div>
</div>



<nav class="bg-white border-b w-full md:static md:text-sm md:border-none">
        <div class="items-center px-4 max-w-screen-xl mx-auto md:flex md:px-8">
            <div class="flex items-center justify-between py-3 md:py-5 md:block">
                <!--
                <a href="javascript:void(0)">
                    <img
                        src="https://www.floatui.com/logo.svg"
                        width="120"
                        height="50"
                        alt="Float UI logo"
                    />
                </a>a
                -->
                TygerCrypto
                <div class="md:hidden">
                    <button class="text-gray-500 hover:text-gray-800" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="menu" class="hidden flex-1 pb-3 mt-8 md:block md:pb-0 md:mt-0">
                <ul class="justify-end items-center space-y-6 md:flex md:space-x-6 md:space-y-0">
                    
                    <li class="text-gray-700 hover:text-indigo-600"><a href="home.php" class="hover:text-gray-300">Home</a></li>
                    <li class="text-gray-700 hover:text-indigo-600"><a href="services.php" class="hover:text-gray-300">Services</a></li>
                    <li class="text-gray-700 hover:text-indigo-600"><a href="contact.php" class="hover:text-gray-300">Contact</a></li>
                    <?php if(isset($_SESSION['user'])):?>
                        
                        <li class="text-gray-700 hover:text-indigo-600"><a href="cryptonews.php" class="hover:text-gray-300">News</a></li>
                        <li class="text-gray-700 hover:text-indigo-600"><a href="CryptoPortfolio.html" class="hover:text-gray-300">Portfolio</a></li>
                        <li class="text-gray-700 hover:text-indigo-600"><a href="CryptoGraph.php" class="hover:text-gray-300">Graph</a></li>
                        <li class="text-gray-700 hover:text-indigo-600"><a href="recom.php" class="hover:text-gray-300">Recommendations</a></li>
                    <?php endif; ?>

                    <!-- Add more list items as needed -->
                    <span class='hidden w-px h-6 bg-gray-300 md:block'></span>
                    <div class='space-y-3 items-center gap-x-6 md:flex md:space-y-0'>
                        <?php if (!isset($_SESSION['user'])): ?>
                        <li class="text-gray-700 hover:text-indigo-600">
                            <a href="/login_register.php" class="block py-3 text-center text-gray-700 hover:text-indigo-600 border rounded-lg md:border-none">Login</a>                        
                        </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user'])): ?>
                        <li class="text-gray-700 hover:text-indigo-600"><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
                        <?php endif; ?>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }
    </script>