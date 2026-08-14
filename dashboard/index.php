<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
}

include './koneksi.php';

// Total User
$user = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users");
$totalUser = mysqli_fetch_assoc($user);

// Total Produk
$produk = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk");
$totalProduk = mysqli_fetch_assoc($produk);

// Total Stok
$stok = mysqli_query($koneksi, "SELECT SUM(stok) AS total FROM produk");
$totalStok = mysqli_fetch_assoc($stok);

$inventori = mysqli_query(
  $koneksi,
  "SELECT SUM(harga * stok) AS total FROM produk"
);

$totalInventori = mysqli_fetch_assoc($inventori);

// Produk Terbaru
$produkTerbaru = mysqli_query(
  $koneksi,
  "SELECT *
    FROM produk
    ORDER BY created_at DESC
    LIMIT 5"
);

include '../layout/header_dashboard.php';
?>

<div class="container mt-4">

  <div class="hero-dashboard">
    <div class="hero-dashboard-overlay">
      <h1>Dashboard Admin</h1>
    </div>
  </div>
  <div class="row g-4">

    <div class="col-md-3">
      <div class="card card-dashboard shadow border-0 h-100">
        <div class="card-body text-center">

          <i class="bi bi-people-fill text-primary display-4"></i>

          <h5 class="mt-3">Total User</h5>

          <h1><?= $totalUser['total']; ?></h1>

        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-dashboard shadow border-0 h-100">
        <div class="card-body text-center">

          <i class="bi bi-box-seam text-success display-4"></i>

          <h5 class="mt-3">Total Produk</h5>

          <h1><?= $totalProduk['total']; ?></h1>

        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-dashboard shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-bar-chart-fill text-warning display-4"></i>
          <h5 class="mt-3">Total Stok</h5>

          <h1><?= $totalStok['total']; ?></h1>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-dashboard shadow border-0 h-100">
        <div class="card-body text-center">

          <i class="bi bi-cash-stack text-success display-4"></i>

          <h5 class="mt-3">Nilai Inventori</h5>
          <p class="text-success">
          Rp <?= number_format($totalInventori['total'], 0, ',', '.'); ?>
          </p>
        </div>
      </div>
    </div>

    <div class="card shadow mt-4">
      <div class="card-header">
        <h5>Produk Terbaru</h5>
      </div>

      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($produkTerbaru)) {
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td>
                  Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                </td>
                <td><?= $row['stok']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="container mt-5">

      <h3 class="mb-4">Menu Cepat</h3>

      <div class="row g-4">

        <div class="col-md-6">

          <a href="../user/index.php" class="text-decoration-none">

            <div class="card quick-card border-0">

              <div class="card-body text-center">

                <i class="bi bi-people-fill fs-1 text-primary"></i>

                <h3 class="mt-3">Kelola User</h3>

                <p class="text-muted mb-3">
                  Kelola data user
                </p>

                <a href="../user/index.php"
                  class="btn btn-primary rounded-pill px-4">

                  Buka
                  <i class="bi bi-arrow-right-short"></i>

                </a>

              </div>

            </div>

          </a>

        </div>

        <div class="col-md-6">

          <a href="../produk/index.php" class="text-decoration-none">

            <div class="card quick-card border-0">

              <div class="card-body text-center">

                <i class="bi bi-box-seam fs-1 text-primary"></i>

                <h3 class="mt-3">Kelola Produk</h3>

                <p class="text-muted mb-3">
                  Kelola data Produk
                </p>

                <a href="../produk/index.php"
                  class="btn btn-primary rounded-pill px-4">

                  Buka
                  <i class="bi bi-arrow-right-short"></i>

                </a>

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