<?php
require(__DIR__."/../partials/nav.php");
?>

<style>
/* Add CSS to center and size tshe TradingView widget */
.tradingview-widget-container {
  width: 100%; /* full width of the parent element */
  min-width: 300px; /* minimum width */
  max-width: 1000px; /* maximum width */
  margin: auto; /* for center alignment if needed */
}

.tradingview-widget-container__widget {
  width: 100%; /* full width of the container */
  height: auto; /* height adjusts based on width */
  min-height: 300px; /* minimum height */
  max-height: 600px; /* maximum height */
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}


footer {
  width: 100%;
  /* Other styles like background, padding, etc. */
}

</style>

<?php
function fetchCryptoSymbols() {
  $apiKey = 'e61d0018-348a-4eec-8612-5576455dc2a8'; // Replace with your CoinMarketCap API key
  $apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
  $headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: ' . $apiKey
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => 1
]);

$response = curl_exec($curl);
curl_close($curl);

if ($response) {
    $data = json_decode($response, true);
    $symbols = [];

    foreach ($data['data'] as $crypto) {
        // Assume 'BITSTAMP' is the correct exchange - adjust if necessary
        $symbols[] = [$crypto['name'], "BITSTAMP:" . $crypto['symbol']];
    }

    return json_encode($symbols);
} else {
    return json_encode([]);
}
}

$symbolsJson = fetchCryptoSymbols();

?>


<script type="text/javascript">
  var cryptoSymbols = <?php echo $symbolsJson; ?>;

  function loadTradingViewWidget() {
    new TradingView.widget({
      "container_id": "tradingview_cryptos",
      "symbols": cryptoSymbols,
      "gridLineColor": "#e9e9ea",
      "fontColor": "#83888D",
      "width": 500,
      "height": 500,
      "locale": "en",
      "colorTheme": "light",
      "autosize": true,
      // ... other widget configuration options ...
    });
  }

  (function() {
    var script = document.createElement('script');
    script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js';
    script.async = true;
    script.onload = loadTradingViewWidget;
    document.head.appendChild(script);
  })();
</script>








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
  "width": 500,
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




<div class="tradingview-widget-container1">
  <div id="tradingview_cryptos"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"> </script>
  <script type="text/javascript">
    new TradingView.widget(
      {
        "container_id": "tradingview_cryptos",
        "symbols": cryptoSymbols,
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




<?php
require(__DIR__ . "/../partials/footer.php");
?>
