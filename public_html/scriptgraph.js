// script.js

const axios = require('axios');

// Replace 'YOUR_API_KEY' with your actual CoinMarketCap API key
const apiKey = '219b084a-046f-4830-9153-73a489b44cfc';

// Function to fetch cryptocurrency data from CoinMarketCap
async function fetchCryptoData(symbol) {
    try {
        const response = await axios.get(`https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest`, {
            params: {
                symbol: symbol,
            },
            headers: {
                'X-CMC_PRO_API_KEY': apiKey,
            },
        });

        const data = response.data;
        if (data.status.error_code === 0) {
            const cryptoInfo = data.data[symbol];
            return cryptoInfo;
        } else {
            console.error(`Error: ${data.status.error_message}`);
            return null;
        }
    } catch (error) {
        console.error(`Error fetching cryptocurrency data: ${error}`);
        return null;
    }
}

// Function to create and update the chart
async function createChart() {
    const symbol = 'BTC'; // Replace with the symbol of the cryptocurrency you want to display
    const cryptoInfo = await fetchCryptoData(symbol);

    if (cryptoInfo) {
        const prices = cryptoInfo.quote.USD.price;

        const chartData = {
            labels: Object.keys(prices),
            datasets: [
                {
                    label: `${symbol} Price (USD)`,
                    data: Object.values(prices),
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false,
                },
            ],
        };

        const ctx = document.getElementById('cryptoChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    }
}

// Initialize the chart when the page loads
window.addEventListener('load', createChart);
