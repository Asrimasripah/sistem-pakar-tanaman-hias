<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
  header("Location: login.php");
  exit;
}
$gejala = $conn->query("SELECT * FROM gejala");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Diagnosa Tanaman</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white">User: <?= $_SESSION['user']['username'] ?></span>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h4 class="text-success mb-3">Pilih Gejala</h4>
      <form method="post" action="hasil.php">
        <div class="row">
          <?php while ($row = $gejala->fetch_assoc()): ?>
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="gejala[]" value="<?= $row['id'] ?>" id="g<?= $row['id'] ?>">
                <label class="form-check-label" for="g<?= $row['id'] ?>">
                  <?= $row['nama_gejala'] ?>
                </label>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-success mt-3">Diagnosa Sekarang</button>
        <a href="index.php" class="btn btn-outline-secondary mt-3 ms-2">⬅ Kembali ke Beranda</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
