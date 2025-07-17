<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Beranda Pengguna - Sistem Pakar Tanaman Hias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        User: <?= $_SESSION['user']['username'] ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="text-success">Selamat Datang di Sistem Pakar Tanaman Hias</h1>
    <p class="lead">Silakan mulai diagnosa berdasarkan gejala yang Anda alami.</p>
    <a href="diagnosa.php" class="btn btn-success btn-lg">Mulai Diagnosa</a>
    <a href="riwayat.php" class="btn btn-outline-secondary btn-lg">Riwayat Diagnosa</a>
  </div>
</div>
</body>
</html>
