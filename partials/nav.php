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

    <script src="js/form_validation.js"></script>

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
