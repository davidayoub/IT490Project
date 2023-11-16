// Replace 'YOUR_API_KEY' with your CoinMarketCap API key
const apiKey = '219b084a-046f-4830-9153-73a489b44cfc';

// Function to fetch cryptocurrency data from CoinMarketCap
async function getCoinData(coinId) {
    try {
        const response = await fetch(`https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?id=${coinId}`, {
            method: 'GET',
            headers: {
                'X-CMC_PRO_API_KEY': apiKey,
                'Accept': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching data from CoinMarketCap:', error);
        throw error;
    }
}


function addStockToPortfolio() {
    const symbolInput = document.getElementById('stock-symbol');
    const symbol = symbolInput.value.trim().toUpperCase();
    
    if (symbol === '') {
        alert('Please enter a valid stock symbol.');
        return;
    }

    getCoinData(symbol)
        .then(data => {
            // Process the stock data and update the portfolio table
            const stockName = data['Meta Data']['2. Symbol'];
            const price = data['Time Series (1min)'][Object.keys(data['Time Series (1min)'])[0]]['1. open'];
            // You can also get more data like current price, historical data, etc.

            // Create a new row in the portfolio table
            const portfolioTable = document.getElementById('portfolio-table');
            const newRow = portfolioTable.insertRow(-1);

            newRow.insertCell(0).textContent = symbol;
            newRow.insertCell(1).textContent = stockName;
            newRow.insertCell(2).textContent = '1'; // Number of shares (you can add input field to input this)
            newRow.insertCell(3).textContent = price;
            newRow.insertCell(4).textContent = price; // Value = Price * Shares
        })
        .catch(error => {
            alert('Error fetching stock data. Please try again later.');
        });

    symbolInput.value = ''; // Clear the input field
}

// Add event listener to the "Add Stock" button
document.getElementById('add-stock').addEventListener('click', addStockToPortfolio);
