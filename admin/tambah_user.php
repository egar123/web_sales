<?php
session_start();
require_once __DIR__ . '/../config/paths.php';

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();

if(isset($_POST['submit'])){

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

  $result = mysqli_query($conn,
    "INSERT INTO users (nama, username, password, role)
     VALUES ('$nama', '$username', '$password', '$role')"
);

if(!$result){
    die("Error SQL: " . mysqli_error($conn));
}

    header('Location: daftar_user.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>

    <?= css_links('core.css', 'forms.css') ?>

</head>
<body>

<div class="form-container">

    <form method="POST" class="premium-form">

        <h1>Tambah Sales</h1>
        <a href="dashboard.php" class="btn-back">← Kembali ke dashboard</a>

        <input type="text"
               name="nama"
               placeholder="Nama"
               required>

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <select name="role">

            <option value="sales">
                Sales
            </option>

        </select>

        <button type="submit" name="submit">
            Tambah User
        </button>

    </form>

</div>

</body>
</html>