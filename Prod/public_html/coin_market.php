<?php require(__DIR__."/../partials/nav.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  
<canvas id="cryptoChart"></canvas>
    <script>
        // Function to fetch data from the backend PHP script and render the chart
        function fetchCryptoData() {
            fetch('/coinmarketcap.php') // The URL to your backend endpoint
                .then(response => response.json())
                .then(data => {
                    const labels = data.data.map(coin => coin.name);
                    const prices = data.data.map(coin => coin.quote.USD.price);
                    renderChart(labels, prices);
                })
                .catch(error => console.error('Error:', error));
        }

        // Function to render the chart using Chart.js
        function renderChart(labels, prices) {
            const ctx = document.getElementById('cryptoChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cryptocurrency Prices (USD)',
                        data: prices,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Price (USD)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Cryptocurrency'
                            }
                        }
                    }
                }
            });
        }

        // Call the function to fetch data and render the chart when the page loads
        fetchCryptoData();
    </script>

<div id="bitcoinPriceDisplay"></div>

<script>
document.getElementById('getBitcoinPrice').addEventListener('click', function() {
    fetch('/coinmarketcap.php') // The URL to your backend endpoint
        .then(response => response.json())
        .then(data => {
            const price = data.data[0].quote.USD.price; // Assuming you're looking for the USD price of the first listing
            document.getElementById('bitcoinPriceDisplay').innerText = `Bitcoin Price: $${price}`;
        })
        .catch(error => console.error('Error:', error));
});
</script>


    <?php require(__DIR__ . "/../partials/footer.php"); ?>