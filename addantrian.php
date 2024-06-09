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

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li><a href="./listantrian.php">Lihat Antrian</a></li>
                <li class="active"><a href="./addantrian.php">Tambah Antrian</a></li>
                <li class="logout"><a href="./actionlogout.php">Logout</a></li>
            </ul>
            <span style="text-align: right">
                <p class="m-0 fw-bold">My Dentist</p>
                <p class="m-0">online version</p>
            </span>
        </div>
    </header>
    <main>
        <h2>Pendaftaran Antrian BPJS</h2>
        <hr>
        <form action="./bpjs.php?fitur=pendaftaranAdd" method="post">
            <div class="d-flex gap-4">
                <div class="w-50">
                    <div class="mb-1">
                        <label class="form-label">Pasien BPJS atau Umum</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input value="true" class="form-check-input" type="radio" name="bpjs" id="flexRadioDefault01" checked>
                                <label class="form-check-label" for="flexRadioDefault01">
                                    BPJS
                                </label>
                            </div>
                            <div class="form-check">
                                <input value="false" class="form-check-input" type="radio" name="bpjs" id="flexRadioDefault02">
                                <label class="form-check-label" for="flexRadioDefault02">
                                    Umum
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-1">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tglDaftar" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Pendaftaran</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input value="baru" class="form-check-input" type="radio" name="jenis_pendaftaran" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Baru
                                </label>
                            </div>
                            <div class="form-check">
                                <input value="rujukan" class="form-check-input" type="radio" name="jenis_pendaftaran" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Rujukan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">No. Pencarian</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" id="input-cari">
                            <button type="button" class="btn btn-outline-secondary" id="btn-cari">Cari No.BPJS</button>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" onclick="pilihJenisCari('noka')">Nomor BPJS</a></li>
                                <li><a class="dropdown-item" onclick="pilihJenisCari('nik')">NIK</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">No. BPJS</label>
                        <input type="text" class="form-control" name="noKartu" required>
                        <input type="text" class="d-none" name="kdProviderPeserta" required>
                    </div>
                    <div class="d-flex mt-3 gap-3">
                        <div>
                            <p class="fw-bold m-0">Nama</p>
                            <p class="fw-bold m-0">Status peserta</p>
                            <p class="fw-bold m-0">Tanggal lahir</p>
                            <p class="fw-bold m-0">Kelamin</p>
                            <p class="fw-bold m-0">PPK Umum</p>
                            <p class="fw-bold m-0">PPK Gigi</p>
                            <p class="fw-bold m-0">No. Handphone</p>
                            <p class="fw-bold m-0">No. Rekam Medis</p>
                        </div>
                        <div id="container-detail-peserta"></div>
                    </div>
                </div>
                <div class="w-50">
                    <div class="mb-1">
                        <label class="form-label">Jenis Kunjungan</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input onchange="changeKunjSakit(true)" value="true" class="form-check-input" type="radio" name="kunjSakit" id="flexRadioDefault3" checked>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Kunjungan Sakit
                                </label>
                            </div>
                            <div class="form-check">
                                <input onchange="changeKunjSakit(false)" value="false" class="form-check-input" type="radio" name="kunjSakit" id="flexRadioDefault4">
                                <label class="form-check-label" for="flexRadioDefault4">
                                    Kunjungan Sehat
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Perawatan</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input value="10" class="form-check-input" type="radio" name="perawatan" id="flexRadioDefault5" checked>
                                <label class="form-check-label" for="flexRadioDefault5">
                                    Rawat Jalan
                                </label>
                            </div>
                            <div class="form-check">
                                <input value="20" class="form-check-input" type="radio" name="perawatan" id="flexRadioDefault6">
                                <label class="form-check-label" for="flexRadioDefault6">
                                    Rawat Inap
                                </label>
                            </div>
                            <div class="form-check">
                                <input value="50" class="form-check-input" type="radio" name="perawatan" id="flexRadioDefault7">
                                <label class="form-check-label" for="flexRadioDefault7">
                                    Promotif Preventif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Poli Tujuan</label>
                        <select class="form-select" aria-label="Default select example" name="kdPoli">
                            <?php
                            $poli = poliGet();
                            $kunjSakit = $_GET['kunjSakit'] ? $_GET['kunjSakit'] : true;
                            foreach ($poli['list'] as $ind_p => $p) {
                                if ($p['poliSakit'] ==  $kunjSakit) {
                            ?>
                                    <option value="<?= $p['kdPoli']; ?>" <?= $ind_p == 0 ? 'selected' : ''; ?>><?= $p['nmPoli']; ?></option>
                            <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Keluhan</label>
                        <textarea type="text" class="form-control" name="keluhan" required></textarea>
                    </div>
                    <hr>
                    <h4>Pemeriksaan Fisik</h4>
                    <div class="d-flex gap-3 w-100">
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label">Tinggi Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="tinggiBadan">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Berat Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="beratBadan">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label">Lingkar Perut</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="lingkarPerut">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">IMT</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" disabled>
                                    <span class="input-group-text">kg/m2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>Tekanan Darah</h4>
                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label">Sistole</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="sistole">
                                    <span class="input-group-text">mmHg</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Diastole</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="diastole">
                                    <span class="input-group-text">mmHg</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label">Respiratory Rate</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="respRate">
                                    <span class="input-group-text">/ minute</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Heart Rate</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="heartRate">
                                    <span class="input-group-text">bpm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="hijau">Simpan</button>
                </div>
            </div>
        </form>
    </main>
    <footer>
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
        <p style="font-weight: bold"><?= $tanggal; ?></p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const formElm = document.querySelector('form');
        const kdPoliElm = document.querySelector('select[name="kdPoli"]');
        const inputCariElm = document.getElementById("input-cari")
        const btnCariElm = document.getElementById("btn-cari")
        const containerDetailPesertaElm = document.getElementById("container-detail-peserta");
        const inputNoBPJSElm = document.querySelector('input[name="noKartu"]');
        const inputkdProviderPesertaElm = document.querySelector('input[name="kdProviderPeserta"]');

        let poliArr = [];
        async function fetchPoli() {
            const res = await fetch('./bpjs.php?fitur=poliGet');
            const resJson = await res.json();
            console.log(resJson);
            poliArr = resJson.list;
        }
        fetchPoli()

        function changeKunjSakit(value) {
            console.log(value)
            kdPoliElm.innerHTML = '';
            poliArr.forEach((poli, ind) => {
                if (poli.poliSakit == value) {
                    if (ind == 0)
                        kdPoliElm.innerHTML += '<option value="' + poli.kdPoli + '" selected>' + poli.nmPoli + '</option>'
                    else
                        kdPoliElm.innerHTML += '<option value="' + poli.kdPoli + '">' + poli.nmPoli + '</option>'
                }
            })
        }

        let cariPesertaBerdasarkan = 'noka';

        function pilihJenisCari(value) {
            console.log(value)
            switch (value) {
                case 'noka':
                    cariPesertaBerdasarkan = 'noka'
                    btnCariElm.innerHTML = 'Cari No.BPJS'
                    break;
                case 'nik':
                    cariPesertaBerdasarkan = 'nik'
                    btnCariElm.innerHTML = 'Cari NIK'
                    break;
            }
        }
        btnCariElm.addEventListener('click', () => {
            async function fetchPeserta() {
                const res = await fetch('./bpjs.php?fitur=pesertaGet&param1=' + cariPesertaBerdasarkan + '&param2=' + inputCariElm.value);
                const resJson = await res.json()
                console.log(resJson)
                let kelamin = 'Laki-laki'
                let nohp = 'Tidak ada'
                if (resJson.sex == 'P') kelamin = 'Perempuan'
                if (resJson.noHP != '') nohp = resJson.noHP
                inputNoBPJSElm.value = resJson.noKartu
                inputkdProviderPesertaElm.value = resJson.kdProviderPst.kdProvider
                containerDetailPesertaElm.innerHTML = ''
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + resJson.nama + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + resJson.hubunganKeluarga + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + resJson.tglLahir + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + kelamin + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + resJson.kdProviderPst.kdProvider + ' - ' + resJson.kdProviderPst.nmProvider + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + resJson.kdProviderGigi.kdProvider + ' - ' + resJson.kdProviderGigi.nmProvider + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0">' + nohp + '</p>'
                containerDetailPesertaElm.innerHTML += '<p class="fw-bold m-0 text-danger">Ini belum tau dimana</p>'
            }
            fetchPeserta();
        })
    </script>
</body>

</html>