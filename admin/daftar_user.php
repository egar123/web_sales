<?php
session_start();
require_once __DIR__ . '/../config/paths.php';

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../config/Database.php';
require_once '../classes/Penjualan.php';

$penjualan = new Penjualan();

$db = new Database();
$conn = $db->connect();

$query = mysqli_query($conn,
    "SELECT * FROM users
     WHERE role != 'admin'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <?= css_links('core.css', 'dashboard.css') ?>
</head>
<body class="page-dashboard">

<div class="dashboard">

    <div class="sidebar">
        <div>
            <h2 class="logo">Admin Panel</h2>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="tambah_produk.php">Tambah Produk</a>
                <a href="tambah_user.php">Tambah Sales</a>
                <a href="daftar_user.php" class="active">Daftar User</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div class="main">

        <div class="topbar">
            <h1>Daftar User</h1>
            <p>Sales dan akun non-admin</p>
        </div>

        <div class="table-box">

            <div class="table-title">
                <h2>Data pengguna</h2>
            </div>

            <a href="dashboard.php" class="btn-back">← Kembali ke dashboard</a>

            <table>

                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Target Produk Bulanan</th>
                    <th>Target Omset bulanan</th>
                    <th>Komisi</th>
                    <th>Aksi</th>
                </tr>

                <?php $no = 1; ?>

                <?php while($row = mysqli_fetch_assoc($query)) : ?>

                <?php
                $targetProduk = $penjualan->targetProduk($row['id']);
                $targetOmset  = $penjualan->targetOmset($row['id']);

                $komisi = mysqli_fetch_assoc(mysqli_query($conn,
                    "SELECT SUM(komisi) as total
                     FROM penjualan
                     WHERE sales_id='{$row['id']}'"
                ))['total'] ?? 0;
                ?>

                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['role']; ?></td>
                    <td><?= $targetProduk; ?>%</td>
                    <td><?= $targetOmset; ?>%</td>
                    <td>Rp <?= number_format($komisi); ?></td>
                    <td>
                        <a href="hapus_user.php?id=<?= $row['id']; ?>"
                           class="btn-delete"
                           onclick="return confirm('Hapus user?')">
                           Delete
                        </a>
                    </td>
                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>
