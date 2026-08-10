<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
} 
  

include './koneksi.php';
include '../layout/header_user.php';

if (isset($_GET['search'])) {
  $search = $_GET['search'];

  $data = mysqli_query(
    $koneksi,
    "SELECT * FROM users 
      WHERE nama LIKE '%$search%'
      OR email LIKE'%$search%'"
  );
} else {
  $data = mysqli_query($koneksi, "SELECT * FROM users");
}
?>

<div class="container mt-5">
  <?php
  if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "tambah") {
  ?>

      <div class="alert alert-success alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        DATA BERHASIL DI TAMBAHKAN

        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="alert">
        </button>
      </div>

    <?php
    } elseif ($_GET['pesan'] == "edit") {
    ?>

      <div class="alert alert-warning alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3" role="alert">
        <i class="bi bi-pencil-circle-fill"></i>
        DATA BERHASIL DI UPDATE
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="alert">
        </button>
      </div>

    <?php
    } elseif ($_GET['pesan'] == "hapus") {
    ?>

      <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-trash-fill"></i>
        DATA BERHASIL DI HAPUS
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="alert">
        </button>
      </div>

  <?php
    }
  }
  ?>


  <div class="hero">
    <div class="hero-user-overlay">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex">

          <input class="form-control search-box"
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari nama..."
            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button class="btn btn-info ms-1">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <a href="tambah.php" class="btn btn-success ms-2">
          Tambah User
        </a>
      </div>
    </div>
  </div>




  <table class="table table-bordered table-hover">

    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($data)) { ?>

      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['email']; ?></td>

        <td>
          <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">
            Edit
          </a>

          <a href="hapus.php?id=<?php echo $row['id']; ?>"
            class="btn btn-hapus"
            onclick="return confirm('Yakin ingin menghapus data ini?')">
            Hapus
          </a>
        </td>
      </tr>

    <?php } ?>

  </table>
</div>

<?php include '../layout/footer.php'; ?>