<?php
include 'koneksi.php';
include '../layout/header_transaksi.php';

$data_produk = mysqli_query($koneksi, "SELECT * FROM produk");

if (isset($_POST['simpan'])) {
  $produk_id = $_POST['produk_id'];
  $qty = $_POST['qty'];

  $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$produk_id'");
  $produk = mysqli_fetch_assoc($queryProduk);

  $harga = $produk['harga'];
  $total = $harga * $qty;

mysqli_query($koneksi, "
INSERT INTO transaksi
(produk_id, qty, total)
VALUES
('$produk_id','$qty','$total')
");
echo "

<script>

alert('Transaksi Berhasil');

document.location.href='index.php';

</script>

";
}


?>
<div class="container col-lg-8 mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-5">
      <h1 class="fw-bold mb-4">
        <i class="bi bi-cart-plus"></i>
        TAMBAH TRANSAKSI
      </h1>

      <form method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">
              Produk
            </label>

            <select id="produk" name="produk_id" class="form-select">
              <option value="">
                -- Pilih Produk --
              </option>
              <?php while ($produk = mysqli_fetch_assoc($data_produk)) { ?>

                <option
                  value="<?= $produk['id']; ?>"
                  data-harga="<?= $produk['harga']; ?>">
                  <?= $produk['nama_produk']; ?>
                </option>
              <?php } ?>
            </select>

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
              placeholder="Masukkan Qty">

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
        <div class="d-flex gap-2 mt-4">
          <button
            type="submit"
            name="simpan"
            class="btn btn-success">
            <i class="bi bi-floppy"></i>
            Simpan
          </button>
          <a href="index.php" class="btn btn-danger">
            <i class="bi bi-arrow-return-left"></i>
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const produk = document.getElementById("produk");
  const harga = document.getElementById("harga");
  const qty = document.getElementById("qty");
  const total = document.getElementById("total");

  let hargaAsli = 0;

  // Format Rupiah
  function formatRupiah(angka) {

    return "Rp" + Number(angka).toLocaleString("id-ID");

  }

  // Hitung Total
  function hitungTotal() {

    let jumlah = parseInt(qty.value) || 0;

    total.value = formatRupiah(hargaAsli * jumlah);

  }

  // Saat memilih produk
  produk.addEventListener("change", function() {

    let selected = this.options[this.selectedIndex];

    hargaAsli = parseInt(selected.dataset.harga) || 0;

    harga.value = formatRupiah(hargaAsli);

    hitungTotal();

  });

  // Saat Qty berubah
  qty.addEventListener("input", function() {

    hitungTotal();

  });
</script>
<?php
include '../layout/footer.php';
?>