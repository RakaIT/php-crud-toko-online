<?php
include 'koneksi.php';
include '../layout/header_laporan.php';

// Total Pendapatan
$totalPendapatan = mysqli_query($koneksi, "
SELECT SUM(total) AS total
FROM transaksi
");

$totalPendapatan = mysqli_fetch_assoc($totalPendapatan);



$data = mysqli_query($koneksi, "
  SELECT transaksi.*, produk.nama_produk,produk.harga
  FROM transaksi
  JOIN produk
  ON transaksi.produk_id = produk.id
  ORDER BY transaksi.created_at DESC
  ");

$no = 1;
?>
<div class="container mt-5">

  <div class="card shadow border-0 rounded-4">

    <div class="card-header bg-white">
      <h4 class="fw-bold mb-0">
        <i class="bi bi-file-earmark-bar-graph"></i>
        Laporan Penjualan
      </h4>
    </div>

    <div class="card-body">

      <table class="table table-hover align-middle">

        <thead>

          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
          </tr>

        </thead>

        <tbody>

          <?php while ($row = mysqli_fetch_assoc($data)) : ?>

            <tr>

              <td><?= $no++; ?></td>

              <td><?= $row['created_at']; ?></td>

              <td><?= $row['nama_produk']; ?></td>

              <td><?= $row['qty']; ?></td>

              <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>

              <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>

            </tr>

          <?php endwhile; ?>

        </tbody>

      </table>
      <tfoot class="table-warning">
        <tr>
          <th colspan="5" class="text-end">
            Total Pendapatan
          </th>
          <th class="text-success">
            Rp <?= number_format($totalPendapatan['total'], 0, ',', '.'); ?>
          </th>
        </tr>

      </tfoot>

    </div>

  </div>

</div>

<?php include '../layout/footer.php'; ?>