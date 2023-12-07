<?php
require(__DIR__."/../partials/nav.php");
?>

<style>
/* Add CSS to center and size the TradingView widget */
.tradingview-widget-container1 {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 500px; /* Set a minimum height for the container */
  width: 100%; /* Set the width to take the full width of the screen */
  min-width: 1000px; /* Set a minimum width for the container */
}

/* Ensure the widget container has no additional padding or margins that could affect its size */
.tradingview-widget-container__widget {
  width: 100%;
  height: 100%;
}
</style>

<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container1">
  <div id="tradingview_cryptos"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"> </script>
  <script type="text/javascript">
    new TradingView.widget(
      {
        "container_id": "tradingview_cryptos",
        "symbols": [
          ["Bitcoin", "BITSTAMP:BTCUSD"],
          ["Ethereum", "BITSTAMP:ETHUSD"],
          ["DogeCoin", "BINANCE:DOGEUSDT"],
          ["Ripple", "BITSTAMP:XRPUSD"],
          ["Solana", "COINBASE:SOLUSD"],
          ["Shiba Inu", "BINANCE:SHIBUSDT"],
          ["Cardano", "COINBASE:ADAUSD"],
          ["Verasity", "KUCOIN:VRAUSDT"],
          ["Litecoin", "COINBASE:LTCUSD"]
        ],
        "gridLineColor": "#e9e9ea",
        "fontColor": "#83888D",
        "underLineColor": "#dbeffb",
        "trendLineColor": "#4bafe9",
        "width": "100%", /* Set the width to 100% of the container */
        "height": "100%", /* Set the height to 100% of the container */
        "locale": "en",
        "colorTheme": "light",
        "autosize": true,
        "isTransparent": false,
        "showVolume": true,
        "scalePosition": "no",
        "scaleMode": "Normal",
        "fontFamily": "-apple-system, BlinkMacSystemFont, 'Trebuchet MS', Roboto, Ubuntu, 'Helvetica Neue', sans-serif",
        "noTimeScale": false,
        "valuesTracking": "1",
        "chartType": "area"
      }
    );
  </script>
</div>
<!-- TradingView Widget END -->



<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
  {
  "symbols": [
    ["Bitcoin", "BITSTAMP:BTCUSD"],
    ["Ethereum", "BITSTAMP:ETHUSD"],
    ["DogeCoin", "BINANCE:DOGEUSDT"],
    ["Ripple", "BITSTAMP:XRPUSD"],
    ["Solana", "COINBASE:SOLUSD"],
    ["Shiba Inu", "BINANCE:SHIBUSDT"],
    ["Cardano", "COINBASE:ADAUSD"],
    ["Verasity", "KUCOIN:VRAUSDT"],
    ["Litecoin", "COINBASE:LTCUSD"]
  ],
  "gridLineColor": "#e9e9ea",
  "fontColor": "#83888D",
  "underLineColor": "#dbeffb",
  "trendLineColor": "#4bafe9",
  "chartOnly": false,
  "width": 1000,
  "height": 500,
  "locale": "en",
  "colorTheme": "light",
  "autosize": true,
  "showVolume": false,
  "showMA": false,
  "hideDateRanges": false,
  "hideMarketStatus": false,
  "hideSymbolLogo": false,
  "scalePosition": "no",
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


<?php
require(__DIR__ . "/../partials/footer.php");
?>