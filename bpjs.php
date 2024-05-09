<?php
date_default_timezone_set('UTC');
$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
$kodePPK = '0150G017';
$consId = '1384';
$secretKey = '8kQABD0F66';
$userkeyPCare = '002f4d85a8df265f8a4a1f46df3aec15';
$username = '0150G017';
$password = 'Sriumiati74#';
$auth = base64_encode($username . ":" . $password . ":" . $kodePPK);
$variabel1 = $consId . "&" . $tStamp;
$signature = base64_encode(hash_hmac('sha256', $variabel1, $secretKey, true));
$signatureCoba = base64_encode(hash_hmac('sha256', "testtesttest", "secretkey", true));



// $curl = curl_init();
// curl_setopt_array($curl, array(
//     CURLOPT_URL => "http://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/diagnosa/kesadaran",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => array(
//         "Accept: application/json",
//         "content-type: application/json",
//         "X-cons-id: " . $consId,
//         // "X-Timestamp: " . $tStamp,
//         // "X-Signature: " . $signature,
//         "X-Timestamp: 1715210770",
//         "X-Signature: ursI6mpNYG0FIyaLUfQsTGVsaF8pNdwaqyBypWrCKX8=",
//         "X-Authorization: Basic " . $auth
//     ),
// ));
// $response = curl_exec($curl);
// $err = curl_error($curl);
// curl_close($curl);
// if ($err) {
//     return "cURL Error #:" . $err;
// }
// $hasil = json_decode($response, true);
$datanya = array(
    "X-cons-id" => $consId,
    "X-Timestamp" => $tStamp,
    "X-Signature" => $signatureCoba,
    "X-Authorization" => "Basic " . $auth
);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// echo json_encode($hasil);
echo json_encode($datanya);
