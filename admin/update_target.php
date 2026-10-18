<?php
require_once '../config/Database.php';

$conn = (new Database())->connect();

$id = $_POST['id'];
$produk = $_POST['target_produk'];
$omset = $_POST['target_omset'];

mysqli_query($conn,
    "UPDATE users SET
     target_produk='$produk',
     target_omset='$omset'
     WHERE id='$id'");

header("Location: dashboard.php");
?>