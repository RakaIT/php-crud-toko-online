<?php

include 'koneksi.php';
include '../layout/header_transaksi.php';

$data = mysqli_query($koneksi, "
  SELECT transaksi.*, produk.nama_produk

  FROM transaksi

  JOIN produk
  ON transaksi.produk_id = produk.id
  ORDER BY transaksi.id DESC

");

$no = 1;

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
  <a href="tambah.php" Tambah.php" class="btn btn-success mb-3">
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
          <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
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