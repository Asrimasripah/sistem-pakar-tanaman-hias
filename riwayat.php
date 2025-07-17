<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
  header("Location: login.php");
}
$id_user = $_SESSION['user']['id'];
$data = $conn->query("SELECT hd.tanggal, p.nama_penyakit, p.deskripsi 
                      FROM hasil_diagnosa hd 
                      JOIN penyakit p ON hd.penyakit_id = p.id 
                      WHERE hd.user_id = $id_user 
                      ORDER BY hd.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Riwayat Diagnosa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="diagnosa.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white">User: <?= $_SESSION['user']['username'] ?></span>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>
<div class="container">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="text-success mb-4">Riwayat Diagnosa</h3>
      <table class="table table-bordered">
        <thead class="table-success"><tr><th>Tanggal</th><th>Penyakit</th><th>Deskripsi</th></tr></thead>
        <tbody>
          <?php while($row = $data->fetch_assoc()): ?>
          <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nama_penyakit'] ?></td>
            <td><?= $row['deskripsi'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <a href="index.php" class="btn btn-outline-secondary mt-3">⬅ Kembali ke Beranda</a>
    </div>
  </div>
</div>
</body>
</html>
