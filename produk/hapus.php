<?php

include './koneksi.php';

$id = $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM produk
    WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

if (!mysqli_stmt_execute($stmt)) {
    die(mysqli_error($koneksi));
}

header("Location:index.php?pesan=hapus");
exit;