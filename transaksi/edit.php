<?php

include 'koneksi.php';
include '../layout/header_transaksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "
SELECT *
FROM transaksi
WHERE id='$id'
");

$row = mysqli_fetch_assoc($data);
$queryProduk = mysqli_query($koneksi, "
SELECT *
FROM produk
WHERE id='" . $row['produk_id'] . "'
");

$produk = mysqli_fetch_assoc($queryProduk);

if (isset($_POST['update'])) {

  $produk_id = $_POST['produk_id'];
  $qty_baru  = $_POST['qty'];

  // Ambil transaksi lama
  $transaksi_lama = mysqli_query($koneksi, "
    SELECT *
    FROM transaksi
    WHERE id='$id'
    ");

  $lama = mysqli_fetch_assoc($transaksi_lama);

  $produk_lama = $lama['produk_id'];
  $qty_lama    = $lama['qty'];

  // Balikin stok lama
  mysqli_query($koneksi, "
    UPDATE produk
    SET stok = stok + '$qty_lama'
    WHERE id='$produk_lama'
    ");

  // Ambil harga produk baru
  $produk = mysqli_query($koneksi, "
    SELECT *
    FROM produk
    WHERE id='$produk_id'
    ");

  $data = mysqli_fetch_assoc($produk);

  $harga = $data['harga'];
  $stok  = $data['stok'];

  $total = $harga * $qty_baru;

  // Cek stok cukup atau tidak
  if ($qty_baru > $stok) {

    // Balikin lagi stok seperti semula
    mysqli_query($koneksi, "
    UPDATE produk
    SET stok = stok - '$qty_lama'
    WHERE id = '$produk_lama'
    ");

    echo "
    <script>
    alert('Stok tidak mencukupi!');
    </script>
    ";
  } else {

    // Update transaksi
    mysqli_query($koneksi, "
    UPDATE transaksi
    SET
        produk_id = '$produk_id',
        qty = '$qty_baru',
        total = '$total'
    WHERE id = '$id'
    ");

    // Kurangi stok baru
    mysqli_query($koneksi, "
    UPDATE produk
    SET stok = stok - '$qty_baru'
    WHERE id = '$produk_id'
    ");

    echo "
    <script>
    alert('Transaksi berhasil diupdate!');
    document.location.href='index.php';
    </script>
    ";
  }
}
?>
<div class="container py-5" style="min-height:85vh;">
  <form method="POST">
    <div class="card shadow">


      <div class="card shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="mb-3">
                <label class="form-label fw-bold">
                  Produk
                </label>

                <input
                  type="text"
                  class="form-control bg-light"
                  value="<?= $produk['nama_produk']; ?>"
                  readonly>

                <input
                  type="hidden"
                  name="produk_id"
                  value="<?= $produk['id']; ?>">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">
                Qty
              </label>
              <input
                type="number"
                id="qty"
                name="qty"
                class="form-control"
                value="<?= $row['qty']; ?>">

            </div>

          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">
                Harga
              </label>
              <input
                type="text"
                id="harga"
                class="form-control bg-light"
                readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">
                Total
              </label>
              <input
                type="text"
                id="total"
                class="form-control bg-light"
                readonly>
            </div>
          </div>

          <button
            type="submit"
            name="update"
            class="btn btn-warning">
            Update
          </button>
          <a
            href="index.php"
            class="btn btn-danger">
            Kembali
          </a>
        </div>
      </div>
  </form>

  <script>
    const qty = document.getElementById("qty");
    const harga = document.getElementById("harga");
    const total = document.getElementById("total");

    let hargaAsli = <?= $produk['harga']; ?>;

    function rupiah(angka) {
      return "Rp " + Number(angka).toLocaleString("id-ID");
    }

    function hitung() {

      harga.value = rupiah(hargaAsli);

      total.value = rupiah(hargaAsli * qty.value);

    }

    qty.addEventListener("input", hitung);

    window.onload = hitung;
  </script>
  </form>
</div>
</div>
  <?php
  include '../layout/footer.php';
  ?>