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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
        }

        input {
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Stock Watchlist</h1>

    <form id="addStockForm">
        <label for="symbol">Symbol:</label>
        <input type="text" id="symbol" required>
        <button type="submit">Add Stock</button>
    </form>
    
    <table id="stockTable">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Company</th>
                <th>Price (USD)</th>
                <th>Change (%)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Stock rows will be added dynamically -->
        </tbody>
    </table>

    <script>
        // Function to get the latest stock information
        function getStockInfo(symbol) {
            // Implement logic to fetch stock data from your API
            // For simplicity, we're using hardcoded data here
            return {
                symbol,
                company: 'Company',
                price: Math.random() * 100,
                change: Math.random() * 10 - 5,
            };
        }

        // Function to populate the table with stock data
        function populateTable(stockList) {
            const tableBody = document.querySelector('#stockTable tbody');

            // Clear existing rows
            tableBody.innerHTML = '';

            // Loop through stockList and add rows to the table
            stockList.forEach(stock => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${stock.symbol}</td>
                    <td>${stock.company}</td>
                    <td>${stock.price.toFixed(2)}</td>
                    <td>${stock.change.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Function to handle form submission
        function addStock(event) {
            event.preventDefault();
            const symbolInput = document.querySelector('#symbol');
            const symbol = symbolInput.value.toUpperCase();

            if (symbol.trim() === '') {
                alert('Please enter a valid stock symbol.');
                return;
            }

            // Fetch stock data and add to the watchlist
            const stockData = getStockInfo(symbol);
            const watchlist = JSON.parse(localStorage.getItem('watchlist')) || [];
            watchlist.push(stockData);
            localStorage.setItem('watchlist', JSON.stringify(watchlist));

            // Repopulate the table with updated watchlist
            populateTable(watchlist);

            // Clear the symbol input
            symbolInput.value = '';
        }

        // Attach event listener to the form
        const addStockForm = document.querySelector('#addStockForm');
        addStockForm.addEventListener('submit', addStock);

        // Initial population of the table with stored watchlist
        const initialWatchlist = JSON.parse(localStorage.getItem('watchlist')) || [];
        populateTable(initialWatchlist);
    </script>
</body>
</html>
