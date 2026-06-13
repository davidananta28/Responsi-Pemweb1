<?php
// config/koneksi.php

$host     = "localhost";
$username = "root"; // Sesuaikan jika ada password di XAMPP/Laragon kamu
$password = "";
$database = "got_db";

$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
