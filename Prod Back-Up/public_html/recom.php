<?php
require(__DIR__."/../partials/nav.php");
?>

<style>

    header, main, .tradingview-widget-container {
        width: 100%; /* Set a specific width or maximum width as needed */
        max-width: 1200px; /* Example max width */
        margin: auto; /* Auto margins on both sides */
    }
    .tradingview-widget-container {
        display: flex; /* Enables Flexbox */
        justify-content: center; /* Center the widget horizontally */
    }
    /* Add any additional styling you want for your header, main, and sections here */
</style>

<link rel="stylesheet" type="text/css" href="recomstyle.css">
<main class="bg-gray-100 p-8">
    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">CoinMarketCap Recommendations</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Top Gainers</h2>
        <div id="top-gainers" class="p-4 bg-white rounded-lg shadow-md">
            <!-- Content for top gainers goes here -->
        </div>
    </section>
    <section>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Top Losers</h2>
        <div id="top-losers" class="p-4 bg-white rounded-lg shadow-md">
            <!-- Content for top losers goes here -->
        </div>
    </section>
</main>

<script src="recomscripts.js"></script>

<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
    <div class="tradingview-widget-container__widget"></div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-hotlists.js" async>
        {
            "colorTheme": "light",
            "dateRange": "12M",
            "exchange": "US",
            "showChart": true,
            "locale": "en",
            "largeChartUrl": "",
            "isTransparent": false,
            "showSymbolLogo": false,
            "showFloatingTooltip": false,
            "width": "400",
            "height": "600",
            "plotLineColorGrowing": "rgba(41, 98, 255, 1)",
            "plotLineColorFalling": "rgba(41, 98, 255, 1)",
            "gridLineColor": "rgba(240, 243, 250, 0)",
            "scaleFontColor": "rgba(106, 109, 120, 1)",
            "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
            "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
            "symbolActiveColor": "rgba(41, 98, 255, 0.12)"
        }
    </script>
</div>
<!-- TradingView Widget END -->

</body>
</html>



<?php
require(__DIR__ . "/../partials/footer.php");
?>