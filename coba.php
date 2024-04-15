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
    <link rel="stylesheet" href="css/newPasien.css" />
    <title>Oceria | New Patient</title>
</head>

<body>
    <header>
        <div class="nav">
            <h1 style="color: var(--hijau)">Oceria</h1>
            <ul>
                <li><a>Patient List</a></li>
                <li><a>New Patient</a></li>
                <li><a>Search</a></li>
                <li><a>Setting</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="kiri">
            <form method="post" action="/api.php?function=coba">
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
                        <p>Init MR:</p>
                    </span>
                    <span>
                        <input type="text" name="fullname" />
                        <input type="text" disabled value="xxxx" style="font-weight: bold" name="ID" />
                        <input type="date" name="tgl_lahir" />
                        <input type="text" name="Address" />
                        <input type="number" name="NoHP" />
                        <input type="text" name="Job" />
                        <select name="sex">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <input type="text" name="status" />
                        <select name="BloodType">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                        <input type="number" name="BPJS" />
                        <textarea name="medicalrecord" rows="10" cols="24"></textarea>
                    </span>
                </section>
                <button type="submit" class="hijau" style="font-size: large">SAVE</button>
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
                    <img src="assets/pic/noPic.jpg" id="gambar-prev" height="100%" />
                </div>
                <div style="background-color: aqua"></div>
                <div>
                    <section class="gantian">
                        <button id="start-camera">Edit Photo</button>
                        <button class="merah">Remove Photo</button>
                    </section>
                    <section class="gantian sembunyikan">
                        <button id="click-photo">CAPTURE</button>
                        <label class="tombol">
                            Upload Foto
                            <input type="file" style="display: none" accept="image/" />
                        </label>
                        <button class="merah">Cancel</button>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <script>
        let data = {};
        let camera_button = document.querySelector("#start-camera");
        let video = document.querySelector("#video");
        let click_button = document.querySelector("#click-photo");
        let canvas = document.querySelector("#canvas");
        let gambar = document.querySelector("#gambar-prev");
        let gantian = document.querySelectorAll(".gantian");

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
                    var blobUrl = URL.createObjectURL(blob);
                    gambar.src = blobUrl;
                    video.classList.add("sembunyikan");
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
    </script>
</body>

</html>