<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    $_SESSION['url_before_login'] = './inputKunjungan.php?pag=1';
    header('Location: ./login.php');
    die();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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

        label {
            display: block;
        }

        input,
        select {
            display: block;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100svh;
        }

        main {
            width: 90%;
            margin-inline: auto;
            flex-grow: 1;
            max-height: calc(100% - 125px);
        }

        header {
            background-color: whitesmoke;
        }

        main .kiri {
            /* flex-grow: 1; */
            width: calc(100% - 330px);
            height: 100%;
        }

        main .kanan {
            width: 330px;
        }

        .tombol {
            padding: 0.5em;
            border: none;
            border-radius: 0.5em;
            font-weight: bold;
            font-size: medium;
            text-decoration: none;
            background-color: whitesmoke;
            color: var(--hitam);
            display: block;
            width: max-content;
        }

        .tombol:hover {
            background-color: var(--hijau);
            color: var(--putih);
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
            color: var(--putih);
        }

        button.hijau:hover {
            background-color: var(--hitam);
            color: var(--putih);
        }

        button.merah {
            background-color: var(--merah);
            color: var(--putih);
        }

        button.merah:hover {
            background-color: var(--hitam);
            color: var(--putih);
        }

        button:disabled {
            background-color: whitesmoke;
            color: gainsboro;
            cursor: default;
        }

        button:disabled:hover {
            background-color: whitesmoke;
            color: gainsboro;
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
            display: block;
            overflow: scroll;
            width: 100%;
            height: calc(100% - 70px);
        }

        .container-tabel thead tr {
            position: sticky;
            top: 0px;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 0.3rem 0.7rem;
        }

        tr {
            cursor: default;
        }

        tr:hover {
            color: var(--hijau);
        }

        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 1.5rem 2rem 2rem 2rem;
        }

        .card h2 {
            margin-bottom: 0.1em;
        }

        .card p {
            line-height: 25px;
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
            height: 21px;
            margin-block: 4px;
        }

        .container-filter {
            height: fit-content;
            padding-block: 0.5em;
        }
    </style>
    <title>Oceria | Daftar Kunjungan</title>
