<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
  header("Location: login.php");
  exit;
}

if (!isset($_POST['gejala']) || empty($_POST['gejala'])) {
  header("Location: diagnosa.php");
  exit;
}

$selected_gejala = $_POST['gejala'];

// Hitung skor penyakit berdasarkan rule
$penyakit_scores = [];
$rules = $conn->query("SELECT * FROM rule_diagnosa");
while ($rule = $rules->fetch_assoc()) {
  if (in_array($rule['id_gejala'], $selected_gejala)) {
    if (!isset($penyakit_scores[$rule['id_penyakit']])) {
      $penyakit_scores[$rule['id_penyakit']] = 0;
    }
    $penyakit_scores[$rule['id_penyakit']]++;
  }
}

arsort($penyakit_scores);

// Cek apakah ada penyakit ditemukan
if (empty($penyakit_scores)) {
  $hasil_penyakit = [
    'nama_penyakit' => 'Tidak Diketahui',
    'deskripsi' => 'Tidak ditemukan kecocokan penyakit dengan gejala yang dipilih.'
  ];
} else {
  $id_penyakit = array_key_first($penyakit_scores);
  $hasil_penyakit = $conn->query("SELECT * FROM penyakit WHERE id=$id_penyakit")->fetch_assoc();

  // Simpan riwayat diagnosa
  $user_id = $_SESSION['user']['id'];
  $conn->query("INSERT INTO hasil_diagnosa (user_id, penyakit_id) VALUES ($user_id, $id_penyakit)");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Hasil Diagnosa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white">
        User: <?= $_SESSION['user']['username'] ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>
<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="text-success">Hasil Diagnosa</h3>
      <h4 class="mb-3"><?= $hasil_penyakit['nama_penyakit'] ?></h4>
      <p><?= $hasil_penyakit['deskripsi'] ?></p>
      <a href="diagnosa.php" class="btn btn-success mt-3">Diagnosa Lagi</a>
      <a href="index.php" class="btn btn-outline-secondary mt-3">⬅ Kembali ke Beranda</a>
      <a href="riwayat.php" class="btn btn-outline-secondary mt-3">Lihat Riwayat</a>
    </div>
  </div>
</div>
</body>
</html>
