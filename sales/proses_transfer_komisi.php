<?php
session_start();

if($_SESSION['role'] != 'sales'){
    header('Location: ../login.php');
    exit;
}

require_once '../classes/KomisiTransfer.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['kirim_transfer'])){
    header('Location: dashboard.php');
    exit;
}

$nominal = isset($_POST['nominal']) ? (float) str_replace(',', '.', $_POST['nominal']) : 0;
$penerima = isset($_POST['penerima']) ? $_POST['penerima'] : 'admin';

$kt = new KomisiTransfer();
$res = $kt->simpan($_SESSION['id'], $nominal, $penerima);

$_SESSION['flash_transfer'] = $res['msg'];
$_SESSION['flash_transfer_ok'] = $res['ok'];

header('Location: dashboard.php');
exit;
