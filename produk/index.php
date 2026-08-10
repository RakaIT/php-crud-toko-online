<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
}


include './koneksi.php';
include '../layout/header_produk.php';

if (isset($_GET['search'])) {
  $search = $_GET['search'];

  $data = mysqli_query(
    $koneksi,
    "SELECT * FROM produk 
      WHERE nama_produk LIKE '%$search%'"
  );
} else {
  $data = mysqli_query($koneksi, "SELECT * FROM produk");
}
?>

<div class="container mt-5">
  <?php
  if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "tambah") {
  ?>
      <div class="alert alert-success alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        Produk berhasil ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php
    } elseif ($_GET['pesan'] == "edit") {
    ?>

      <div class="alert alert-warning alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3" role="alert">
        <i class="bi bi-pencil-circle-fill"></i>
        PRODUK BERHASIL DI UBAH
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
        PRODUK BERHASIL DI HAPUS
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


  <div class="hero-produk">
    <div class="hero-produk-overlay">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex">

          <input class="form-control search-box"
            type="text"
            name="search"
            placeholder="Cari Produk..."
            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button class="btn btn-info ms-1">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <a href="tambah.php" class="btn btn-success ms-2">
          Tambah Produk
        </a>
      </div>
    </div>
  </div>




  <table class="table table-bordered table-hover">

    <tr>
      <th>NO</th>
      <th>Gambar</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Aksi</th>
    </tr>
    <?php  $no = 1;
      while ($row = mysqli_fetch_assoc($data)) { ?>
      <td><?= $no++; ?></td>
      <td>
        <img
          src="../assets/upload/<?= $row['gambar']; ?>"
          width="90"
          height="90"
          style="object-fit:cover;border-radius:10px;">
      </td>
      <td><?= $row['nama_produk']; ?></td>
      <td>Rp<?= number_format($row['harga']); ?></td>
      <td><?= $row['stok']; ?>
    </td>
        <td>
          <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">
            Edit
          </a>

          <a href="hapus.php?id=<?php echo $row['id']; ?>"
            class="btn btn-hapus"
            onclick="return confirm('Yakin ingin menghapus produk ini?')">
            Hapus
          </a>
        </td>
      </tr>

    <?php } ?>

  </table>
</div>

<?php include '../layout/footer.php'; ?>