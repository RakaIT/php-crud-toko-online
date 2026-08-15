<?php
include './koneksi.php';
include '../layout/header_produk.php';

if (isset($_POST['simpan'])) {
  $nama_produk = $_POST['nama_produk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $gambar = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $ukuran = $_FILES['gambar']['size'];

  //maksimal 2mb
  if ($ukuran  > 2 * 1024 * 1024) {
    echo "
    <script>
        alert('Ukuran Gambar Maksimal 2 MB!');
        window.history.back();
        </script>";
    exit;
  }

  // Ambil ekstensi file
  $ekstensi = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

  // Format yang diizinkan
  $format = ['jpg', 'jpeg', 'png'];

  // Cek format
  if (!in_array($ekstensi, $format)) {
    echo "
    <script>
        alert('Format gambar harus JPG, JPEG, atau PNG!');
        window.history.back();
    </script>";
    exit;
  }
  // buat gambar baru 
  $nama_baru = uniqid() . '.' . $ekstensi;

  // Upload gambar
  move_uploaded_file(
    $tmp,
    "../assets/upload/" . $nama_baru
  );

  $stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO produk
        (
            nama_produk,
            harga,
            stok,
            gambar,
            created_at
        )
        VALUES
        (
            ?,?,?,?, NOW()
        )"
  );
  mysqli_stmt_bind_param(
    $stmt,
    "siis",
    $nama_produk,
    $harga,
    $stok,
    $nama_baru
  );
  if (!mysqli_stmt_execute($stmt)) {
    die(mysqli_error($koneksi));
  }
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

            <form action="" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
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
                <i class=" bi bi-floppy-fill"></i>
                Simpan
              </button>
              <a href="index.php" class="bi bi-box-arrow-left btn btn-danger">Kembali</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../layout/footer.php' ?>