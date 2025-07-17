<?php
$host = "localhost";
$user = "root";
$pass = ""; // kosongkan jika kamu tidak pakai password XAMPP
$db   = "sistem_pakar";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