</head>

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li>
                    <a href="./daftarKunjungan.php?pag=1">Daftar Kunjungan</a>
                </li>
                <li class="active"><a href="./inputKunjungan.php?pag=1">Input Data</a></li>
                <li class="logout"><a href="./actionlogout.php">Logout</a></li>
            </ul>
            <span style="text-align: right">
                <p><b>My Dentist</b></p>
                <p>online version</p>
            </span>
        </div>
    </header>
    <div class="container-filter">
        <form method="get">
            <div style="display: flex; gap: 0.3em; width: 90%; margin-inline: auto; align-items:center;">
                <p>Search part of</p>
                <select name="filter-select">
                    <option value="fullname">Fullname</option>
                    <option value="ID" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'ID' ? 'selected' : '') : '' ?>>ID</option>
                    <option value="Address" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'Address' ? 'selected' : '') : '' ?>>Address</option>
                </select>:
                <input type="text" name="filter" value="<?= isset($_GET['filter-select']) ? $_GET['filter'] : '' ?>" />
                <input type="text" name="pag" value="1" style="display: none;">
                <button class="tombol" type="submit">
                    Apply
                </button>
                <?= isset($_GET['filter-select']) ? '<a href="./inputKunjungan.php?pag=1" class="tombol">Show All</a>' : '' ?>
            </div>
        </form>
    </div>
    <main>
        <div style="display: flex; gap: 20px; height: 100%;">
            <div class="kiri">
                <section style="margin-block: 0.3em">
                    <div class="container-tabel">
                        <table>
                            <thead>
                                <tr style="
                                        background-color: var(--hijau);
                                        color: white;
                                    ">
                                    <th>No.</th>
                                    <th>Waktu Antri</th>
                                    <th>ID Pasien</th>
                                    <th>Nama Pasien</th>
                                    <th>Tensi</th>
                                    <th>Berat</th>
                                    <th>Tinggi</th>
                                    <th>Suhu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('api.php');
                                $data_antrian = getAllAntrian();
                                $no = 1;
                                foreach ($data_antrian as $data) {
                                    echo '<tr onclick="pilihData(`' . $data->id_pasien . '`,`' . $data->tensi . '`,`' . $data->berat . '`,`' . $data->tinggi . '`,`' . $data->suhu . '`,`' . $data->waktu . '`)">
                                        <td>' . $no . '</td>
                                        <td>' . $data->waktu . '</td>
                                        <td>' . $data->id_pasien . '</td>
                                        <td>' . $data->nama_pasien . '</td>
                                        <td>' . $data->tensi . '</td>
                                        <td>' . $data->berat . '</td>
                                        <td>' . $data->tinggi . '</td>
                                        <td>' . $data->suhu . '</td>
                                        </tr>';
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="kanan">
                <form method="post" action="./api.php?function=addKunjungan" id="form-add-kunjungan">
                    <section class="container-isian">
                        <span>
                            <p>Tgl. Kunjungan:</p>
                            <p>No.Urut per bulan:</p>
                        </span>
                        <span>
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
                            $tanggal = date("d", $d) . "-" . $arrMonth[(int)date("m", $d) - 1] . "-" . date("Y", $d);
                            $noUrut = generateNoUrut($arrMonth[(int)date("m", $d) - 1] . "-" . date("Y", $d));
                            ?>
                            <input type="text" required name="tgl_praktek" value="<?= $tanggal; ?>" />
                            <input type="number" required name="NoUrut" value="<?= $noUrut; ?>" />
                        </span>
                    </section>
                    <div style="width: 70%; height: 1.5px; background-color: gainsboro; margin-block: 0.5em;"></div>
                    <h3>Pasien</h3>
                    <p style="color: grey; font-size: small;">Pilih pasien disamping untuk pengisian otomatis</p>
                    <section class="container-isian">
                        <span>
                            <p>Patient's ID:</p>
                            <p>Patient's Name:</p>
                            <p>Address:</p>
                        </span>
                        <span>
                            <input class="data-pasien" type="text" required name="ID_pasien" />
                            <input class="data-pasien" disabled type="text" required />
                            <input class="data-pasien" disabled type="text" required />
                        </span>
                    </section>
                    <div style="width: 70%; height: 1.5px; background-color: gainsboro; margin-block: 0.5em;"></div>
                    <h3>Pemeriksaan</h3>
                    <section class="container-isian">
                        <span>
                            <p>Tensi:</p>
                            <p>Berat Badan:</p>
                            <p>Tinggi Badan:</p>
                            <p>Suhu Badan:</p>
                        </span>
                        <span>
                            <input class="data-pasien" type="text" required name="tensi" />
                            <input class="data-pasien" type="number" required name="berat" />
                            <input class="data-pasien" type="number" required name="tinggi" />
                            <input class="data-pasien" type="number" required name="suhu" />
                        </span>
                    </section>
                    <div style="width: 70%; height: 1.5px; background-color: gainsboro; margin-block: 0.5em;"></div>
                    <h3>Tindakan & Obat</h3>
                    <section class="container-isian" style="margin-bottom: 0.5em;">
                        <span>
                            <p>BPJS:</p>
                            <p>Exo Permanen:</p>
                            <p>Exo Susu</p>
                            <p>Light Curing (LC):</p>
                            <p>Fuji:</p>
                            <p>Rawat Saraf:</p>
                            <p>Scalling:</p>
                            <p>Antibiotik:</p>
                            <p>Analgetik:</p>
                            <p>Anti Radang:</p>
                            <p>Lain-Lain:</p>
                        </span>
                        <span>
                            <select name="BPJS">
                                <option value="True" selected>Ya</option>
                                <option value="False">Tidak</option>
                            </select>
                            <!-- <input type="text" required name="BPJS" /> -->
                            <input type="number" required value="0" name="Exo_Perm" />
                            <input type="number" required value="0" name="Exo_Susu" />
                            <input type="number" required value="0" name="LC" />
                            <input type="number" required value="0" name="Fuji" />
                            <input type="number" required value="0" name="RawatSyaraf" />
                            <input type="number" required value="0" name="Scalling" />
                            <input type="number" required value="0" name="Antibiotik" />
                            <input type="number" required value="0" name="Analgetik" />
                            <input type="number" required value="0" name="AntiRadang" />
                            <!-- <input type="text" name="Lain_Lain" /> -->
                            <textarea name="Lain_Lain" style="width: 100%;"></textarea>
                        </span>
                    </section>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        const dataElm = document.querySelectorAll(".data-pasien");
        const formAddKunjunganFom = document.getElementById("form-add-kunjungan");

        function pilihData(id, tensi, berat, tinggi, suhu, waktu) {
            async function getPasien() {
                const res = await fetch("./api.php?function=getPasien&id=" + id);
                const data = (await res.json()).data;
                dataElm[0].value = data.ID;
                dataElm[1].value = data.fullname;
                dataElm[2].value = data.Address;
                dataElm[3].value = tensi;
                dataElm[4].value = berat;
                dataElm[5].value = tinggi;
                dataElm[6].value = suhu;
            }
            getPasien();

            formAddKunjunganFom.action = "./api.php?function=addKunjungan&waktu=" + waktu
        }
    </script>
</body>

</html>