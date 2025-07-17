<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: ../login.php");
}

// Tambah gejala
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $conn->query("INSERT INTO gejala (nama_gejala) VALUES ('$nama')");
}

// Edit gejala
if (isset($_POST['edit'])) {
  $id = $_POST['id_edit'];
  $nama = $_POST['nama_edit'];
  $conn->query("UPDATE gejala SET nama_gejala='$nama' WHERE id=$id");
  echo "<script>window.location='kelola-gejala.php';</script>";
}

// Hapus gejala
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $conn->query("DELETE FROM gejala WHERE id=$id");
}

// Data utama
$gejala = $conn->query("SELECT * FROM gejala");
$total_user = $conn->query("SELECT COUNT(*) as jml FROM users WHERE role='user'")->fetch_assoc()['jml'];
$total_gejala = $conn->query("SELECT COUNT(*) as jml FROM gejala")->fetch_assoc()['jml'];
$total_diagnosa = $conn->query("SELECT COUNT(*) as jml FROM hasil_diagnosa")->fetch_assoc()['jml'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Kelola Gejala</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white"> <?= $_SESSION['user']['username'] ?></span>
      <a href="../logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="text-success mb-4">Kelola Gejala Tanaman Hias</h3>

      <!-- Form tambah -->
      <form method="post" class="row g-3 mb-4">
        <div class="col-auto">
          <input type="text" name="nama" class="form-control" placeholder="Gejala baru" required>
        </div>
        <div class="col-auto">
          <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
        </div>
      </form>

      <!-- Statistik -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card border-success shadow-sm">
            <div class="card-body text-center">
              <h5>Jumlah Pengguna</h5>
              <h3><?= $total_user ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-success shadow-sm">
            <div class="card-body text-center">
              <h5>Jumlah Gejala</h5>
              <h3><?= $total_gejala ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-success shadow-sm">
            <div class="card-body text-center">
              <h5>Total Diagnosa</h5>
              <h3><?= $total_diagnosa ?></h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel gejala -->
      <table class="table table-bordered table-striped">
        <thead class="table-success">
          <tr>
            <th>No</th>
            <th>Nama Gejala</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; $gejala->data_seek(0); while($row = $gejala->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_gejala'] ?></td>
            <td>
              <!-- Edit Button -->
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
              <!-- Delete -->
              <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <!-- Modal edit -->
      <?php $gejala->data_seek(0); while($edit = $gejala->fetch_assoc()): ?>
      <div class="modal fade" id="editModal<?= $edit['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="post" class="modal-content">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title">Edit Gejala</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_edit" value="<?= $edit['id'] ?>">
              <input type="text" name="nama_edit" value="<?= $edit['nama_gejala'] ?>" class="form-control" required>
            </div>
            <div class="modal-footer">
              <button type="submit" name="edit" class="btn btn-success">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
      <?php endwhile; ?>

      <a href="dashboard.php" class="btn btn-outline-secondary mt-4">⬅ Kembali ke Dashboard</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
