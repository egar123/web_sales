<?php
require_once __DIR__ . '/../config/paths.php';
session_start();

if($_SESSION['role'] != 'sales'){
    header('Location: ../login.php');
}

require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();

$sales_id = $_SESSION['id'];

$query = mysqli_query($conn,
    "SELECT penjualan.*, produk.nama_produk
     FROM penjualan
     JOIN produk
     ON penjualan.produk_id = produk.id
     WHERE penjualan.sales_id='$sales_id'
     ORDER BY penjualan.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Sales</title>

    <?= css_links('core.css', 'dashboard.css') ?>

</head>
<body class="page-dashboard">

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>
            <h2 class="logo">Sales Egar</h2>

            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="transaksi.php" class="active">Transaksi</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h1>Data Transaksi</h1>
        </div>

        <div class="table-box">

            <div class="table-title">
                <h2>Riwayat penjualan</h2>
            </div>

            <table>

                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($query)) : ?>

                <tr>

                    <td>
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= $row['nama_produk']; ?>
                    </td>

                    <td>
                        <?= $row['qty']; ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['total']); ?>
                    </td>

                    <td>
                        <?= $row['tanggal']; ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>