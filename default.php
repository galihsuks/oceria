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

        header {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: calc(100vh - 90px - 50px - 1px);
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

        .tombol {
            text-decoration: none;
            padding: 0.5em 1em;
            border-radius: 0.5em;
            font-weight: bold;
            border: 2px solid grey;
        }

        .tombol:hover {
            background-color: var(--hijau);
            color: white;
            border: 2px solid var(--hijau);
        }

        @media (max-width: 600px) {
            .show-ke-hide {
                display: none;
            }
        }
    </style>
    <title>Oceria</title>
</head>

<body>
    <header>
        <div style="
                    width: 80%;
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                    max-width: 1000px;
                ">
            <img src="pic/Logo.png" height="37px" />
            <h1 style="color: var(--hijau); font-size: 50px">Oceria</h1>
            <span style="text-align: right">
                <p><b>My Dentist</b></p>
                <p style="font-size: small">Dentist Information System</p>
                <p style="font-size: small">Online Version</p>
            </span>
        </div>
    </header>
    <div style="
                width: 80%;
                height: 1px;
                background-color: rgb(216, 216, 216);
                margin-inline: auto;
            "></div>
    <main>
        <div style="width: 80%; display: flex; gap: 1em; max-width: 904px">
            <section class="kiri">
                <h1 style="margin-bottom: 0.5em; font-size: 2em">
                    Drg. Sri Umiati
                </h1>
                <p>Address</p>
                <p style="font-size: large; margin-bottom: 0.5em">
                    <b>Kradenan, Trucuk</b>
                </p>
                <p>
                    Klinik Oceria berdiri sejak tahun 2010. Sampai dengan hari ini telah mencapai ribuan pasien yang ditangani oleh Drg. Sri Umiati yang profesional. Adapun layanan yang tersedia yaitu cabut gigi, pembersihan karang gigi, orto, konsultasi gigi, radang gusi. Kami mengedapankan kenyamanan pasien dan ramah anak.
                </p>
            </section>
            <section class="kanan">
                <img src="pic/dentist2.jpg" />
                <div style="
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-top: 2em;
                        ">
                    <p>Profile</p>
                    <div style="display: flex; gap: 0.5em">
                        <img src="pic/instagram.png" height="40px" />
                        <img src="pic/facebook.png" height="40px" />
                        <img src="pic/wa.png" height="40px" />
                    </div>
                </div>
            </section>
        </div>
        <div style="margin-top: 2.5em">
            <a class="tombol" href="./pasienList.php?pag=1">Patient Database Management</a>
            <a class="tombol" href="./daftarKunjungan.php?pag=1">Rekap Kunjungan Pasien</a>
            <a class="tombol" href="">Dental Intra-Oral Camera</a>
            <a class="tombol" href="./antrian.php?pag=1">Antrian</a>
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