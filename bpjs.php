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
$kodePPK = '095';
$consId = $_ENV['CONS_ID'];
$secretKey = $_ENV['SECRET_KEY'];
$userkeyPCare = $_ENV['USER_KEY_PCARE'];
$username = $_ENV['USERNAME'];
$password = $_ENV['PASSWORD'];
$auth = base64_encode($username . ":" . $password . ":" . $kodePPK);
$variabel1 = $consId . "&" . $tStamp;
$signature = base64_encode(hash_hmac('sha256', $variabel1, $secretKey, true));

$baseUrl = "https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev";
$curl = curl_init();
$arrCurl = [
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_POSTFIELDS => json_encode([
    //     "kdProviderPeserta" => "0114A026",
    //     "tglDaftar" => "02-06-2024",
    //     "noKartu" => "0002203227516",
    //     "kdPoli" => "002",
    //     "keluhan" => null,
    //     "kunjSakit" => true,
    //     "sistole" => 10,
    //     "diastole" => 20,
    //     "beratBadan" => 60,
    //     "tinggiBadan" => 160,
    //     "respRate" => 0,
    //     "lingkarPerut" => 48,
    //     "heartRate" => 0,
    //     "rujukBalik" => 0,
    //     "kdTkp" => "10"
    // ]),
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "X-cons-id: " . $consId,
        "X-timestamp: " . $tStamp,
        "X-signature: " . $signature,
        "X-authorization: Basic " . $auth,
        "user_key: " . $userkeyPCare
    ],
];

$fitur = $_GET['fitur'];
if ($fitur == 'peserta-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/peserta/" . $_GET['param1'] . "/" . $_GET['param2']; //nik atau noka; nomronya
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'poli-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/poli/fktp/0/20";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'provider-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/provider/0/100";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'pendaftaran-add') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/pendaftaran";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "POST";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: text/plain";
    $arrCurl[CURLOPT_POSTFIELDS] = json_encode([
        "kdProviderPeserta" => $_POST['kdProviderPeserta'],
        "tglDaftar" => $_POST['tglDaftar'],
        "noKartu" => $_POST['noKartu'],
        "kdPoli" => $_POST['kdPoli'],
        "keluhan" => $_POST['keluhan'],
        "kunjSakit" => $_POST['kunjSakit'],
        "sistole" => $_POST['sistole'],
        "diastole" => $_POST['diastole'],
        "beratBadan" => $_POST['beratBadan'],
        "tinggiBadan" => $_POST['tinggiBadan'],
        "respRate" => $_POST['respRate'],
        "lingkarPerut" => $_POST['lingkarPerut'],
        "heartRate" => $_POST['heartRate'],
        "rujukBalik" => $_POST['rujukBalik'],
        "kdTkp" => $_POST['kdTkp']
    ]);
} else if ($fitur == 'pendaftaran-get-tgl') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/pendaftaran/tglDaftar/" . $_GET['param1'] . "/0/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'pendaftaran-get-urut') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/pendaftaran/noUrut/" . $_GET['param1'] . "/tglDaftar/" . $_GET['param2'];
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'kunjungan-add') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/kunjungan";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "POST";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: text/plain";
    $arrCurl[CURLOPT_POSTFIELDS] = json_encode([
        "noKunjungan" => $_POST[''],
        "noKartu" => $_POST[''],
        "tglDaftar" => $_POST[''],
        "kdPoli" => $_POST[''],
        "keluhan" => $_POST[''],
        "kdSadar" => $_POST[''],
        "sistole" => $_POST[''],
        "diastole" => $_POST[''],
        "beratBadan" => $_POST[''],
        "tinggiBadan" => $_POST[''],
        "respRate" => $_POST[''],
        "heartRate" => $_POST[''],
        "lingkarPerut" => $_POST[''],
        "kdStatusPulang" => $_POST[''],
        "tglPulang" => $_POST[''],
        "kdDokter" => $_POST[''],
        "kdDiag1" => $_POST[''],
        "kdDiag2" => $_POST[''],
        "kdDiag3" => $_POST[''],
        "kdPoliRujukInternal" => $_POST[''],
        "rujukLanjut" => [
            "tglEstRujuk" => $_POST[''],
            "kdppk" => $_POST[''],
            "subSpesialis" => [
                "kdSubSpesialis1" => $_POST[''],
                "kdSarana" => $_POST['']
            ],
            "khusus" => [
                "kdKhusus" => $_POST[''],
                "kdSubSpesialis" => $_POST[''],
                "catatan" => $_POST['']
            ]
        ],
        "kdTacc" => $_POST[''],
        "alasanTacc" => $_POST[''],
        "anamnesa" => $_POST[''],
        "alergiMakan" => $_POST[''],
        "alergiUdara" => "00",
        "alergiObat" => "00",
        "kdPrognosa" => "01",
        "terapiObat" => "test terapi obat",
        "terapiNonObat" => "test terapi nonobat",
        "bmhp" => "bmhp",
        "suhu" => "36,4"
    ]);
}


curl_setopt_array($curl, $arrCurl);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    return "cURL Error #:" . $err;
}
$hasil = json_decode($response, true);


// ------------ DEKRIPSI --------------- //
include 'LZ/LZContext.php';
include 'LZ/LZData.php';
include 'LZ/LZReverseDictionary.php';
include 'LZ/LZString.php';
include 'LZ/LZUtil.php';
include 'LZ/LZUtil16.php';

function stringDecrypt($key, $string)
{
    $encrypt_method = 'AES-256-CBC';
    $key_hash = hex2bin(hash('sha256', $key));
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
    return $output;
}
function decompress($string)
{
    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
}

$datanya = array(
    "X-cons-id" => $consId,
    "X-Timestamp" => $tStamp,
    "X-Signature" => $signature,
    "X-Authorization" =>  "Basic " . $auth,
    "user_key" => $userkeyPCare,
    "arrCurl" => $arrCurl,
    "result" => $hasil,
    "hasil_dekrip" => json_decode(decompress(stringDecrypt($consId . $secretKey . $tStamp, $hasil['response'])), true)
);


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($datanya);
