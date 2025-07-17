<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
  header("Location: login.php");
  exit;
}
include "koneksi.php";

$gejala = $_POST['gejala'] ?? [];
$hasil = "Tidak ada gejala yang dipilih.";

if (count($gejala) > 0) {
    if (in_array("Daun layu", $gejala) && in_array("Daun menguning", $gejala)) {
        $hasil = "Kemungkinan overwatering atau akar membusuk.";
    } elseif (in_array("Bercak coklat di daun", $gejala) && in_array("Daun keriting", $gejala)) {
        $hasil = "Kemungkinan terkena jamur atau tungau.";
    } elseif (in_array("Pertumbuhan lambat", $gejala)) {
        $hasil = "Kemungkinan kekurangan nutrisi atau cahaya.";
    } else {
        $hasil = "Tanaman mungkin mengalami masalah ringan.";
    }

    $gejala_terpilih = implode(", ", $gejala);
    $user_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("INSERT INTO hasil_diagnosa (user_id, gejala_terpilih, hasil) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $gejala_terpilih, $hasil);
    $stmt->execute();
    $stmt->close();
}

header("Location: hasil.php");
exit;
