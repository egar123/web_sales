<?php
session_start();

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../classes/User.php';

$user = new User();

$id = $_GET['id'];

$user->hapus($id);

header('Location: daftar_user.php');
?>