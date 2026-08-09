<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
}

include './koneksi.php';
include '../layout/header_dashboard.php';
?>
<?php
$user = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users");
$totalUser = mysqli_fetch_assoc($user);

$produk = mysqli_query($koneksi, "SELECT COUNT(*)AS total FROM produk");
$totalProduk = mysqli_fetch_assoc($produk);

$stok = mysqli_query($koneksi, "SELECT SUM(stok) AS total FROM produk");
$totalStok = mysqli_fetch_assoc($stok);

?>

<div class="container mt-4">

  <div class="hero-dashboard">
    <div class="hero-dashboard-overlay">
      <h1>Dashboard Admin</h1>
    </div>
  </div>
  <div class="container mt-5">
    <div class="row g-4">

      <div class="col-md-4">
        <div class="card dashboard-card shadow border-0">
          <div class="card-body text-center">

            <i class="bi bi-people-fill text-primary display-4"></i>

            <h5 class="mt-3">Total User</h5>

            <h1><?= $totalUser['total']; ?></h1>

          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card dashboard-card shadow border-0">
          <div class="card-body text-center">

            <i class="bi bi-box-seam text-success display-4"></i>

            <h5 class="mt-3">Total Produk</h5>

            <h1><?= $totalProduk['total']; ?></h1>

          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card dashboard-card shadow border-0">
          <div class="card-body text-center">

            <i class="bi bi-bar-chart-fill text-warning display-4"></i>

            <h5 class="mt-3">Total Stok</h5>

            <h1><?= $totalStok['total']; ?></h1>

          </div>
        </div>
      </div>
      <div class="container mt-5">

        <h3 class="mb-4">Menu Cepat</h3>

        <div class="row g-4">

          <div class="col-md-6">

            <a href="../user/index.php" class="text-decoration-none">

              <div class="card dashboard-card shadow border-0">

                <div class="card-body text-center">

                  <i class="bi bi-people-fill text-primary fs-1"></i>

                  <h4 class="mt-3">Kelola User</h4>
                </div>

              </div>

            </a>

          </div>

          <div class="col-md-6">

            <a href="../produk/index.php" class="text-decoration-none">

              <div class="card dashboard-card shadow border-0">

                <div class="card-body text-center">

                  <i class="bi bi-box-seam text-success fs-1"></i>

                  <h4 class="mt-3">Kelola Produk</h4>


                </div>

              </div>

            </a>

          </div>

        </div>

      </div>

    </div>
  </div>


</div>




<?php include '../layout/footer.php'; ?>