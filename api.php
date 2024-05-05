<?php
require_once "koneksi.php";

if (isset($_GET['function'])) {
    $_GET['function']();
}

//=============== KUNJUNGAN ===============//

function getAllKunjungan()
{
    global $conn;
    $queryAll = $conn->query("SELECT * FROM kunjungan");

    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM kunjungan LIMIT 25 OFFSET {$offset}");


    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Get All Kunjungan Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Get All Kunjungan Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}
function getKunjungan()
{
    global $conn;
    if (!empty($_GET["tgl"])) {
        $tgl = $_GET["tgl"];
        $urut = $_GET["urut"];
    }
    $query = $conn->query("SELECT * FROM kunjungan WHERE tgl_praktek LIKE '$tgl%' && NoUrut = '$urut'");
    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }

    if ($query) {
        $res = array(
            'message' => 'Get Kunjungan Success',
            'data' => $data[0]
        );
    } else {
        $res = array(
            'message' => 'Get Kunjungan Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    // return $data[0];
    header('Content-Type: application/json');
    echo json_encode($res);
}
function getKunjunganTanggal()
{
    global $conn;
    if (!empty($_GET["filter"])) {
        $tanggal = $_GET["filter"];
        $hari = explode("-", $tanggal)[2];
        $bulan = (int)explode("-", $tanggal)[1];
        $tahun = explode("-", $tanggal)[0];
    }
    $arrMonthIng = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    $arrMonthInd = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "Nopember",
        "Desember"
    ];
    $tanggalQuery1 = $hari . "-" . $arrMonthIng[$bulan - 1] . "-" . $tahun;
    $tanggalQuery2 = $hari . "-" . $arrMonthInd[$bulan - 1] . "-" . $tahun;
    $queryAll = $conn->query("SELECT * FROM kunjungan WHERE tgl_praktek LIKE '%$tanggalQuery1%' OR tgl_praktek LIKE '%$tanggalQuery2%'");

    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM kunjungan WHERE tgl_praktek LIKE '%$tanggalQuery1%' OR tgl_praktek LIKE '%$tanggalQuery2%' LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Filter Kunjungan by Tanggal Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Filter Kunjungan by Tanggal Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}
function getKunjunganId()
{
    global $conn;
    if (!empty($_GET["filter"])) {
        $id = $_GET["filter"];
    }
    $queryAll = $conn->query("SELECT * FROM kunjungan WHERE ID_pasien LIKE '%$id%'");
    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM kunjungan WHERE ID_pasien LIKE '%$id%' LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Filter Kunjungan by ID Pasien Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Filter Kunjungan by ID Pasien Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}
