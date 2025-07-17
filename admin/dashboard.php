<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white"><?= $_SESSION['user']['username'] ?></span>
      <a href="../logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="card shadow">
    <div class="card-body">
      <h2 class="text-success">Dashboard </h2>
      <p>Selamat datang, <strong><?= $_SESSION['user']['username'] ?></strong>!</p>
      <a href="kelola-gejala.php" class="btn btn-outline-success me-2">Kelola Gejala</a>
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</div>

</body>
</html>
