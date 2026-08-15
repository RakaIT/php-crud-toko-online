<?php

include 'koneksi.php';
include '../layout/header_transaksi.php';


?>

<div class="hero">
  <div class="hero-user-overlay">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <form method="GET" class="d-flex">

        <input class="form-control search-box"
          type="text"
          name="search"
          class="form-control me-2"
          placeholder="Cari Transaksi..."
          value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="btn btn-info ms-1">
          <i class="bi bi-search"></i>
        </button>
      </form>
      <a href="tambah.php" class="btn btn-success ms-2">
        <i class="bi bi-cart-plus"></i>
      </a>
    </div>
  </div>
</div>
<div class="container mt-4">
  <a href="" Tambah.php" class="btn btn-success mb-3">
    <i class="bi bi-cart-plus"></i>
    Tambah Transaksi
  </a>
</div>

<table class="table table-hover">

  <thead>

    <tr>

      <th>No</th>
      <th>Tanggal</th>
      <th>Produk</th>
      <th>Qty</th>
      <th>Total</th>
      <th>Aksi</th>

    </tr>

  </thead>

  <tbody>

    <tr>

      <td colspan="6" class="text-center">
        Belum ada transaksi
      </td>

    </tr>

  </tbody>

</table>
<?php
include '../layout/footer.php';
?>