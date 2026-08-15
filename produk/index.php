<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
}


include './koneksi.php';
include '../layout/header_produk.php';

$search = "";

$sort = isset($_GET['sort']) ? $_GET['sort'] : "terbaru";

if (isset($_GET['search'])) {
  $search = ($_GET['search']);
}

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $limit;

switch ($sort) {

  case "terlama":
    $order = "id ASC";
    break;

  case "murah":
    $order = "harga ASC";
    break;

  case "mahal":
    $order = "harga DESC";
    break;

  case "stok_banyak":
    $order = "stok DESC";
    break;

  case "stok_sedikit":
    $order = "stok ASC";
    break;

  default:
    $order = "id DESC";
}


$totalData = mysqli_query(
  $koneksi,
  "SELECT COUNT(*) AS total
      FROM produk
      WHERE nama_produk LIKE '%$search%'"
);

$total = mysqli_fetch_assoc($totalData);

$totalHalaman = ceil($total['total'] / $limit);

$data = mysqli_query(
  $koneksi,
  "SELECT *
      FROM produk
      WHERE nama_produk LIKE '%$search%'
      ORDER BY $order
      LIMIT $limit OFFSET $offset"
);

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
            <select name="sort" class="form-select ms-2" style="width:155px;">

              <option value="terbaru" <?= ($sort == "terbaru") ? "selected" : ""; ?>>
                Terbaru
              </option>

              <option value="terlama" <?= ($sort == "terlama") ? "selected" : ""; ?>>
                Terlama
              </option>

              <option value="murah" <?= ($sort == "murah") ? "selected" : ""; ?>>
                Harga Termurah
              </option>

              <option value="mahal" <?= ($sort == "mahal") ? "selected" : ""; ?>>
                Harga Termahal
              </option>

              <option value="stok_banyak" <?= ($sort == "stok_banyak") ? "selected" : ""; ?>>
                Stok Terbanyak
              </option>

              <option value="stok_sedikit" <?= ($sort == "stok_sedikit") ? "selected" : ""; ?>>
                Stok Tersedikit
              </option>

            </select>
          <button class="btn btn-info ms-1">
            <i class="bi bi-search"></i>
          </button>
        </form>
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
    <?php $no = $offset + 1;
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
  <nav>
    <ul class="pagination justify-content-center">

      <?php if ($page > 1) : ?>
        <li class="page-item">
          <a class="page-link"
            href="?page=<?= $page - 1; ?>&search=<?= $search; ?>">
            Previous
          </a>
        </li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalHalaman; $i++) : ?>

        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
          <a class="page-link"
            href="?page=<?= $i; ?>&search=<?= $search; ?>$sort=<?=$sort; ?>">
            <?= $i; ?>
          </a>
        </li>

      <?php endfor; ?>

      <?php if ($page < $totalHalaman) : ?>
        <li class="page-item">
          <a class="page-link"
            href="?page=<?= $page + 1; ?>&search=<?= $search; ?>">
            Next
          </a>
        </li>
      <?php endif; ?>

    </ul>
  </nav>
</div>

<?php include '../layout/footer.php'; ?>