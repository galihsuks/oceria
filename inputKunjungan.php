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
            width: fit-content;
        }

        main>.kanan {
            flex: 1;
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
    <main>
        <div class="kiri">
            <section class="container-isian">
                <form method="get" style="display: flex; gap: 0.3em">
                    <p>Search part of</p>
                    <select name="filter-select">
                        <option value="fullname">Fullname</option>
                        <option value="ID" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'ID' ? 'selected' : '') : '' ?>>ID</option>
                        <option value="Address" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'Address' ? 'selected' : '') : '' ?>>Address</option>
                    </select>:
                    <input type="text" name="filter" value="<?= isset($_GET['filter-select']) ? $_GET['filter'] : '' ?>" />
                    <input type="text" name="pag" value="1" style="display: none;">
                    <button style="font-size: small" type="submit">
                        Apply
                    </button>
                </form>
            </section>
            <section style="margin-block: 0.3em">
                <div class="container-tabel">
                    <table>
                        <thead>
                            <tr style="
                                        background-color: var(--hijau);
                                        color: white;
                                    ">
                                <th>No.</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('api.php');
                            if (isset($_GET['filter-select'])) {
                                if ($_GET['filter-select'] == "fullname") {
                                    $data_pasien_lengkap = getPasienNama();
                                    $data_pasien = $data_pasien_lengkap['dataLimit'];
                                } else if ($_GET['filter-select'] == "ID") {
                                    $data_pasien_lengkap = getPasienId();
                                    $data_pasien = $data_pasien_lengkap['dataLimit'];
                                } else if ($_GET['filter-select'] == "Address") {
                                    $data_pasien_lengkap = getPasienAddress();
                                    $data_pasien = $data_pasien_lengkap['dataLimit'];
                                }
                            } else {
                                $data_pasien = getAllPasien();
                            }
                            $no = ($_GET['pag'] - 1) * 25 + 1;
                            foreach ($data_pasien as $data) {
                                echo '<tr onclick="pilihData(`' . $data->ID . '`)">
                                        <td>' . $no . '</td>
                                        <td>' . $data->ID . '</td>
                                        <td>' . $data->fullname . '</td>
                                        <td>' . $data->Address . '</td>
                                        </tr>';
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="paginasi" style="margin-inline: auto; width: fit-content; display: flex; gap: 5px;">
                <?php if (!isset($_GET['filter-select'])) { ?>
                    <?= $_GET['pag'] > 1 ? '<a class="tombol" href="./inputKunjungan.php?pag=' . ($_GET['pag'] - 1) . '">Prev</a>' : '' ?>
                    <?php
                    $data_status = getStatus();
                    if ($_GET['pag'] * 25 < $data_status->totalPasien) {
                        echo '<a class="tombol" href="./inputKunjungan.php?pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                    }
                    ?>
                <?php } else { ?>
                    <?php
                    $totalPasien = count($data_pasien_lengkap['dataAll']);
                    if ($_GET['pag'] > 1) {
                        echo '<a class="tombol" href="./inputKunjungan.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] - 1) . '">Prev</a>';
                    }
                    if ($_GET['pag'] * 25 < $totalPasien) {
                        echo '<a class="tombol" href="./inputKunjungan.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                    }
                    ?>
                <?php } ?>
            </div>
        </div>
        <div class="kanan">
            <form method="post" action="./api.php?function=addKunjungan">
                <section class="container-isian" style="margin-top: 40px">
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
                        $noUrut = generateNoUrut($tanggal);
                        ?>
                        <input type="text" required name="tgl_praktek" value="<?= $tanggal; ?>" />
                        <input type="number" required name="NoUrut" value="<?= $noUrut; ?>" />
                    </span>
                </section>
                <div style="width: 70%; height: 2px; background-color: gainsboro; margin-block: 1em;"></div>
                <h2>Pasien</h2>
                <p style="color: grey;">Pilih pasien pada tabel disamping untuk mengisi data pasien secara otomatis</p>
                <section class="container-isian">
                    <span>
                        <p>Patient's ID:</p>
                        <p>Patient's Name:</p>
                        <p>Patient's Address:</p>
                    </span>
                    <span>
                        <input class="data-pasien" type="text" required name="ID_pasien" />
                        <input class="data-pasien" disabled type="text" required />
                        <input class="data-pasien" disabled type="text" required />
                    </span>
                </section>
                <div style="width: 70%; height: 2px; background-color: gainsboro; margin-block: 1em;"></div>
                <h2>Tindakan & Obat</h2>
                <section class="container-isian" style="margin-bottom: 1rem;">
                    <span>
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
                        <input type="text" name="Lain_Lain" />
                    </span>
                </section>
                <button type="submit">Save</button>
            </form>
        </div>
    </main>
    <script>
        const dataElm = document.querySelectorAll(".data-pasien");

        function pilihData(id) {
            async function getPasien() {
                const res = await fetch("./api.php?function=getPasien&id=" + id);
                const data = (await res.json()).data;
                dataElm[0].value = data.ID;
                dataElm[1].value = data.fullname;
                dataElm[2].value = data.Address;
            }
            getPasien();
        }
    </script>
</body>

</html>