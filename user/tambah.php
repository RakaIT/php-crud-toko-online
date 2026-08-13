<?php
include './koneksi.php';
include '../layout/header_user.php';

if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  if (empty($nama) || empty($email) || empty($password)) {

    echo "
<div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
    <i class='bi bi-exclamation-triangle-fill me-2'></i>
    Nama, Email dan password wajib diisi.
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
</div>";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "
      <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
      <i class='bi bi-envelope-x-fill me-2'></i>
      Format Email Tidak Valid.
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
  } elseif (strlen($password) < 8) {

    echo "
    <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
        <i class='bi bi-lock-fill me-2'></i>
        Password minimal 8 karakter.
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
  } else {
    $cek = mysqli_query(
      $koneksi,
      "SELECT * FROM users WHERE email='$email'"
    );
    if (mysqli_num_rows($cek) > 0) {

      echo "
    <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
            <i class='bi bi-envelope-fill me-2'></i>
            Email sudah terdaftar.
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    } else {

      $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO users (nama, email, password)
    VALUES (?, ?, ?)"
      );

      mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $nama,
        $email,
        $password
      );

      if (!mysqli_stmt_execute($stmt)) {
        die(mysqli_error($koneksi));
      }

      header("location: index.php?pesan=tambah");
      exit;
    }
  }
}
?>
<div class="container mt-5">
  <div class="container mt-5 form-page">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="mb-4">Tambah User</h2>

            <form action="" method="POST">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
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