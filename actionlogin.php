<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username != 'admin' || $password != '123456') {
    $_SESSION['flash'] = 'Username atau password salah';
    header('Location: ./login.php');
    return die();
}
$_SESSION['login'] = true;
header('Location: ./pasienList.php?pag=1');
die();
