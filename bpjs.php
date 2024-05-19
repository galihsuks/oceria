<?php
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception('.env file not found.');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}
loadEnv(__DIR__ . '/.env');

date_default_timezone_set('UTC');
$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
$kodePPK = $_ENV['KODE_PPK'];
$consId = $_ENV['CONS_ID'];
$secretKey = $_ENV['SECRET_KEY'];
$userkeyPCare = $_ENV['USER_KEY_PCARE'];
$username = $_ENV['USERNAME'];
$password = $_ENV['PASSWORD'];
$auth = base64_encode($username . ":" . $password);
$variabel1 = $consId . "&" . $tStamp;
$signature = base64_encode(hash_hmac('sha256', $variabel1, $secretKey, true));

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev/kesadaran",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        "Accept: application/json",
        "content-type: application/json",
        "X-cons-id: " . $consId,
        "X-timestamp: " . $tStamp,
        "X-signature: " . $signature,
        "X-authorization: Basic " . $auth,
        "user_key: " . $userkeyPCare
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    return "cURL Error #:" . $err;
}
$hasil = json_decode($response, true);
$datanya = array(
    "X-cons-id" => $consId,
    "X-Timestamp" => $tStamp,
    "X-Signature" => $signature,
    "X-Authorization" =>  $auth,
    "user_key" => $userkeyPCare,
    "result" => $hasil
);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// echo json_encode($hasil);
echo json_encode($datanya);
