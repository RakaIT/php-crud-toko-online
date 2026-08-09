<?php
include './koneksi.php';

$id = $_GET['id'];

$result = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

if (!$result) {
    die(mysqli_error($koneksi));
}

header("Location: index.php?pesan=hapus");
exit;