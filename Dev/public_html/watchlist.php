<?php
require(__DIR__."/../partials/nav.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Watchlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #watchlist {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Stock Watchlist</h1>

<div>
    <label for="stockInput">Enter Stock Symbol:</label>
    <input type="text" id="stockInput" placeholder="e.g., AAPL">
    <button onclick="addStock()">Add Stock</button>
</div>

<div id="watchlist">
    <h2>Your Watchlist</h2>
    <ul id="stockList"></ul>
</div>

<script>
    // JavaScript code for handling stock watchlist

    // Function to add stock to the watchlist
    async function addStock() {
        var stockInput = document.getElementById("stockInput");
        var stockSymbol = stockInput.value.toUpperCase(); // Convert to uppercase for consistency

        if (stockSymbol.trim() === "") {
            alert("Please enter a valid stock symbol.");
            return;
        }

        // Check if the stock is already in the watchlist
        var stockList = document.getElementById("stockList");
        var existingStocks = stockList.getElementsByTagName("li");

        for (var i = 0; i < existingStocks.length; i++) {
            if (existingStocks[i].getAttribute("data-symbol") === stockSymbol) {
                alert("Stock is already in the watchlist.");
                stockInput.value = ""; // Clear the input field
                return;
            }
        }

        // Fetch stock information from Alpha Vantage API
        try {
            const apiKey = "5CWTZX137YS98CT6"; // Replace with your API key
            const apiUrl = `https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=${stockSymbol}&apikey=${apiKey}`;
            const response = await fetch(apiUrl);
            const data = await response.json();

            // Extract relevant information
            const companyName = data["Global Quote"]["01. symbol"];
            const companyPrice = data["Global Quote"]["05. price"];
            const priceChange = data["Global Quote"]["09. change"];

            // Create a new list item for the stock and add it to the watchlist
            var newStock = document.createElement("li");
            newStock.textContent = `${companyName} (${stockSymbol}): Current Price  - ${companyPrice} Price Change - ${priceChange}`;
            newStock.setAttribute("data-symbol", stockSymbol);
            stockList.appendChild(newStock);

            // Clear the input field
            stockInput.value = "";
        } catch (error) {
            console.error("Error fetching stock information:", error);
            alert("Error fetching stock information. Please try again.");
        }
    }
</script>

</body>
</html>