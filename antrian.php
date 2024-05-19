<?php
include('api.php');
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
        <div style="
                    display: flex;
                    justify-content: space-between;
                    width: 100%;
                ">
            <h1>
                <a href="./" style="text-decoration: none; color: var(--hijau)">Oceria</a>
            </h1>
            <span style="text-align: right">
                <p><b>My Dentist</b></p>
                <p>online version</p>
            </span>
        </div>
        <span style="
                    width: 100%;
                    height: 1px;
                    background-color: var(--hitam);
                    margin-top: 1em;
                "></span>
    </header>
    <main>
        <section style="margin-bottom: 1.5em">
            <p>Dokter</p>
            <h3 style="margin-bottom: 0.5em">Drg. Sri Umiati</h3>
            <div style="display: flex; gap: 2em">
                <div>
                    <p>Status dokter</p>
                    <select name="isDokter">
                        <option value="0" <?= getStatus()->isDokter ? '' : 'selected'; ?>>Belum Hadir</option>
                        <option value="1" <?= getStatus()->isDokter ? 'selected' : ''; ?>>Sudah Hadir</option>
                    </select>
                </div>
                <div>
                    <p>Status Antrian</p>
                    <select name="isOpen">
                        <option value="0" <?= getStatus()->isOpen ? '' : 'selected'; ?>>Antrian tidak dibuka</option>
                        <option value="1" <?= getStatus()->isOpen ? 'selected' : ''; ?>>Antrian dibuka</option>
                    </select>
                </div>
                <a href="./api.php?function=hapusAllAntrian">
                    <button>Hapus Semua Antrian</button>
                </a>
            </div>
        </section>
        <section class="content">
            <div style="border-top: 1px solid gainsboro; padding: 1em">
                <div style="display: flex; justify-content: space-between;">
                    <h3>Daftar Antrian</h3>
                    <a href="./newPasien.php"><button>Pasien Baru</button></a>
                </div>
                <form method="get" style="display: flex; gap: 0.3em">
                    <p>Search part of</p>
                    <select name="filter-select">
                        <option value="fullname">Name</option>
                        <option value="ID" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'ID' ? 'selected' : '') : '' ?>>ID</option>
                        <option value="Address" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'Address' ? 'selected' : '') : '' ?>>Address</option>
                    </select>:
                    <input type="text" name="filter" value="<?= isset($_GET['filter-select']) ? $_GET['filter'] : '' ?>" />
                    <input type="text" name="pag" value="1" style="display: none;">
                    <button style="font-size: small" type="submit">
                        Apply
                    </button>
                </form>
                <div class="container-tabel" style="margin-block: 1em">
                    <table>
                        <thead>
                            <tr style="
                                        background-color: var(--hijau);
                                        color: white;
                                    ">
                                <th>No</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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
                                $data_pasien_lengkap = getAllPasien();
                                $data_pasien = $data_pasien_lengkap['dataLimit'];
                            }
                            $totalPasien = count($data_pasien_lengkap['dataAll']);
                            $no = ($_GET['pag'] - 1) * 25 + 1;
                            foreach ($data_pasien as $data) { ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $data->ID ?></td>
                                    <td><?= $data->fullname ?></td>
                                    <td><?= $data->Address ?></td>
                                    <td><button class="tombol" onclick="showForm('<?= $data->ID ?>', '<?= $data->fullname ?>', '<?= $data->Address ?>')">Antri</button></td>
                                </tr>
                            <?php
                                $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginasi" style="margin-inline: auto; width: fit-content; display: flex; gap: 5px; margin-top: 5px">
                    <?php if (!isset($_GET['filter-select'])) { ?>
                        <?= $_GET['pag'] > 1 ? '<a class="tombol" href="./antrian.php?pag=' . ($_GET['pag'] - 1) . '">Prev</a>' : '' ?>
                        <?php
                        $data_status = getStatus();
                        if ($_GET['pag'] * 25 < $data_status->totalPasien) {
                            echo '<a class="tombol" href="./antrian.php?pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                        }
                        ?>
                    <?php } else { ?>
                        <?php
                        if ($_GET['pag'] > 1) {
                            echo '<a class="tombol" href="./antrian.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] - 1) . '">Prev</a>';
                        }
                        if ($_GET['pag'] * 25 < $totalPasien) {
                            echo '<a class="tombol" href="./antrian.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                        }
                        ?>
                    <?php } ?>
                </div>
            </div>
            <div class="container-tabel">
                <table>
                    <thead>
                        <tr style="
                                    background-color: var(--hijau);
                                    color: white;
                                ">
                            <th>Masuk Antrian</th>
                            <th>Pasien</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getAllAntrian = getAllAntrian();
                        foreach ($getAllAntrian as $data) {
                            if ($data->status == 'Mengantri') {
                                $button = '<a href="./api.php?function=updateAntrian&waktu=' . $data->waktu . '" class="tombol">Selesai</a>
                                                  <a href="./api.php?function=hapusAntrian&waktu=' . $data->waktu . '" class="tombol">Hapus</a>';
                                $tr = '<tr>';
                            } else {
                                $button = '<a class="tombol" href="./inputKunjungan.php?pag=1&id=' . $data->id_pasien . '&nama=' . $data->nama_pasien . '&alamat=' . $data->alamat_pasien . '&tensi=' . $data->tensi . '&berat=' . $data->berat . '&tinggi=' . $data->tinggi . '&suhu=' . $data->suhu . '">Tambahkan Kunjungan</a>
                                                <a href="./api.php?function=hapusAntrian&waktu=' . $data->waktu . '" class="tombol">Hapus</a>';
                                $tr = '<tr class="teks-hijau">';
                            }
                            echo $tr . '<td>' . $data->waktu . '</td>
                                    <td>' . $data->nama_pasien . '</td>
                                    <td>' . $button . '</td>
                                    </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="container-form" id="container-add-antrian">
            <div style="width: fit-content; background-color: white; box-shadow: 0 0 10px rgba(0,0,0,0.5); padding: 1em; border-radius: 1em">
                <form action="./api.php?function=addAntrian&pag=<?= $_GET['pag'] . (isset($_GET['filter-select']) ? '&filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] : '') ?>" method="post">
                    <h3>Identitas Pasien</h3>
                    <section class="container-isian" style="margin-bottom: 0.5em;">
                        <span>
                            <p>ID Pasien:</p>
                            <p>Nama:</p>
                            <p>Alamat:</p>
                        </span>
                        <span>
                            <input type="text" required name="id" />
                            <input type="text" required name="nama" />
                            <input type="text" required name="alamat" />
                        </span>
                    </section>
                    <h3>Pemeriksaan</h3>
                    <section class="container-isian" style="margin-bottom: 0.5em;">
                        <span>
                            <p>Tensi:</p>
                            <p>Berat Badan:</p>
                            <p>Tinggi Badan:</p>
                            <p>Suhu Badan:</p>
                        </span>
                        <span>
                            <input type="text" required name="tensi" />
                            <input type="number" required name="berat" />
                            <input type="number" required name="tinggi" />
                            <input type="number" required name="suhu" />
                        </span>
                    </section>
                    <div style="width: 100%; display: flex; justify-content:center; margin-top: 1em; gap: 0.3em">
                        <button class="hijau" type="submit">Tambah</button>
                        <button type="button" onclick="closeForm()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
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
    <script>
        const isOpenElm = document.querySelector('select[name="isOpen"]');
        const isDokterElm = document.querySelector('select[name="isDokter"]');
        const containerAddAntrianElm = document.getElementById("container-add-antrian");
        const containerAddKunjunganElm = document.getElementById("container-add-kunjungan");

        isOpenElm.addEventListener("change", (e) => {
            fetch("./api.php?function=updateOpen&status=" + e.target.value);
            if (e.target.value == '1') isOpenElm.classList.add("select-hijau");
            else isOpenElm.classList.remove("select-hijau");
        });
        isDokterElm.addEventListener("change", (e) => {
            fetch("./api.php?function=updateDokter&status=" + e.target.value);
            if (e.target.value == '1') isDokterElm.classList.add("select-hijau");
            else isDokterElm.classList.remove("select-hijau");
        });

        function showForm(idPasien, namaPasien, alamatPasien) {
            containerAddAntrianElm.classList.add("show");
            document.querySelector('input[name="id"]').value = idPasien
            document.querySelector('input[name="nama"]').value = namaPasien
            document.querySelector('input[name="alamat"]').value = alamatPasien
        }

        function closeForm() {
            containerAddAntrianElm.classList.remove("show")
        }
    </script>
</body>

</html>