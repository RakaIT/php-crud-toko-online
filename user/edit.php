<?php

include './koneksi.php';
include '../layout/header_user.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM Users WHERE id='$id'");

$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nama = ($_POST['nama']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);

    // Validasi
    if (empty($nama) || empty($email)) {

        echo "
        <div class='alert alert-warning alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
            Nama dan Email wajib diisi.
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "
        <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
            Format Email Tidak Valid.
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    } elseif (!empty($password) && strlen($password) < 8) {

        echo "
        <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
            Password minimal 8 karakter.
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    } else {

        // Cek email yang sama
        $cek = mysqli_query(
            $koneksi,
            "SELECT * FROM users
            WHERE email='$email'
            AND id != '$id'"
        );

        if (mysqli_num_rows($cek) > 0) {

            echo "
            <div class='alert alert-danger alert-dismissible fade show w-50 mx-auto shadow-sm rounded-3' role='alert'>
                Email sudah terdaftar.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
        } else {

            // PASSWORD DIISI
            if (!empty($password)) {

                $password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = mysqli_prepare(
                    $koneksi,
                    "UPDATE users
                    SET nama = ?, email = ?, password = ?
                    WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "sssi",
                    $nama,
                    $email,
                    $password,
                    $id
                );
            }

            // PASSWORD KOSONG
            else {

                $stmt = mysqli_prepare(
                    $koneksi,
                    "UPDATE users
                    SET nama = ?, email = ?
                    WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssi",
                    $nama,
                    $email,
                    $id
                );
            }

            if (!mysqli_stmt_execute($stmt)) {
                die(mysqli_error($koneksi));
            }

            header("Location: index.php?pesan=edit");
            exit;
        }
    }
}


?>
<div class="container mt-5">
    <div class="container mt-5 form-page">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">

                </div>
            </div>
        </div>
        <h2>Edit Users</h2>
        <form method="POST">
            <div class="card shadow">
                <div class="card-body">

                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text"
                            name="nama"
                            class="form-control" required
                            value="<?php echo $row['nama']; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            class="form-control" required
                            value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan Jika Tidak Ingin Mengubah Password !!">
                    </div>

                    <button type="submit" name="update" class="btn btn-warning btn-sm">
                        Update
                    </button>
                    <a href="index.php" class="btn btn-danger btn-sm">
                        Kembali
                    </a>
        </form>
    </div>
</div>
</div>
</div>
<<?php include '../layout/footer.php' ?>