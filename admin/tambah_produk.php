<?php
session_start();
require_once __DIR__ . '/../config/paths.php';

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../classes/Produk.php';
require_once '../classes/User.php';

$produk = new Produk();
$user = new User();

$dataSales = $user->getSales();

if(isset($_POST['submit'])){

    $namaFile = $_FILES['gambar']['name'];

    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/uploads/" . $namaFile
    );

    $produk->tambah(
        $_POST['nama_produk'],
        $_POST['harga'],
        $_POST['stok'],
        $_POST['sales_id'],
        $namaFile
    );

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>

    <?= css_links('core.css', 'forms.css') ?>

</head>
<body>

<div class="form-container">

    <form method="POST"
      enctype="multipart/form-data"
      class="premium-form">

        <h1>Tambah Produk</h1>
        <a href="dashboard.php" class="btn-back">← Kembali ke dashboard</a>


        <input type="file"
                name="gambar"
                required>

        <input type="text"
               name="nama_produk"
               placeholder="Nama Produk"
               required>

        <input type="number"
               name="harga"
               placeholder="Harga"
               required>

        <input type="number"
               name="stok"
               placeholder="Stok"
               required>

        <select name="sales_id" required>

            <option value="">
                Pilih Sales
            </option>
                <option value="">
                    Semua sales
                </option>

            <?php while($sales = mysqli_fetch_assoc($dataSales)) : ?>

            <option value="<?= $sales['id']; ?>">
                <?= $sales['nama']; ?>
            </option>

            <?php endwhile; ?>

        </select>

        <button type="submit" name="submit">
            Simpan Produk
        </button>

    </form>

</div>

</body>
</html>