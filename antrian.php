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
            /* font-size: small; */
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
                        <option value="0">Belum Hadir</option>
                        <option value="1">Sudah Hadir</option>
                    </select>
                </div>
                <div>
                    <p>Status Antrian</p>
                    <select name="isOpen">
                        <option value="0">Antrian tidak dibuka</option>
                        <option value="1">Antrian dibuka</option>
                    </select>
                </div>
                <a href="/api.php?function=hapusAllAntrian">
                    <button>Hapus Semua Antrian</button>
                </a>
            </div>
        </section>
        <section class="content">
            <div style="border-top: 1px solid gainsboro; padding: 1em">
                <h3>Daftar Antrian</h3>
                <label>
                    Pasien Baru
                    <input type="checkbox" name="cek" />
                </label>
                <form method="get" style="display: flex; gap: 0.3em">
                    <p>Search part of</p>
                    <select name="filter-select">
                        <option value="fullname">Fullname</option>
                        <option value="ID">ID Pasien</option>
                        <option value="Address">Address</option>
                    </select>:
                    <input type="text" name="filter" />
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
                            include('api.php');
                            if ($_GET['filter-select'] == "fullname") {
                                $data_pasien = getPasienNama();
                            } else if ($_GET['filter-select'] == "ID") {
                                $data_pasien = getPasienId();
                            } else if ($_GET['filter-select'] == "Address") {
                                $data_pasien = getPasienAddress();
                            } else {
                                $data_pasien = getAllPasien();
                            }
                            if (!$_GET['filter-select']) $no = ($_GET['pag'] - 1) * 25 + 1;
                            else $no = 1;
                            foreach ($data_pasien as $data) {
                                echo '<tr>
                                        <td>' . $no . '</td>
                                        <td>' . $data->ID . '</td>
                                        <td>' . $data->fullname . '</td>
                                        <td>' . $data->Address . '</td>
                                        <td><a href="/api.php?function=addAntrian&nama=' . $data->fullname . '" class="tombol">Antri</a></td>
                                        </tr>';
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginasi" style="margin-inline: auto; width: fit-content">
                    <button onclick="prev()">Prev</button>
                    <button onclick="next()">Next</button>
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
                                $button = '<a href="/api.php?function=updateAntrian&waktu=' . $data->waktu . '" class="tombol">Selesai</a>
                                                  <a href="/api.php?function=hapusAntrian&waktu=' . $data->waktu . '" class="tombol">Hapus</a>';
                                $tr = '<tr>';
                            } else {
                                $button = $data->status;
                                $tr = '<tr class="teks-hijau">';
                            }
                            echo $tr . '<td>' . $data->waktu . '</td>
                                    <td>' . $data->pasien . '</td>
                                    <td>' . $button . '</td>
                                    </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <footer>
        <p style="font-weight: bold" id="tanggal">None</p>
    </footer>
    <script>
        const isOpenElm = document.querySelector('select[name="isOpen"]');
        const isDokterElm = document.querySelector('select[name="isDokter"]');

        isOpenElm.addEventListener("change", (e) => {
            fetch("/api.php?function=updateOpen&status=" + e.target.value);
            if (e.target.value == '1') isOpenElm.classList.add("select-hijau");
            else isOpenElm.classList.remove("select-hijau");
        });
        isDokterElm.addEventListener("change", (e) => {
            fetch("/api.php?function=updateDokter&status=" + e.target.value);
            if (e.target.value == '1') isDokterElm.classList.add("select-hijau");
            else isDokterElm.classList.remove("select-hijau");
        });

        const tgl = new Date();
        const arrDay = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
        ];
        const arrMonth = [
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
        const str_tgl = arrDay[tgl.getDay()] + ", " + tgl.getDate() + " " + arrMonth[tgl.getMonth()] + " " + tgl.getFullYear();
        document.getElementById("tanggal").innerHTML = str_tgl;

        //ambil dari database
        let totalPasien = 0;
        async function getStatus() {
            const res = await fetch("/api.php?function=getStatus");
            const data = await res.json();
            totalPasien = data.totalPasien;
            isDokterElm.value = data.isDokter;
            isOpenElm.value = data.isOpen;
            if (data.isDokter == '1') isDokterElm.classList.add("select-hijau");
            if (data.isOpen == '1') isOpenElm.classList.add("select-hijau");
        }
        getStatus();

        function prev() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const pag = Number(urlParams.get('pag'));
            if (pag > 1) window.location.href = "/antrian.php?pag=" + (pag - 1);
        }

        function next() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const pag = Number(urlParams.get('pag'));
            if (pag * 25 < totalPasien) window.location.href = "/antrian.php?pag=" + (pag + 1);
        }
    </script>
</body>

</html>