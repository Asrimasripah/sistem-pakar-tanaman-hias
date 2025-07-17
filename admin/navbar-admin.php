<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Sistem Pakar Tanaman Hias</a>
    <div class="d-flex">
      <span class="navbar-text me-3 text-white">
        Admin: <?= $_SESSION['user']['username'] ?>
      </span>
      <a href="../logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>
