<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    $_SESSION['url_before_login'] = './newPasien.php';
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

        button.merah {
            background-color: var(--merah);
            color: var(--putih);
        }

        button.merah:hover {
            background-color: var(--hitam);
            color: var(--putih);
        }

        main {
            display: flex;
            gap: 20px;
        }

        main>.kanan {
            width: calc(100% - 350px);
        }

        main>.kiri {
            width: 330px;
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

        table {
            border-collapse: collapse;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 0.3rem 0.7rem;
        }

        .container-tabel {
            display: block;
            overflow: scroll;
            height: calc(100vh - 250px);
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

        .sembunyikan {
            display: none;
        }
    </style>
    <title>Oceria | New Patient</title>
</head>

<body>
    <header>
        <div class="nav">
            <h1><a href="./">Oceria</a></h1>
            <ul>
                <li><a href="./pasienList.php?pag=1">Patient List</a></li>
                <li class="active"><a href="./newPasien.php">New Patient</a></li>
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
            <form method="post" action="./api.php?function=addPasien" enctype="multipart/form-data">
                <section class="container-isian">
                    <span>
                        <p>Full Name:</p>
                        <p>ID:</p>
                        <p>Date of Birth:</p>
                        <p>Address:</p>
                        <p>No. HP:</p>
                        <p>Job:</p>
                        <p>Sex:</p>
                        <p>Status:</p>
                        <p>Blood Type:</p>
                        <p>BPJS Member?</p>
                        <p>NIK:</p>
                        <p>Init MR:</p>
                    </span>
                    <span>
                        <input type="text" name="fullname" required />
                        <input type="text" name="ID" required />
                        <input type="date" name="tgl_lahir" required />
                        <input type="text" name="Address" required />
                        <input type="number" name="NoHP" />
                        <input type="text" name="Job" />
                        <select name="sex" required>
                            <option value="L" selected="selected">Male</option>
                            <option value="P">Female</option>
                        </select>
                        <input type="text" name="status" />
                        <select name="BloodType">
                            <option value="A" selected="selected">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                        <select name="BPJS">
                            <option value="T" selected="selected">Ya</option>
                            <option value="F">Tidak</option>
                        </select>
                        <input type="number" name="NIK" required />
                        <textarea name="medicalrecord" rows="10" cols="24"></textarea>
                        <input type="file" name="photo" style="display: none" disabled="true" />
                    </span>
                </section>
                <button type="submit" class="hijau" style="font-size: large">
                    SAVE
                </button>
            </form>
        </div>
        <div class="kanan">
            <div class="card" style="text-align: center; margin-bottom: 0.5rem">
                <h2>Photo</h2>
                <div style="
                            width: 400px;
                            height: 300px;
                            background-color: whitesmoke;
                            border: 1px solid black;
                            text-align: center;
                            margin-block: 0.5em;
                            margin-inline: auto;
                        ">
                    <video id="video" width="400px" height="300px" autoplay class="sembunyikan"></video>
                    <canvas id="canvas" width="400px" height="300px" style="display: none"></canvas>
                    <img src="pic/nopic.jpg" id="gambar-prev" height="100%" />
                </div>
                <div style="background-color: aqua"></div>
                <div>
                    <section class="gantian">
                        <button id="start-camera">Edit Photo</button>
                        <button class="merah" id="del-photo">
                            Remove Photo
                        </button>
                    </section>
                    <section class="gantian sembunyikan">
                        <button id="click-photo">CAPTURE</button>
                        <label class="tombol">
                            Upload Foto
                            <input type="file" style="display: none" accept="image/" name="file" />
                        </label>
                        <button class="merah">Cancel</button>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <script>
        let camera_button = document.querySelector("#start-camera");
        let video = document.querySelector("#video");
        let click_button = document.querySelector("#click-photo");
        let canvas = document.querySelector("#canvas");
        let gambar = document.querySelector("#gambar-prev");
        let gantian = document.querySelectorAll(".gantian");
        const photoElm = document.querySelector("input[name='photo']");
        const fileElm = document.querySelector("input[name='file']");
        const form = document.querySelector("input[name='fullname']");

        camera_button.addEventListener("click", async function() {
            let stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });
            window.localStream = stream;
            video.classList.remove("sembunyikan");
            gambar.classList.add("sembunyikan");
            video.srcObject = stream;
            gantian[0].classList.add("sembunyikan");
            gantian[1].classList.remove("sembunyikan");
        });

        click_button.addEventListener("click", function() {
            canvas
                .getContext("2d")
                .drawImage(video, 0, 0, canvas.width, canvas.height);
            canvas.toBlob(
                (blob) => {
                    const myFile = new File([blob], "imageCanva.jpg", {
                        type: "image/jpeg",
                        lastModified: new Date()
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(myFile);
                    photoElm.files = dataTransfer.files;
                    photoElm.disabled = false;

                    var blobUrl = URL.createObjectURL(blob);
                    gambar.src = blobUrl;
                },
                "image/jpeg",
                1
            );
            localStream.getVideoTracks()[0].stop();
            video.classList.add("sembunyikan");
            gambar.classList.remove("sembunyikan");
            video.src = "";
            gantian[1].classList.add("sembunyikan");
            gantian[0].classList.remove("sembunyikan");
        });

        form.addEventListener("change", (e) => {
            const idElm = document.querySelector("input[name='ID']");
            async function generateId() {
                const res = await fetch("./api.php?function=generateId&id=" + e.target.value[0]);
                const id = (await res.json()).id;
                idElm.value = id;
            }
            generateId();
        });

        fileElm.addEventListener("change", (e) => {
            const file = fileElm.files[0];
            const blobFile = new Blob([file], {
                type: file.type
            });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            photoElm.files = dataTransfer.files;
            photoElm.disabled = false;

            var blobUrl = URL.createObjectURL(blobFile);
            gambar.src = blobUrl;
            gambar.classList.remove("sembunyikan");
            localStream.getVideoTracks()[0].stop();
            video.src = "";
            video.classList.add("sembunyikan");
            gantian[1].classList.add("sembunyikan");
            gantian[0].classList.remove("sembunyikan");
        });

        const delPhotoElm = document.getElementById("del-photo");
        delPhotoElm.addEventListener("click", () => {
            photoElm.disabled = true;
            gambar.src = "pic/nopic.jpg";
        });
    </script>
</body>

</html>