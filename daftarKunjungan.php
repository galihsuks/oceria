<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
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

        header,
        main {
            padding-inline: 100px;
        }

        label {
            display: block;
        }

        input,
        select {
            display: block;
        }

        main {
            display: flex;
            gap: 20px;
        }

        main>.kiri {
            width: calc(100% - 350px);
        }

        main>.kanan {
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
            margin-bottom: 0.5em;
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

        header {
            background-color: whitesmoke;
            display: block;
            width: 100vw;
            margin-bottom: 10px;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
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
            height: calc(100vh - 250px);
        }

        .container-tabel thead tr {
            position: sticky;
            top: 0px;
        }

        table {
            border-collapse: collapse;
            text-align: center;
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
    </style>
    <title>Oceria | Daftar Kunjungan</title>
</head>

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li class="active">
                    <a href="./daftarKunjungan.php?pag=1">Daftar Kunjungan</a>
                </li>
                <li><a href="./inputKunjungan.php?pag=1">Input Data</a></li>
                <li class="logout"><a href="./actionlogout.php">Logout</a></li>
            </ul>
            <span style="text-align: right">
                <p><b>My Dentist</b></p>
                <p>online version</p>
            </span>
        </div>
    </header>
    <main>
        <div class="kiri">
            <section class="container-isian">
                <form method="get" style="display: flex; gap: 0.3em">
                    <p>Search part of</p>
                    <select name="filter-select">
                        <option value="tanggal">Tanggal</option>
                        <option value="ID" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'ID' ? 'selected' : '') : '' ?>>ID Pasien</option>
                    </select>:
                    <input type="text" name="filter" value="<?= isset($_GET['filter-select']) ? $_GET['filter'] : '' ?>" />
                    <input type="text" name="pag" value="1" style="display: none;">
                    <button style="font-size: small" type="submit">
                        Apply
                    </button>
                </form>
            </section>
            <a href="./daftarKunjungan.php?pag=1" class="tombol">Show All</a>
            <section style="margin-block: 0.3em">
                <div class="container-tabel">
                    <table>
                        <thead>
                            <tr style="
                                        background-color: var(--hijau);
                                        color: white;
                                    ">
                                <th>No. Urut</th>
                                <th style="min-width: 250px;">Tanggal Kunjungan</th>
                                <th>ID Pasien</th>
                                <th>BPJS</th>
                                <th>Exo_Perm</th>
                                <th>Exo_Susu</th>
                                <th>LC</th>
                                <th>Fuji</th>
                                <th>Rawat Syaraf</th>
                                <th>Scalling</th>
                                <th>Antibiotik</th>
                                <th>Analgetik</th>
                                <th>Anti Radang</th>
                                <th>Lain-Lain</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('api.php');
                            if (isset($_GET['filter-select'])) {
                                if ($_GET['filter-select'] == "tanggal") {
                                    $data_pasien_lengkap = getKunjunganTanggal();
                                    $data_pasien = $data_pasien_lengkap['dataLimit'];
                                } else if ($_GET['filter-select'] == "ID") {
                                    $data_pasien_lengkap = getKunjunganId();
                                    $data_pasien = $data_pasien_lengkap['dataLimit'];
                                }
                            } else {
                                $data_pasien = getAllKunjungan();
                            }
                            foreach ($data_pasien as $data) {
                                echo '<tr onclick="pilihData(`' . (str_contains($data->tgl_praktek, ",") ? explode(",", $data->tgl_praktek)[0] : $data->tgl_praktek) . '`,`' . $data->NoUrut . '`)">
                                        <td>' . $data->NoUrut . '</td>
                                        <td>' . $data->tgl_praktek . '</td>
                                        <td>' . $data->ID_pasien . '</td>
                                        <td>' . $data->BPJS . '</td>
                                        <td>' . $data->Exo_Perm . '</td>
                                        <td>' . $data->Exo_Susu . '</td>
                                        <td>' . $data->LC . '</td>
                                        <td>' . $data->Fuji . '</td>
                                        <td>' . $data->RawatSyaraf . '</td>
                                        <td>' . $data->Scalling . '</td>
                                        <td>' . $data->Antibiotik . '</td>
                                        <td>' . $data->Analgetik . '</td>
                                        <td>' . $data->AntiRadang . '</td>
                                        <td>' . $data->Lain_Lain . '</td>
                                        </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="paginasi" style="margin-inline: auto; width: fit-content; display: flex; gap: 5px;">
                <!-- <button onclick="prev()">Prev</button>
                <button onclick="next()">Next</button> -->
                <?php if (!isset($_GET['filter-select'])) { ?>
                    <?= $_GET['pag'] > 1 ? '<a class="tombol" href="./daftarKunjungan.php?pag=' . ($_GET['pag'] - 1) . '">Prev</a>' : '' ?>
                    <?php
                    $data_status = getStatus();
                    if ($_GET['pag'] * 25 < $data_status->totalKunjungan) {
                        echo '<a class="tombol" href="./daftarKunjungan.php?pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                    }
                    ?>
                <?php } else { ?>
                    <?php
                    $totalKunjungan = count($data_pasien_lengkap['dataAll']);
                    if ($_GET['pag'] > 1) {
                        echo '<a class="tombol" href="./daftarKunjungan.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] - 1) . '">Prev</a>';
                    }
                    if ($_GET['pag'] * 25 < $totalKunjungan) {
                        echo '<a class="tombol" href="./daftarKunjungan.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                    }
                    ?>
                <?php } ?>
            </div>
        </div>
        <div class="kanan">
            <section class="container-isian" style="margin-bottom: 1rem; margin-top: 70px">
                <span>
                    <p>NoUrut per Bln:</p>
                    <p>Tgl. Kunjungan:</p>
                    <p>Patient's ID:</p>
                    <p>Patient's Name:</p>
                    <p>Patient's Address:</p>
                    <p>BPJS:</p>
                    <p>Exo Permanen:</p>
                    <p>Exo Susu</p>
                    <p>Light Curing (LC):</p>
                    <p>Fuji:</p>
                    <p>Perawatan Saraf:</p>
                    <p>Scalling:</p>
                    <p>Antibiotik:</p>
                    <p>Analgetik:</p>
                    <p>Anti Radang:</p>
                    <p>Lain-Lain:</p>
                </span>
                <span>
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                    <input class="data-pasien" disabled type="text" />
                </span>
            </section>
            <section id="tombol-bawah">
                <button class="merah" disabled id="delete-button">
                    Delete
                </button>
            </section>
            <?php
            // $data_json = file_get_contents("https://oceria.amagabar.com/api.php?function=getStatus");
            // $data_status = json_decode($data_json);
            // echo '<h2>Total Records:' . $data_status->totalKunjungan . '</h2>'
            ?>
            <?= !isset($_GET['filter-select']) ? '<h2>Total Patients:' . $data_status->totalKunjungan . '</h2>' : '<h2>Total Patients:' . $totalKunjungan . '</h2>' ?>
        </div>
    </main>
    <script>
        const tmbElm = document.querySelector("#tombol-bawah");
        const dataElm = document.querySelectorAll(".data-pasien");

        function pilihData(tgl, urut) {
            async function getPasien() {
                const resKun = await fetch("./api.php?function=getKunjungan&tgl=" + tgl + "&urut=" + urut);
                // console.log(await resKun.json());
                const dataKun = (await resKun.json()).data;
                const resPasien = await fetch("./api.php?function=getPasien&id=" + dataKun.ID_pasien);
                const dataPasien = (await resPasien.json()).data;

                dataElm[0].value = dataKun.NoUrut;
                dataElm[1].value = dataKun.tgl_praktek;
                dataElm[2].value = dataKun.ID_pasien;
                dataElm[3].value = dataPasien.fullname;
                dataElm[4].value = dataPasien.Address;
                dataElm[5].value = dataKun.BPJS;
                dataElm[6].value = dataKun.Exo_Perm;
                dataElm[7].value = dataKun.Exo_Susu;
                dataElm[8].value = dataKun.LC;
                dataElm[9].value = dataKun.Fuji;
                dataElm[10].value = dataKun.RawatSyaraf;
                dataElm[11].value = dataKun.Scalling;
                dataElm[12].value = dataKun.Antibiotik;
                dataElm[13].value = dataKun.Analgetik;
                dataElm[14].value = dataKun.AntiRadang;
                dataElm[15].value = dataKun.Lain_Lain;

                tmbElm.innerHTML = `<button class="merah" onclick="deleteData('${tgl}','${urut}')">Delete</button>`;
            }
            getPasien();
        }

        function deleteData(tgl, urut) {
            let text = 'Data kunjungan pada tanggal ' + tgl + ' dengan nomor urut ' + urut + ' akan dihapus?';
            if (confirm(text) == true) {
                window.location.href = "./api.php?function=delKunjungan&tgl=" + tgl + "&urut=" + urut;
            }
        }
    </script>
</body>

</html>