<?php
session_start();

require_once __DIR__ . '/../config/paths.php';

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../classes/Produk.php';

$produk = new Produk();

$id = $_GET['id'];

$data = $produk->getById($id);


if(isset($_POST['update'])){

    $gambar = '';

    // upload gambar baru
    if($_FILES['gambar']['name']){

        $gambar = $_FILES['gambar']['name'];

        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file(
            $tmp,
            "../assets/uploads/" . $gambar
        );
    }

    $produk->update(
        $id,
        $_POST['nama_produk'],
        $_POST['harga'],
        $_POST['stok'],
        $gambar
    );

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>

    <?= css_links('core.css', 'forms.css') ?>

</head>

<body>

<div class="form-container">

    <form method="POST"
          enctype="multipart/form-data"
          class="premium-form">

        <a href="dashboard.php" class="btn-back">
            ← Kembali
        </a>

        <h1>Edit Produk</h1>

        <img src="../assets/uploads/<?= $data['gambar']; ?>"
             width="120"
             style="
                border-radius:16px;
                margin:0 auto 10px;
                display:block;
                object-fit:cover;
             ">

        <input type="file" name="gambar">

        <input type="text"
               name="nama_produk"
               value="<?= $data['nama_produk']; ?>"
               placeholder="Nama Produk"
               required>

        <input type="number"
               name="harga"
               value="<?= $data['harga']; ?>"
               placeholder="Harga Produk"
               required>

        <input type="number"
               name="stok"
               value="<?= $data['stok']; ?>"
               placeholder="Stok Produk"
               required>

        <button type="submit" name="update">
            Update Produk
        </button>

    </form>

</div>

</body>
</html>