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
        "noKunjungan" => $_POST['noKunjungan'],
        "noKartu" => $_POST['noKartu'],
        "tglDaftar" => $_POST['tglDaftar'],
        "kdPoli" => $_POST['kdPoli'],
        "keluhan" => $_POST['keluhan'],
        "kdSadar" => $_POST['kdSadar'],
        "sistole" => $_POST['sistole'],
        "diastole" => $_POST['diastole'],
        "beratBadan" => $_POST['beratBadan'],
        "tinggiBadan" => $_POST['tinggiBadan'],
        "respRate" => $_POST['respRate'],
        "heartRate" => $_POST['heartRate'],
        "lingkarPerut" => $_POST['lingkarPerut'],
        "kdStatusPulang" => $_POST['kdStatusPulang'],
        "tglPulang" => $_POST['tglPulang'],
        "kdDokter" => $_POST['kdDokter'],
        "kdDiag1" => $_POST['kdDiag1'],
        "kdDiag2" => $_POST['kdDiag2'],
        "kdDiag3" => $_POST['kdDiag3'],
        "kdPoliRujukInternal" => $_POST['kdPoliRujukInternal'],
        "rujukLanjut" => [
            "tglEstRujuk" => $_POST['tglEstRujuk'],
            "kdppk" => $_POST['kdppk'],
            "subSpesialis" => [
                "kdSubSpesialis1" => $_POST['kdSubSpesialis1'],
                "kdSarana" => $_POST['kdSarana']
            ],
            "khusus" => [
                "kdKhusus" => $_POST['kdKhusus'],
                "kdSubSpesialis" => $_POST['kdSubSpesialis'],
                "catatan" => $_POST['catatan']
            ]
        ],
        "kdTacc" => $_POST['kdTacc'],
        "alasanTacc" => $_POST['alasanTacc'],
        "anamnesa" => $_POST['anamnesa'],
        "alergiMakan" => $_POST['alergiMakan'],
        "alergiUdara" => $_POST['alergiUdara'],
        "alergiObat" => $_POST['alergiObat'],
        "kdPrognosa" => $_POST['kdPrognosa'],
        "terapiObat" => $_POST['terapiObat'],
        "terapiNonObat" => $_POST['terapiNonObat'],
        "bmhp" => $_POST['bmhp'],
        "suhu" => $_POST['suhu']
    ]);
} else if ($fitur == 'alergi-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/alergi/jenis/" . $_GET['param1'];
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'prognosa-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/prognosa";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'diagnosa-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/diagnosa/" . $_GET['param1'] . "/1/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'kesadaran-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/kesadaran";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'dokter-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/dokter/1/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
} else if ($fitur == 'status-pulang-get') {
    $arrCurl[CURLOPT_URL] = $baseUrl . "/statuspulang/rawatInap/" . $_GET['param1'];
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
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
