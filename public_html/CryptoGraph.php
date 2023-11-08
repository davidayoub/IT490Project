<?php
require(__DIR__."/../partials/nav.php");
//require(__DIR__."/server_functions/auth_server.php")
?>
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
  {
  "symbols": [
    [
      "BITSTAMP:BTCUSD|1D"
    ],
    [
      "BITSTAMP:ETHUSD|1D"
    ],
    [
      "BINANCE:DOGEUSDT|1D"
    ],
    [
      "BITSTAMP:XRPUSD|1D"
    ],
    [
      "COINBASE:SOLUSD|1D"
    ],
    [
      "BINANCE:SHIBUSDT|1D"
    ],
    [
      "COINBASE:ADAUSD|1D"
    ],
    [
      "KUCOIN:VRAUSDT|1D"
    ],
    [
      "COINBASE:LTCUSD|1D"
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
<!-- TradingView Widget END →
\
