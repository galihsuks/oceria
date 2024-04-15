<?php
session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['login']) {
        header('Location: ./');
        die();
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;700;900&display=swap");

        * {
            --putih: white;
            --hitam: rgb(27, 27, 27);
            --hijau: #0cca98;
            --merah: #e2125d;
            font-family: "Outfit", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: var(--hitam);
        }

        body {
            height: 100svh;
            display: flex;
            flex-direction: column;
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

        label {
            display: block;
        }

        input,
        select {
            display: block;
            padding: 0.1em 0.3em;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        footer {
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background-color: #0cca98;
        }

        .kiri {
            width: 70%;
        }

        .kanan {
            width: 30%;
        }

        img {
            max-width: 100%;
            border-radius: 1em;
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

        button,
        .tombol {
            display: inline-block;
            padding: 0.5em;
            border: none;
            border-radius: 0.5em;
            font-weight: bold;
            background-color: whitesmoke;
            width: fit-content;
            font-size: medium;
        }

        button:hover,
        .tombol:hover {
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

        .flash {
            padding: 0.5em 1em;
            border-radius: 0.5em;
        }

        .flash.merah {
            background-color: var(--merah);
            color: white;
        }

        .flash.hijau {
            background-color: var(--hijau);
            color: white;
        }

        .flash.abu {
            background-color: var(--hijau);
            color: white;
        }
    </style>
    <title>Oceria | Login</title>
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
        <div>
            <h1 style="text-align: center; margin-bottom: 0.7em;">Login</h1>
            <?php if (isset($_SESSION['flash'])) { ?>
                <p class="flash merah" style="margin-bottom: 0.7em;"><?= $_SESSION['flash']; ?></p>
            <?php unset($_SESSION['flash']);
            } ?>
            <form action="./actionlogin.php" method="post">
                <div style="margin-bottom: 0.5em;">
                    <label>Username</label>
                    <input required type="text" placeholder="username" name="username">
                </div>
                <div>
                    <label>Password</label>
                    <input required type="password" placeholder="password" name="password">
                </div>
                <div style="width: 100%; display: flex; justify-content:center; margin-top: 1em;">
                    <button class="hijau" style="margin-inline: auto;" type="submit">Masuk</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <div style="
                    width: 80%;
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                    max-width: 1000px;
                ">
            <p style="color: white; font-weight: bold" id="tanggal">None</p>
            <p style="color: white; font-weight: bold" id="waktu">None</p>
        </div>
    </footer>
    <script>
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
        const str_tgl =
            arrDay[tgl.getDay()] +
            ", " +
            tgl.getDate() +
            " " +
            arrMonth[tgl.getMonth()] +
            " " +
            tgl.getFullYear();
        document.getElementById("tanggal").innerHTML = str_tgl;

        setInterval(() => {
            const wkt = new Date();
            const str_waktu =
                ("00" + String(wkt.getHours())).substring(
                    ("00" + String(wkt.getHours())).length - 2
                ) +
                ":" +
                ("00" + String(wkt.getMinutes())).substring(
                    ("00" + String(wkt.getMinutes())).length - 2
                ) +
                ":" +
                ("00" + String(wkt.getSeconds())).substring(
                    ("00" + String(wkt.getSeconds())).length - 2
                );
            document.getElementById("waktu").innerHTML = str_waktu;
        }, 1000);
    </script>
</body>

</html>