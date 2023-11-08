<?php
require(__DIR__."/../partials/nav.php");
//require(__DIR__."/server_functions/auth_server.php")
?>
<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Trading Graph</title>
    </head>
    <body>
       <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
  {
  "symbols": [
    [
      "Apple",
      "AAPL|1D"
    ],
    [
      "Google",
      "GOOGL|1D"
    ],
    [
      "NASDAQ:TSLA|1D"
    ],
    [
      "COINBASE:BTCUSD|1D"
    ],
    [
      "NASDAQ:AMZN|1D"
    ],
    [
      "NASDAQ:MSFT|1D"
    ],
    [
      "BITSTAMP:ETHUSD|1D"
    ],
    [
      "NASDAQ:NVDA|1D"
    ],
    [
      "AMEX:SPY|1D"
    ],
    [
      "NASDAQ:NFLX|1D"
    ],
    [
      "NYSE:PLTR|1D"
    ]
  ],
  "chartOnly": false,
  "width": 1000,
  "height": 500,
  "locale": "en",
  "colorTheme": "light",
  "autosize": false,
  "showVolume": false,
  "showMA": false,
  "hideDateRanges": false,
  "hideMarketStatus": false,
  "hideSymbolLogo": false,
  "scalePosition": "right",
  "scaleMode": "Normal",
  "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
  "fontSize": "10",
  "noTimeScale": false,
  "valuesTracking": "1",
  "changeMode": "price-and-percent",
  "chartType": "area",
  "maLineColor": "#2962FF",
  "maLineWidth": 1,
  "maLength": 9,
  "lineWidth": 2,
  "lineType": 0,
  "dateRanges": [
    "1d|1",
    "1m|30",
    "3m|60",
    "12m|1D",
    "60m|1W",
    "all|1M"
  ]
}
  </script>
</div>
<!-- TradingView Widget END -->



    </body>



</head>
</html>
