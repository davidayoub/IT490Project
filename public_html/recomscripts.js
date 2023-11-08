
// script.js

// Function to fetch cryptocurrency data from CoinMarketCap API
async function fetchCryptoData(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching cryptocurrency data:', error);
    }
}

// Function to display top gainers and losers
async function displayRecommendations() {
    const apiKey = '219b084a-046f-4830-9153-73a489b44cfc'; // Replace with your CoinMarketCap API key
    const url = `https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?start=1&limit=10&convert=USD&sort=percent_change_24h&CMC_PRO_API_KEY=${apiKey}`;

    const data = await fetchCryptoData(url);
    const topGainers = data.data.slice(0, 5);
    const topLosers = data.data.slice(-5);

    const topGainersDiv = document.getElementById('top-gainers');
    const topLosersDiv = document.getElementById('top-losers');

    // Display top gainers
    topGainers.forEach((crypto) => {
        const card = createCryptoCard(crypto);
        topGainersDiv.appendChild(card);
    });

    // Display top losers
    topLosers.forEach((crypto) => {
        const card = createCryptoCard(crypto);
        topLosersDiv.appendChild(card);
    });
}

// Create a card to display cryptocurrency data
function createCryptoCard(crypto) {
    const card = document.createElement('div');
    card.className = 'crypto-card';

    const name = document.createElement('h3');
    name.textContent = crypto.name;

    const symbol = document.createElement('p');
    symbol.textContent = crypto.symbol;

    const price = document.createElement('p');
    price.textContent = `$${crypto.quote.USD.price.toFixed(2)}`;

    const percentChange = document.createElement('p');
    percentChange.textContent = `Change (24h): ${crypto.quote.USD.percent_change_24h.toFixed(2)}%`;

    card.appendChild(name);
    card.appendChild(symbol);
    card.appendChild(price);
    card.appendChild(percentChange);

    return card;
}

// Initialize the recommendations page
window.addEventListener('load', displayRecommendations);
