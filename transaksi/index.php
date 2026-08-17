<?php

include 'koneksi.php';
include '../layout/header_transaksi.php';

$search = "";

if (isset($_GET['search'])) {
  $search = $_GET['search'];
}

$data = mysqli_query($koneksi, "
SELECT transaksi.*, produk.nama_produk
FROM transaksi
JOIN produk
ON transaksi.produk_id = produk.id
WHERE produk.nama_produk LIKE '%$search%'
ORDER BY transaksi.id DESC
");


$no = 1;

?>
<div class="container">

  <div class="hero-transaksi">

    <div class="hero-overlay">

      <div class="row align-items-center h-100">

        <div class="col-md-6">

          <h1 class="hero-title">
            <i class="bi bi-cart-check"></i>
            Data Transaksi
          </h1>

          <p class="hero-subtitle">
            Kelola seluruh transaksi penjualan.
          </p>

          <form method="GET" class="d-flex mt-4">

            <input
              type="text"
              name="search"
              class="form-control"
              placeholder="Cari transaksi..."
              value="<?= $search; ?>">

            <button class="btn btn-info ms-2">
              <i class="bi bi-search"></i>
            </button>

          </form>

        </div>

      </div>

    </div>

  </div>

</div>
<div class="d-flex justify-content-between align-items-center  mb-4">

  <h3 class="fw-bold mb-0">
    <i class="bi bi-clock-history"></i>
    Riwayat Transaksi
  </h3>

  <a href="tambah.php" class="btn btn-success btn-tambah">
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

    <?php while ($row = mysqli_fetch_assoc($data)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['created_at']; ?></td>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['qty']; ?></td>
        <td>Rp<?= number_format($row['total']); ?></td>
        <td>
          <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">
            Edit
          </a>
          <a
            href="hapus.php?id=<?= $row['id']; ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
            <i class="bi bi-trash"></i>
            Hapus
          </a>
        </td>
      </tr>
    <?php } ?>
  </tbody>

</table>
<?php
include '../layout/footer.php';
?>