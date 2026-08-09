<?php
include './koneksi.php';
include '../layout/header_produk.php';

if (isset($_POST['simpan'])) {
  $nama_produk = $_POST['nama_produk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  mysqli_query(
    $koneksi,
    "INSERT INTO produk
        VALUES(
            NULL,
            '$nama_produk',
            '$harga',
            '$stok',
            NOW()
        )"
  );
  header("location: index.php?pesan=tambah");
  exit;
}
?>
<div class="container mt-5">
  <div class="container mt-5 form-page">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="mb-4">Tambah Produk</h2>

            <form action="" method="POST">
              <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control">
              </div>

              <button type="submit" name="simpan" class="btn btn-success">
                Simpan
              </button>
              <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../layout/footer.php' ?>