<?php

include './koneksi.php';
include '../layout/header_produk.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");

$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
  $nama_produk = $_POST['nama_produk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  $cek = mysqli_query(
    $koneksi,
    "SELECT * FROM nama_produk
              WHERE harga='$nama_produk'
              AND stok != '$stok'"
  );

  $sql = "UPDATE produk
                    SET nama_produk='$nama_produk',
                        harga='$harga',
                        stok='$stok'
                    WHERE id ='$id'";


  if (!mysqli_query($koneksi, $sql)) {
    die(mysqli_error($koneksi));
  }

  header("Location: index.php?pesan=edit");
  exit;
}


?>
<div class="container mt-5">
  <div class="container mt-5 form-page">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">

        </div>
      </div>
    </div>
    <h2>UPDATE PRODUK</h2>
    <form method="POST">
      <div class="card shadow">
        <div class="card-body">

          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text"
              name="nama_produk"
              class="form-control" required
              value="<?php echo $row['nama_produk']; ?>">
          </div>
          <div class="mb-3">
            <label>Harga Produk</label>
            <input type="number"
              name="harga"
              class="form-control" required
              value="<?php echo $row['harga']; ?>">
          </div>
          <div class="mb-3">
            <label>Stok Produk</label>
            <input
              type="number"
              name="stok"
              class="form-control" required
              value="<?php echo $row['stok']; ?>">
          </div>

          <button type="submit" name="update" class="btn btn-warning btn-sm">
            Update
          </button>
          <a href="index.php" class="btn btn-secondary btn-sm">
            Kembali
          </a>
    </form>
  </div>
</div>
</div>
</div>
<<?php include '../layout/footer.php' ?>