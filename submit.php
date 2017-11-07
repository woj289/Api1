<?php
$order_start      = $_POST['order_start'];
$order_stop       = $_POST['order_stop'];
$offer_difference = $_POST['offer_difference'];
$offer_value      = $_POST['offer_value'];
$offer_type       = $_POST['offer_type'];

// METODA WYKONUJĄCA REQUEST
function api($method, $params = null)
{
    global $engine;
    //$key    = "private account key";
    //$secret = "secret key";

    $params["moment"] = time();
    $params["method"] = $method;

    $post    = http_build_query($params, "", "&");
    $sign    = hash_hmac("sha512", $post, $secret);
    $headers = array(
        "API-Key: " . $key,
        "API-Hash: " . $sign
    );
    $curl    = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "https://bitbay.net/API/Trading/tradingApi.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $ret = curl_exec($curl);

    return $ret;
}

function randomFloat($option)
{
    $number = 0.00001;
    $satoshis = 100000000;
    switch ($option) {
        case 0:
            $from = 0.001;
            $to = 0.004;
            break;
        case 1:
            $from = 0.01;
            $to = 0.09;
            break;
        case 2:
            $from = 0.1;
            $to = 0.4;
            break;
        case 3:
            $from = 0.5;
            $to = 0.9;
            break;
        case 4:
            $from = 1.0;
            $to = 1.2;
            break;
    }
    return rand($from*$satoshis, $to*$satoshis)/$satoshis;
}

function reqTrade($order_value, $offer_value, $offer_type)
{
    $trade = array(
        "type" => $offer_type,
        "currency" => "btc",
        "amount" => $offer_value,
        "payment_currency" => "pln",
        "rate" => $order_value
    );
    $result = api('trade', $trade);
    echo $result;
    // echo "Wystawiam ";
    // echo $offer_value;
    // echo " BTC za ";
    // echo $order_value;
    // echo " PLN <br/>";
}

$i = $order_start + (mt_rand(1, 99) / 100);

while ($i <= $order_stop) {
    reqTrade($i, randomFloat($offer_value), $offer_type);
    $i = $i + $offer_difference + (mt_rand(1, 99) / 100);
}

?>