function delKunjungan()
{
    global $conn;
    if (!empty($_GET["tgl"])) {
        $tgl = $_GET["tgl"];
        $urut = $_GET["urut"];
    }
    $query = $conn->query("DELETE FROM kunjungan WHERE tgl_praktek = '$tgl' && NoUrut = '$urut'");
    if ($query) {
        $res = array(
            'message' => 'Delete Kunjugan Success'
        );
    } else {
        $res = array(
            'message' => 'Delete Kunjungan Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    updateTotalKunjungan(false);
    // header('Content-Type: application/json');
    // echo json_encode($res);
    header("location: ./daftarKunjungan.php?pag=1");
}
function addKunjungan()
{
    global $conn;
    $query = $conn->query("INSERT INTO kunjungan (NoUrut, tgl_praktek, ID_pasien, BPJS, Exo_Perm, Exo_Susu, LC, Fuji, RawatSyaraf, Scalling, Antibiotik, Analgetik, AntiRadang, Lain_Lain, tensi, berat, tinggi, suhu) VALUES ('{$_POST['NoUrut']}','{$_POST['tgl_praktek']}','{$_POST['ID_pasien']}','{$_POST['BPJS']}','{$_POST['Exo_Perm']}','{$_POST['Exo_Susu']}','{$_POST['LC']}','{$_POST['Fuji']}','{$_POST['RawatSyaraf']}','{$_POST['Scalling']}','{$_POST['Antibiotik']}','{$_POST['Analgetik']}','{$_POST['AntiRadang']}','{$_POST['Lain_Lain']}','{$_POST['tensi']}','{$_POST['berat']}','{$_POST['tinggi']}','{$_POST['suhu']}')");
    if ($query) {
        $res = array(
            'message' => 'Insert Kunjungan Success'
        );
    } else {
        $res = array(
            'message' => 'Insert Kunjungan Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }

    updateTotalKunjungan(true);
    // header('Content-Type: application/json');
    // echo json_encode($res);
    header("location: ./daftarKunjungan.php?pag=1");
}
function generateNoUrut($tanggal)
{
    global $conn;
    // if (!empty($_GET["tgl"])) {
    //     $tanggal = $_GET["tgl"];
    // }
    $query = $conn->query("SELECT * FROM kunjungan WHERE tgl_praktek LIKE '%$tanggal%'");
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row['NoUrut'];
    }

    $maxval = 0;
    foreach ($data as $isi) {
        $val = intval($isi);
        if ($val > $maxval) {
            $maxval = $val;
        }
    }

    if ($query) {
        $res = array(
            'message' => 'Filter Kunjungan by Tanggal Success',
            'no_urut' => ($maxval + 1)
        );
    } else {
        $res = array(
            'message' => 'Filter Kunjungan by Tanggal Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    return ($maxval + 1);
    // header('Content-Type: application/json');
    // echo json_encode($res);
}

//=============== PASIEN ===============//

function getAllPasien()
{
    global $conn;
    $queryAll = $conn->query("SELECT * FROM pasien");

    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM pasien LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Get All Pasien Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Get All Pasien Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}

function getPasien()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("SELECT * FROM pasien WHERE ID = '$id'");
    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }

    if ($query) {
        $res = array(
            'message' => 'Get Pasien Success',
            'data' => $data[0]
        );
    } else {
        $res = array(
            'message' => 'Get Pasien Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    // return $data[0];
    header('Content-Type: application/json');
    echo json_encode($res);
}

function getPasienNama()
{
    global $conn;
    if (!empty($_GET["filter"])) {
        $nama = $_GET["filter"];
    }
    $queryAll = $conn->query("SELECT * FROM pasien WHERE fullname LIKE '%$nama%'");

    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM pasien WHERE fullname LIKE '%$nama%' LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Filter Pasien by Name Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Filter Pasien by Name Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}
function getPasienAddress()
{
    global $conn;
    if (!empty($_GET["filter"])) {
        $address = $_GET["filter"];
    }
    // $query = $conn->query("SELECT * FROM pasien WHERE Address LIKE '%$address%'");
    $queryAll = $conn->query("SELECT * FROM pasien WHERE Address LIKE '%$address%'");

    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM pasien WHERE Address LIKE '%$address%' LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Filter Pasien by Address Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Filter Pasien by Address Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}

function getPasienId()
{
    global $conn;
    if (!empty($_GET["filter"])) {
        $id = $_GET["filter"];
    }
    $queryAll = $conn->query("SELECT * FROM pasien WHERE ID LIKE '%$id%'");
    $offset = ($_GET['pag'] - 1) * 25;
    $queryLimit = $conn->query("SELECT * FROM pasien WHERE ID LIKE '%$id%' LIMIT 25 OFFSET {$offset}");

    $dataAll = [];
    $dataLimit = [];
    while ($row = mysqli_fetch_object($queryAll)) {
        $dataAll[] = $row;
    }
    while ($row = mysqli_fetch_object($queryLimit)) {
        $dataLimit[] = $row;
    }

    if ($queryAll || $queryLimit) {
        $res = array(
            'message' => 'Filter Pasien by Id Success',
            'dataAll' => $dataAll,
            'dataLimit' => $dataLimit
        );
    } else {
        $res = array(
            'message' => 'Filter Pasien by Id Failed',
            'mysqli_error' => mysqli_error($conn),
            'dataAll' => [],
            'dataLimit' => []
        );
    }
    return $res;
    // header('Content-Type: application/json');
    // echo json_encode($res);
}
function generateId()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("SELECT * FROM pasien WHERE ID LIKE '$id%'");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row['ID'];
    }

    $maxval = 0;
    foreach ($data as $isi) {
        $str = substr($isi, 1);
        $val = intval($str);
        if ($val > $maxval) {
            $maxval = $val;
        }
    }

    if ($query) {
        $res = array(
            'message' => 'Generate Id Success',
            'id' => strtoupper($id . ($maxval + 1))
        );
    } else {
        $res = array(
            'message' => 'Generate Id Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}

function addPasien()
{
    global $conn;
    if (!isset($_FILES['photo']['tmp_name'])) {
        $photo_id = 'nopic';
    } else {
        $photo_id = $_POST['ID'];
    }
    $tglLahir = explode("-", $_POST['tgl_lahir'])[2] . "/" . explode("-", $_POST['tgl_lahir'])[1] . "/" . explode("-", $_POST['tgl_lahir'])[0];
    $query = $conn->query("INSERT INTO pasien (ID, fullname, tgl_lahir, BPJS, Address, sex, NoHp, status, Job, medicalrecord, photo, BloodType, NIK) VALUES ('{$_POST['ID']}','{$_POST['fullname']}','{$tglLahir}','{$_POST['BPJS']}','{$_POST['Address']}','{$_POST['sex']}','{$_POST['NoHp']}','{$_POST['status']}','{$_POST['Job']}','{$_POST['medicalrecord']}','{$photo_id}','{$_POST['BloodType']}','{$_POST['NIK']}')");
    if ($query) {
        $res = array(
            'message' => 'Insert Pasien Success'
        );
    } else {
        $res = array(
            'message' => 'Insert Pasien Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }

    if (isset($_FILES['photo']['tmp_name'])) {
        $gambarnya = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
        $query_photo = $conn->query("INSERT INTO foto (photo_id, image) VALUES ('{$photo_id}', '$gambarnya')");
        if ($query_photo) {
            $res = array(
                'message' => 'Insert Foto Success'
            );
        } else {
            $res = array(
                'message' => 'Insert Foto Failed',
                'mysqli_error' => mysqli_error($conn)
            );
        }
    }

    updateTotalPasien(true);

    header('Content-Type: application/json');
    echo json_encode($res);
    header("location: ./pasienList.php?pag=1");
}
function editPasien()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("UPDATE pasien SET fullname='" . $_POST['fullname'] . "',tgl_lahir='" . $_POST['tgl_lahir'] . "',BPJS='" . $_POST['BPJS'] . "',Address='" . $_POST['Address'] . "',sex='" . $_POST['sex'] . "',NoHp='" . $_POST['NoHp'] . "',status='" . $_POST['status'] . "',Job='" . $_POST['Job'] . "',medicalrecord='" . $_POST['medicalrecord'] . "',BloodType='" . $_POST['BloodType'] . "',NIK='" . $_POST['NIK'] . "' WHERE ID='" . $id . "'");
    if (isset($_GET['filter-select'])) {
        header("location: ./pasienList.php?filter-select=" . $_GET['filter-select'] . "&filter=" . $_GET['filter'] . "&pag=" . $_GET['pag']);
    } else {
        header("location: ./pasienList.php?pag=" . $_GET['pag']);
    }
}

function cekFoto()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("SELECT * FROM foto WHERE photo_id = '" . $_GET['id'] . "'");
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row['photo_id'];
    }

    if ($query) {
        $res = array(
            'message' => 'Get Pasien Success',
            'data' => $data
        );
    } else {
        $res = array(
            'message' => 'Get Pasien Failed',
            'mysqli_error' => mysqli_error($conn),
            'data' => []
        );
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}
function getFoto()
{
    global $conn;
    if (isset($_GET['id'])) {
        $query = mysqli_query($conn, "SELECT * FROM foto WHERE photo_id = '" . $_GET['id'] . "'");
        $row = mysqli_fetch_assoc($query);
        header("Content-type: image/jpeg");
        echo $row['image'];
    }
}
function delFoto()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("DELETE FROM foto WHERE photo_id = '$id'");
    if ($query) {
        $res = array(
            'message' => 'Delete Foto Success'
        );
    } else {
        $res = array(
            'message' => 'Delete Foto Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($res);
    // header("location: ./pasienList.php?pag=1");
}

function delPasien()
{
    global $conn;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = $conn->query("DELETE FROM pasien WHERE ID = '$id'");
    if ($query) {
        $res = array(
            'message' => 'Delete Pasien Success'
        );
    } else {
        $res = array(
            'message' => 'Delete Pasien Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    updateTotalPasien(false);
    // header('Content-Type: application/json');
    // echo json_encode($res);
    header("location: ./pasienList.php?pag=1");
}

//=============== Antrian ==========================//

function updateTotalPasien($tambah)
{
    global $conn;
    $query = $conn->query("SELECT * FROM status");
    $row = mysqli_fetch_assoc($query);
    if ($tambah) $totalSekarang = $row['totalPasien'] + 1;
    else $totalSekarang = $row['totalPasien'] - 1;
    $conn->query("UPDATE status SET totalPasien = $totalSekarang WHERE 1");
}
function updateTotalKunjungan($tambah)
{
    global $conn;
    $query = $conn->query("SELECT * FROM status");
    $row = mysqli_fetch_assoc($query);
    if ($tambah) $totalSekarang = $row['totalKunjungan'] + 1;
    else $totalSekarang = $row['totalKunjungan'] - 1;
    $conn->query("UPDATE status SET totalKunjungan = $totalSekarang WHERE 1");
}

function getStatus()
{
    global $conn;
    $query = $conn->query("SELECT * FROM status");
    $row = mysqli_fetch_object($query);
    return $row;
    // header('Content-Type: application/json');
    // echo json_encode($row);
}
function getAllAntrian()
{
    global $conn;
    $query = $conn->query("SELECT * FROM antrian");
    $data = [];
    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }

    if ($query) {
        $res = array(
            'message' => 'Get All Antrian Success',
            'data' => $data
        );
    } else {
        $res = array(
            'message' => 'Get All Antrian Failed',
            'mysqli_error' => mysqli_error($conn)
        );
    }
    return $data;
}
function addAntrian()
{
    global $conn;
    $d = strtotime("+7 Hours");
    $tanggal = date("H:i:s", $d);
    if ($_POST['nama']) {
        $conn->query("INSERT INTO antrian (waktu, id_pasien, nama_pasien, alamat_pasien, tensi, berat, tinggi, suhu, status) VALUES ('$tanggal', '{$_POST['id']}', '{$_POST['nama']}', '{$_POST['alamat']}', '{$_POST['tensi']}', '{$_POST['berat']}', '{$_POST['tinggi']}', '{$_POST['suhu']}', 'Mengantri')");
        if (isset($_GET['filter-select'])) {
            header("location: ./antrian.php?filter-select=" . $_GET['filter-select'] . "&filter=" . $_GET['filter'] . "&pag=" . $_GET['pag']);
        } else {
            header("location: ./antrian.php?pag=" . $_GET['pag']);
        }
    }
}
function updateAntrian()
{
    global $conn;
    $query = $conn->query("UPDATE antrian SET status = 'Selesai' WHERE waktu = '{$_GET['waktu']}'");
    header("location: ./antrian.php?pag=1");
}
function hapusAntrian()
{
    global $conn;
    $query = $conn->query("DELETE FROM antrian WHERE waktu = '{$_GET['waktu']}'");
    header("location: ./antrian.php?pag=1");
}
function updateOpen()
{
    global $conn;
    $query = $conn->query("UPDATE status SET isOpen = '{$_GET['status']}' WHERE 1");
}
function updateDokter()
{
    global $conn;
    $query = $conn->query("UPDATE status SET isDokter = '{$_GET['status']}' WHERE 1");
}
function hapusAllAntrian()
{
    global $conn;
    $query = $conn->query("DELETE FROM antrian");
    header("location: ./antrian.php?pag=1");
}
