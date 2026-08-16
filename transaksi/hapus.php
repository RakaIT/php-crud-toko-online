<?php

include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "
SELECT *
FROM transaksi
WHERE id='$id'
");

$row = mysqli_fetch_assoc($data);
$produk_id = $row['produk_id'];
$qty = $row['qty'];

mysqli_query($koneksi, "
UPDATE produk
SET stok = stok + '$qty'
WHERE id='$produk_id'
");

mysqli_query($koneksi, "
DELETE FROM transaksi
WHERE id='$id'
");

echo "
<script>
alert('Transaksi berhasil dihapus');
document.location='index.php';
</script>

";
