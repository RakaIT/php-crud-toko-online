<?php
include 'koneksi.php';
include 'layout/header_login.php';
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    echo "
        <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
            <i class='bi bi-exclamation-triangle-fill me-2'></i>
            Email dan Password wajib diisi.
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
  } else {

    $cek = mysqli_query(
      $koneksi,
      "SELECT * FROM users WHERE email='$email'"
    );
    $user = mysqli_fetch_assoc($cek);

    if (!$user) {

      echo "
            <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
                <i class='bi bi-envelope-x-fill me-2'></i>
                Email tidak terdaftar.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
    } else {
      if ($password == $user['password']) {
        session_start();

        $_SESSION['login'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama']=$user['nama'];

        header("Location: index.php");
        exit;
      } else {

        echo "
    <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
        <i class='bi bi-lock-fill me-2'></i>
        Password salah.
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
      }
    }
  }
}
?>


<div class="container mt-5">
  <div class="container mt-5 form-page">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class=" card shadow-rounded -3">
          <div class="card-body">
            <h3 class="text-center mb-4">
              LOGIN
            </h3>
            <form action="" method="POST">
              <div class="mb-3">
                <label>Email</label>
                <input
                  type="email"
                  name="email"
                  class="form-control"required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input
                  type="password"
                  name="password"
                  class="form-control"required>
              </div>
              <button
                type="submit"
                name="login"
                class="btn btn-primary w-100">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-5"></div>
<?php include 'layout/footer.php'; ?>