<?php
require(__DIR__."/../partials/nav.php");
//require(__DIR__."/server_functions/auth_server.php") 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CoinMarketCap Recommendations</title>
    <link rel="stylesheet" type="text/css" href="recomstyle.css">
</head>
<body>
    <header>
        <h1>CoinMarketCap Recommendations</h1>
    </header>
    <main>
        <section>
            <h2>Top Gainers</h2>
            <div id="top-gainers"></div>
        </section>
        <section>
            <h2>Top Losers</h2>
            <div id="top-losers"></div>
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
