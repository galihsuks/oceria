<?php
include('api.php');
include('bpjs.php');
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    $_SESSION['url_before_login'] = './antrian.php?pag=1';
    header('Location: ./login.php');
    die();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;700;900&display=swap");

        * {
            --putih: white;
            --hitam: black;
            --hijau: #0cca98;
            --merah: #e2125d;
            font-family: "Outfit", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100svh;
        }

        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100px;
            padding-inline: 2em;
        }

        main {
            width: 90%;
            margin-inline: auto;
            padding-inline: 2em;
            flex-grow: 1;
        }

        footer {
            background-color: var(--hijau);
            color: white;
            text-align: center;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        input[name="pasien"] {
            padding: 0.5em;
            width: calc(100% - 58px);
        }

        button {
            padding: 0.5em;
            border: none;
            border-radius: 0.5em;
            font-weight: bold;
            font-size: medium;
        }

        button:hover {
            background-color: var(--hijau);
            color: var(--putih);
        }

        button.hijau {
            background-color: var(--hijau);
            color: white;
        }

        button:hover.hijau {
            background-color: whitesmoke;
            color: black;
        }

        .tombol {
            padding: 0.3em;
            border: none;
            border-radius: 0.5em;
            font-weight: bold;
            font-size: small;
            text-decoration: none;
            color: var(--hitam);
            border: 1px solid gainsboro;
        }

        .tombol:hover {
            background-color: var(--hijau);
            border: 1px solid var(--hijau);
            color: var(--putih);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            width: 90%;
            margin-inline: auto;
        }

        .nav h1 a {
            font-size: 25px;
            font-weight: 900;
            text-decoration: none;
            color: var(--hijau);
        }

        .nav ul {
            display: block;
            height: fit-content;
        }

        .nav li {
            text-decoration: none;
            list-style-type: none;
            display: inline-block;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
        }

        .nav li.active a {
            font-weight: 700;
        }

        .nav li a {
            padding-inline: 10px;
            text-decoration: none;
            display: block;
            line-height: 50px;
            color: var(--hitam);
        }

        .nav li:hover {
            background-color: var(--hijau);
            transition: 0.1s;
        }

        .container-tabel {
            overflow-y: auto;
            height: calc(100% - 130px);
        }

        .container-tabel thead tr {
            position: sticky;
            top: 0px;
        }

        .container-tabel .header-tabel {
            display: flex;
            width: 100%;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .container-tabel .isi-tabel {
            display: flex;
            width: 100%;
            align-items: center;
            margin-bottom: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-weight: 500;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 0.3rem 0.7rem;
        }

        tr td:nth-child(1),
        tr td:nth-child(3) {
            text-align: center;
        }

        .teks-hijau {
            transition: 0.2s;
            color: var(--hijau);
        }

        .content {
            display: flex;
            gap: 1em;
        }

        .content>div {
            flex: 1;
            height: calc(100vh - 291px);
        }

        select {
            font-size: medium;
        }

        .hide {
            display: none;
        }

        .container-form {
            display: none;
            position: fixed;
            height: 100svh;
            width: 100vw;
            justify-content: center;
            align-items: center;
            top: 0;
            left: 0;
        }

        .container-form.show {
            display: flex;
        }

        .container-isian {
            display: flex;
            gap: 1rem;
        }

        .container-isian p {
            line-height: 25px;
        }

        .container-isian input,
        .container-isian select {
            display: block;
            height: 21px;
            margin-block: 4px;
        }
    </style>
    <title>Oceria | Antrian Pasien</title>
</head>
<?php
$arrMonth = [
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
$d = strtotime("+7 Hours");
$tanggal = date("l", $d) . ", " . date("d", $d) . " " . $arrMonth[(int)date("m", $d) - 1] . " " . date("Y", $d);
?>

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li class="active"><a href="./listantrian.php">Lihat Antrian</a></li>
                <li><a href="./addantrian.php">Tambah Antrian</a></li>
                <li class="logout"><a href="./actionlogout.php">Logout</a></li>
            </ul>
            <span style="text-align: right">
                <p class="m-0 fw-bold">My Dentist</p>
                <p class="m-0">online version</p>
            </span>
        </div>
    </header>
    <main>
        <h2>Riwayat Pendaftaran Peserta</h2>
        <hr>
        <div>
            <div class="mb-1 d-flex gap-2 align-items-center" style="width: fit-content;">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tglDaftar" value="<?= date("Y-m-d", $d); ?>">
            </div>
        </div>
        <div class="container-tabel">
            <div class="header-tabel">
                <div style="flex: 1;">NO</div>
                <div style="flex: 2;">NO.KARTU</div>
                <div style="flex: 2;">NIK</div>
                <div style="flex: 2;">NAMA PESERTA</div>
                <div style="flex: 2;">BPJS/UMUM</div>
                <div style="flex: 2;">STATUS</div>
                <div style="flex: 1;">HAPUS</div>
            </div>
            <hr>
            <div class="isi-tabel">
                <div style="flex: 1;">B1-1</div>
                <div style="flex: 2;">0000234123</div>
                <div style="flex: 2;">3310243532530002</div>
                <div style="flex: 2;">Sugalih Sugilang</div>
                <div style="flex: 2;">BPJS</div>
                <div style="flex: 2;">Antri</div>
                <div style="flex: 1;"><button class="bg-danger"><i class="material-icons text-light">delete_forever</i></button></div>
            </div>
            <?php
            $pendaftaranTgl = pendaftaranGetTgl(date("d-m-Y", $d));
            if ($pendaftaranTgl['list'] != null) {
                foreach ($pendaftaranTgl['list'] as $p) {
                    $peserta = pesertaGet('nik',)
            ?>
                    <div class="isi-tabel">
                        <div style="flex: 1;"><?= $p['noUrut']; ?></div>
                        <div style="flex: 2;"><?= $p['peserta']['noKartu']; ?></div>
                        <div style="flex: 2;"><?= $p['noUrut']; ?></div>
                        <div style="flex: 2;"><?= $p['peserta']['nama']; ?></div>
                        <div style="flex: 2;"><?= $p['noUrut']; ?></div>
                        <div style="flex: 2;"><?= $p['noUrut']; ?></div>
                        <div style="flex: 1;"><button class="bg-danger"><i class="material-icons text-light">delete_forever</i></button></div>
                    </div>
                <?php }
            } else { ?>
                <div class="isi-tabel">
                    <div style="flex: 1;">Tidak ada data</div>
                </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p style="font-weight: bold"><?= $tanggal; ?></p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>