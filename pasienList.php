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

        label {
            display: block;
        }

        input,
        select {
            display: block;
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
            width: max-content;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 0.3rem 0.7rem;
        }

        tr td:nth-child(1),
        tr td:nth-child(2),
        tr td:nth-child(4),
        tr td:nth-child(6),
        tr td:nth-child(7),
        tr td:nth-child(8),
        tr td:nth-child(9),
        tr td:nth-child(11),
        tr td:nth-child(12),
        tr td:nth-child(13) {
            text-align: center;
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
            gap: 0.3em;
        }

        .container-isian>span {
            width: 100%;
        }

        .container-isian p {
            line-height: 25px;
        }

        .container-isian input,
        .container-isian select {
            height: 21px;
            margin-block: 4px;
            max-width: 100%;
        }

        .container-filter {
            height: fit-content;
            padding-block: 0.5em;
        }
    </style>
    <title>Oceria | Patient List</title>
</head>

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li class="active"><a href="./pasienList.php?pag=1">Patient List</a></li>
                <li><a href="./newPasien.php">New Patient</a></li>
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
                    <option value="fullname">Name</option>
                    <option value="ID" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'ID' ? 'selected' : '') : '' ?>>ID</option>
                    <option value="Address" <?= isset($_GET['filter-select']) ? ($_GET['filter-select'] == 'Address' ? 'selected' : '') : '' ?>>Address</option>
                </select>:
                <input type="text" name="filter" value="<?= isset($_GET['filter-select']) ? $_GET['filter'] : '' ?>" />
                <input type="text" name="pag" value="1" style="display: none;">
                <button class="tombol" type="submit">
                    Apply
                </button>
                <?= isset($_GET['filter-select']) ? '<a href="./pasienList.php?pag=1" class="tombol">Show All</a>' : '' ?>
            </div>
        </form>
    </div>
    <main>
        <div style="display: flex; gap: 20px; height: 100%;">
            <div class="kiri">
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
                                <th>Date of Birth</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>NoHP</th>
                                <th>Job</th>
                                <th>Status</th>
                                <th>Medical Record</th>
                                <th>Photo</th>
                                <th>BPJS</th>
                                <th>Blood Type</th>
                                <th>NIK</th>
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
                                $data_pasien_lengkap = getAllPasien();
                                $data_pasien = $data_pasien_lengkap['dataLimit'];
                            }
                            $no = ($_GET['pag'] - 1) * 25 + 1;
                            function shortString($str)
                            {
                                if (strlen($str) > 15) return $str = substr($str, 0, 14) . '...';
                                return $str;
                            }
                            foreach ($data_pasien as $data) {
                                echo '<tr onclick="pilihData(`' . $data->ID . '`)">
                                        <td>' . $no . '</td>
                                        <td>' . $data->ID . '</td>
                                        <td>' . $data->fullname . '</td>
                                        <td>' . $data->tgl_lahir . '</td>
                                        <td>' . $data->Address . '</td>
                                        <td>' . $data->sex . '</td>
                                        <td>' . $data->NoHp . '</td>
                                        <td>' . $data->Job . '</td>
                                        <td>' . $data->status . '</td>
                                        <td>' . shortString($data->medicalrecord) . '</td>
                                        <td>' . $data->photo . '</td>
                                        <td>' . $data->BPJS . '</td>
                                        <td>' . $data->BloodType . '</td>
                                        <td>' . $data->NIK . '</td>
                                        </tr>';
                                $no++;
                            }
                            $totalPasien = count($data_pasien_lengkap['dataAll']);
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginasi" style="margin-inline: auto; width: fit-content; display: flex; gap: 5px; margin-top: 5px">
                    <?php if (!isset($_GET['filter-select'])) { ?>
                        <?= $_GET['pag'] > 1 ? '<a class="tombol" href="./pasienList.php?pag=' . ($_GET['pag'] - 1) . '">Prev</a>' : '' ?>
                        <?php
                        $data_status = getStatus();
                        if ($_GET['pag'] * 25 < $data_status->totalPasien) {
                            echo '<a class="tombol" href="./pasienList.php?pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                        }
                        ?>
                    <?php } else { ?>
                        <?php
                        if ($_GET['pag'] > 1) {
                            echo '<a class="tombol" href="./pasienList.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] - 1) . '">Prev</a>';
                        }
                        if ($_GET['pag'] * 25 < $totalPasien) {
                            echo '<a class="tombol" href="./pasienList.php?filter-select=' . $_GET['filter-select'] . '&filter=' . $_GET['filter'] . '&pag=' . ($_GET['pag'] + 1) . '">Next</a>';
                        }
                        ?>
                    <?php } ?>
                </div>
            </div>
            <div class="kanan">
                <!-- <section>
                <div class="card" style="margin-bottom: 1rem">
                    <h2>Photo</h2>
                    <img src="pic/nopic.jpg" width="260px" />
                    <p id="photo-id">Photo ID:</p>
                </div>
            </section> -->
                <section class="container-isian" style="margin-bottom: 1rem">
                    <span>
                        <p>Patient's ID:</p>
                        <p>Sex:</p>
                        <p>Name:</p>
                        <p>Address:</p>
                        <p>Date of Birth:</p>
                        <p>Age</p>
                        <p>Job:</p>
                        <p>Status:</p>
                        <p>BPJS Ins.:</p>
                        <p>No HP:</p>
                        <p>Blood Type:</p>
                        <p>NIK:</p>
                        <p>Medical Rec.:</p>
                    </span>
                    <span>
                        <input class="data-pasien" disabled type="text" name="ID" />
                        <input class="data-pasien" disabled type="text" name="sex" />
                        <input class="data-pasien" disabled type="text" name="fullname" />
                        <input class="data-pasien" disabled type="text" name="Address" />
                        <input class="data-pasien" disabled type="text" name="tgl_lahir" />
                        <input class="data-pasien" disabled type="text" name="age" />
                        <input class="data-pasien" disabled type="text" name="Job" />
                        <input class="data-pasien" disabled type="text" name="status" />
                        <input class="data-pasien" disabled type="text" name="BPJS" />
                        <input class="data-pasien" disabled type="number" name="NoHp" />
                        <input class="data-pasien" disabled type="text" name="BloodType" />
                        <input class="data-pasien" disabled type="number" name="NIK" />
                        <textarea class="data-pasien" disabled name="medicalrecord" rows="4" cols="24"></textarea>
                    </span>
                </section>
                <section id="tombol-bawah">
                    <button class="merah" disabled id="delete-button">Delete</button>
                </section>
                <h2>Total Patients: <?= $totalPasien ?></h2>
            </div>
        </div>
    </main>
    <script>
        // const imgElm = document.querySelector("img");
        // const photoIdElm = document.querySelector("#photo-id");
        const tmbElm = document.querySelector("#tombol-bawah");
        const dataElm = document.querySelectorAll(".data-pasien");

        function pilihData(id) {
            async function getPasien() {
                const res = await fetch("./api.php?function=getPasien&id=" + id);
                const data = (await res.json()).data;

                // photoIdElm.innerHTML = data.photo;
                dataElm[0].value = data.ID;
                dataElm[1].value = data.sex;
                dataElm[2].value = data.fullname;
                dataElm[3].value = data.Address;
                dataElm[4].value = data.tgl_lahir;
                dataElm[6].value = data.Job;
                dataElm[7].value = data.status;
                dataElm[8].value = data.BPJS;
                dataElm[9].value = data.NoHp;
                dataElm[10].value = data.BloodType;
                dataElm[11].value = data.NIK;
                dataElm[12].value = data.medicalrecord;

                const tglSkrg = new Date();
                dataElm[5].value = tglSkrg.getFullYear() - Number(data.tgl_lahir.split("/")[2]);

                tmbElm.innerHTML = `<button class="merah" onclick="deleteData('${id}')">Delete</button>`;
            }
            getPasien();

            // function getFoto() {
            //     const img = new Image();
            //     async function getFotoAsync() {
            //         const res = await fetch("./api.php?function=cekFoto&id=" + id);
            //         const data = (await res.json()).data[0];
            //         if (data) imgElm.src = "./api.php?function=getFoto&id=" + id;
            //         else {
            //             img.src = "pic/pasienLama/" + id + ".jpg";
            //             if (img.complete) {
            //                 imgElm.src = "pic/pasienLama/" + id + ".jpg";
            //             } else {
            //                 img.onload = () => {
            //                     imgElm.src = "pic/pasienLama/" + id + ".jpg";
            //                 };
            //                 img.onerror = () => {
            //                     imgElm.src = "pic/nopic.jpg";
            //                 };
            //             }
            //         }
            //     }
            //     getFotoAsync();
            // }
            // getFoto();
        }

        function deleteData(id) {
            let text = 'Seluruh data pasien dengan id ' + id + ' akan dihapus!';
            if (confirm(text) == true) {
                async function deletePasien() {
                    const res = await fetch("./api.php?function=cekFoto&id=" + id);
                    const data = (await res.json()).data;
                    if (data) await fetch("./api.php?function=delFoto&id=" + id);
                    window.location.href = "./api.php?function=delPasien&id=" + id;
                }
                deletePasien();
            }
        }
    </script>
</body>

</html>