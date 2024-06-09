<?php
require_once "koneksi.php";
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

$isJson = false;
if (isset($_GET['fitur'])) {
    $isJson = true;
    $_GET['fitur']();
}
function pesertaGet($param1 = false, $param2 = false)
{
    if (!$param1)
        $param1 = $_GET['param1'];
    if (!$param2)
        $param2 = $_GET['param2'];
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/peserta/" . $param1 . "/" . $param2; //nik atau noka; nomronya
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function poliGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/poli/fktp/0/20";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function providerGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/provider/0/100";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function pendaftaranAdd()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/pendaftaran";
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
        "rujukBalik" => '0', //Belum tau apa itu rujuk balik
        "kdTkp" => $_POST['kdTkp']
    ]);

    global $conn;
    $d = strtotime("+7 Hours");
    $waktu = date("Y-m-d H:i:s", $d);
    $conn->query("INSERT INTO antrian (waktu, id_pasien, nama_pasien, alamat_pasien, tensi, berat, tinggi, suhu, status) VALUES ('$waktu', '{$_POST['id']}', '{$_POST['nama']}', '{$_POST['alamat']}', '{$_POST['tensi']}', '{$_POST['berat']}', '{$_POST['tinggi']}', '{$_POST['suhu']}', 'Mengantri')");
    return api($arrCurl, $GLOBALS['isJson']);
}
function pendaftaranGetTgl($param1 = false)
{
    if (!$param1)
        $param1 = $_GET['param1'];
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/pendaftaran/tglDaftar/" . $param1 . "/0/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function pendaftaranGetUrut($param1 = false, $param2 = false)
{
    if (!$param1)
        $param1 = $_GET['param1'];
    if (!$param2)
        $param2 = $_GET['param2'];
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/pendaftaran/noUrut/" . $param1 . "/tglDaftar/" . $param2;
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function kunjunganAdd()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/kunjungan";
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
    return api($arrCurl, $GLOBALS['isJson']);
}
function alergiGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/alergi/jenis/" . $_GET['param1'];
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function prognosaGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/prognosa";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function diagnosaGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/diagnosa/" . $_GET['param1'] . "/1/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function kesadaranGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/kesadaran";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function dokterGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/dokter/1/15";
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
function statusPulangGet()
{
    $arrCurl = $GLOBALS['arrCurl'];
    $arrCurl[CURLOPT_URL] = $GLOBALS['baseUrl'] . "/statuspulang/rawatInap/" . $_GET['param1'];
    $arrCurl[CURLOPT_CUSTOMREQUEST] = "GET";
    $arrCurl[CURLOPT_HTTPHEADER][6] = "content-type: application/json";
    return api($arrCurl, $GLOBALS['isJson']);
}
// $fitur = $_GET['fitur'];
// if ($fitur == 'peserta-get') {
// } else if ($fitur == 'poli-get') {
// } else if ($fitur == 'provider-get') {
// } else if ($fitur == 'pendaftaran-add') {
// } else if ($fitur == 'pendaftaran-get-tgl') {
// } else if ($fitur == 'pendaftaran-get-urut') {
// } else if ($fitur == 'kunjungan-add') {
// } else if ($fitur == 'alergi-get') {
// } else if ($fitur == 'prognosa-get') {
// } else if ($fitur == 'diagnosa-get') {
// } else if ($fitur == 'kesadaran-get') {
// } else if ($fitur == 'dokter-get') {
// } else if ($fitur == 'status-pulang-get') {
// }
function api($arrCurl, $isJson)
{
    $curl = curl_init();
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

    // $datanya = array(
    //     // "X-cons-id" => $consId,
    //     // "X-Timestamp" => $tStamp,
    //     // "X-Signature" => $signature,
    //     // "X-Authorization" =>  "Basic " . $auth,
    //     // "user_key" => $userkeyPCare,
    //     // "arrCurl" => $arrCurl,
    //     "result" => $hasil,
    //     "hasil_dekrip" => json_decode(decompress(stringDecrypt($GLOBALS['consId'] . $GLOBALS['secretKey'] . $GLOBALS['tStamp'], $hasil['response'])), true)
    // );

    if ($isJson) {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        if (substr((string)$hasil['metaData']['code'], 0, 1) == 2) {
            $hasil = json_decode(decompress(stringDecrypt($GLOBALS['consId'] . $GLOBALS['secretKey'] . $GLOBALS['tStamp'], $hasil['response'])), true);
        }
        echo json_encode($hasil);
    } else {
        return json_decode(decompress(stringDecrypt($GLOBALS['consId'] . $GLOBALS['secretKey'] . $GLOBALS['tStamp'], $hasil['response'])), true);
    }
}
