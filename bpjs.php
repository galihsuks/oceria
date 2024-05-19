<?php
date_default_timezone_set('UTC');
$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
$kodePPK = '0150G017';
$consId = '1384';
$secretKey = '8kQABD0F66';
$userkeyPCare = '002f4d85a8df265f8a4a1f46df3aec15';
$username = '0150G017';
$password = 'Sriumiati74#';
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
