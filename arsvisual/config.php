<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ars_visual";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset untuk menghindari masalah encoding
mysqli_set_charset($conn, "utf8mb4");

// Session hanya dimulai sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
