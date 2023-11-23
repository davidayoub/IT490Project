<?php

// This is a backend PHP script that should be called from the frontend using AJAX.
// It makes a server-side request to CoinMarketCap's API and outputs the data.
$apiKey = 'e61d0018-348a-4eec-8612-5576455dc2a8';

//$apiKey = 'YOUR_COINMARKETCAP_API_KEY';
$apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

$headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: ' . $apiKey
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($curl);

curl_close($curl);

header('Content-Type: application/json');
echo $response;



?>