<?php
// Display errors for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

// Include Twilio PHP library
// Used Twilio php script as reference
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv; 
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Twilio\Rest\Client;


$accountSid = $_ENV['TWILIO_ACCOUNT_SID'];
$authToken = $_ENV['TWILIO_AUTH_TOKEN'];

// Creates Twilio client
$client = new Client($accountSid, $authToken);

// Twilio phone number
$fromNumber = '+18447804982'; // Your Twilio phone number

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recipient's phone number from the form input
    $toNumber = $_POST['toNumber']; // The recipient's phone number from the form

    // Test message
    $messageBody = 'Hello, this is a test message!'; // Default message

    try {
        // Send SMS via Twilio
        $message = $client->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => $messageBody
            ]
        );

        echo 'SMS sent! SID: ' . $message->sid;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send SMS</title>
</head>
<body>
    <h2>Send SMS</h2>
    <form method="post">
        <label for="toNumber">Recipient's Phone Number:</label>
        <input type="text" id="toNumber" name="toNumber" required>
        <br><br>
        <input type="submit" value="Send SMS">
    </form>
</body>
</html>
