<?php
session_start();

require_once '../config/Database.php';

$conn = (new Database())->connect();

if(isset($_POST['jual'])){

    $produk_id = $_POST['produk_id'];

    $qty = $_POST['qty'];

    $sales_id = $_SESSION['id'];

    // ambil produk
    $produk = mysqli_query($conn,
        "SELECT * FROM produk
         WHERE id='$produk_id'");

    $data = mysqli_fetch_assoc($produk);

    // cek produk
    if(!$data){
        die('Produk tidak ditemukan');
    }

    $harga = $data['harga'];

    $stok = $data['stok'];

    // cek stok
    if($qty > $stok){
        die('Stok tidak cukup');
    }

    $total = $harga * $qty;
    $komisi = $total * 0.04;

    // INSERT PENJUALAN
$insert = mysqli_query($conn,
    "INSERT INTO penjualan(
        produk_id,
        sales_id,
        qty,
        total,
        komisi,
        tanggal
    ) VALUES(
        '$produk_id',
        '$sales_id',
        '$qty',
        '$total',
        '$komisi',
        NOW()
    )");
    // cek insert gagal
    if(!$insert){

        die(mysqli_error($conn));
    }

    // update stok
    mysqli_query($conn,
        "UPDATE produk SET
         stok = stok - '$qty'
         WHERE id='$produk_id'");

    header('Location: dashboard.php');
}
?>