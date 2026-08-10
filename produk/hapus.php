<?php

include './koneksi.php';

$id = $_GET['id'];

// Ambil data produk
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

// Hapus gambar jika ada
if (!empty($row['gambar'])) {
    $path = "../assets/upload/" . $row['gambar'];

    if (file_exists($path)) {
        unlink($path);
    }
}

// Hapus data produk
mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");

// Kembali ke halaman produk
header("Location: index.php?pesan=hapus");
exit;