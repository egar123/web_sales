<?php
session_start();

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../classes/Produk.php';

$produk = new Produk();

$id = $_GET['id'];

$produk->hapus($id);

header('Location: dashboard.php');
?>