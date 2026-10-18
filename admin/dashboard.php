<?php
session_start();
require_once __DIR__ . '/../config/paths.php';

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
}

require_once '../classes/Produk.php';
require_once '../classes/User.php';
require_once '../classes/Penjualan.php';
require_once '../classes/KomisiTransfer.php';

$produk = new Produk();
$user = new User();
$penjualan = new Penjualan();
$komisiTransfer = new KomisiTransfer();

$totalProduk = $produk->totalProduk();

$totalKaryawan = $user->totalKaryawan();

$totalPenjualan = $penjualan->totalPenjualan();

$salesSudahLaporGajiBulanIni = $komisiTransfer->jumlahSalesSudahTransferBulanIni();
$totalTfKomisiBulanIni = $komisiTransfer->totalNominalTransferBulanIni();

$riwayatTfAdminRows = [];
$rqAdm = $komisiTransfer->riwayatAdmin(80);
while($rAdm = mysqli_fetch_assoc($rqAdm)){
    $riwayatTfAdminRows[] = $rAdm;
}

$dataSales = $user->getSales();
$dataProduk = $produk->getAllWithSales();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <?= css_links('core.css', 'dashboard.css') ?>

</head>
<body class="page-dashboard">

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>

            <h2 class="logo">
                Admin Panel
            </h2>

            <div class="menu">

                <a href="dashboard.php" class="active">
                    Dashboard
                </a>

                <a href="tambah_produk.php">
                    Tambah Produk
                </a>

                <a href="tambah_user.php">
                    Tambah Sales
                </a>

                <a href="daftar_user.php">
                    Daftar User
                </a>

                <a href="../chatbot.php">
                    Bantuan Chat
                </a>

                <a href="../logout.php">
                    Logout
                </a>

            </div>

        </div>

    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">

            <h1>
                Selamat Datang Admin
            </h1>

        </div>

        <!-- CARD -->
        <div class="card-container">

            <div class="card">

                <h3>Total Produk</h3>

                <span>
                    <?= $totalProduk; ?>
                </span>

            </div>

            <div class="card">

                <h3>Total Karyawan</h3>

                <span>
                    <?= $totalKaryawan; ?>
                </span>

            </div>

            <div class="card">

                <h3>Total Penjualan</h3>

                <span>
                    Rp <?= number_format($totalPenjualan); ?>
                </span>

            </div>

            <div class="card">

                <h3>Sales sudah lapor gaji (bulan ini)</h3>

                <span>
                    <?= (int) $salesSudahLaporGajiBulanIni; ?>
                </span>

            </div>

            <div class="card">

                <h3>Total TF komisi (bulan ini)</h3>

                <span>
                    Rp <?= number_format($totalTfKomisiBulanIni); ?>
                </span>

            </div>

        </div>

        <div class="table-box">

            <div class="table-title">
                <h2>Riwayat transfer komisi (gaji) sales</h2>
            </div>

            <?php if(count($riwayatTfAdminRows) === 0): ?>
            <p class="text-muted">Belum ada laporan transfer komisi dari sales.</p>
            <?php else: ?>
            <table>

                <tr>
                    <th>Tanggal</th>
                    <th>Sales</th>
                    <th>Username</th>
                    <th>Nominal</th>
                    <th>Ke</th>
                </tr>

                <?php foreach($riwayatTfAdminRows as $tr): ?>

                <tr>

                    <td><?= htmlspecialchars($tr['tanggal'], ENT_QUOTES, 'UTF-8'); ?></td>

                    <td><?= htmlspecialchars($tr['nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                    <td><?= htmlspecialchars($tr['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                    <td>Rp <?= number_format((float) $tr['nominal']); ?></td>

                    <td><?= ($tr['penerima'] ?? '') === 'boss' ? 'Boss' : 'Admin'; ?></td>

                </tr>

                <?php endforeach; ?>

            </table>
            <?php endif; ?>

        </div>

        <!-- TABLE PRODUK -->
<div class="table-box">

    <div class="table-title">
        <h2>Daftar Semua Produk</h2>
    </div>

    <table>

        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Sales</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>

        <?php while($row = mysqli_fetch_assoc($dataProduk)) : ?>

        <tr>

            <td>
                <?= $no++; ?>
            </td>

            <td>

                <img src="<?= htmlspecialchars(asset_url('assets/uploads/' . $row['gambar']), ENT_QUOTES, 'UTF-8') ?>"
                     width="70"
                     height="70"
                     class="table-thumb"
                     alt="">

            </td>

            <td>
                <?= $row['nama_produk']; ?>
            </td>

            <td>
                Rp <?= number_format($row['harga']); ?>
            </td>

            <td>
                <?= $row['stok']; ?>
            </td>

            <td>

                <?php
                if($row['nama']){
                    echo $row['nama'];
                } else {
                    echo "Produk Umum";
                }
                ?>

            </td>

                       <td>

                            <a href="edit_produk.php?id=<?= $row['id']; ?>"
                            class="btn-edit">

                            Edit

                            </a>

                            <a href="hapus_produk.php?id=<?= $row['id']; ?>"
                            onclick="return confirm('Hapus produk?')"
                            class="btn-delete">

                            Delete

                            </a>

                        </td>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<div class="table-box">

    <div class="table-title">
        <h2>Target Bulanan Sales</h2>
    </div>

    <table>

        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Target dan omset Bulanan</th>
        </tr>

        <?php
        $sales = $user->getSales();
        while($row = mysqli_fetch_assoc($sales)) :
        ?>

        <tr>

            <td><?= $row['nama']; ?></td>

            <td><?= $row['username']; ?></td>

            <td>

            <form method="POST" action="update_target.php">

                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <!-- TARGET PRODUK -->
                <input type="number"
                    name="target_produk"
                    value="<?= $row['target_produk'] ?? 50; ?>"
                    placeholder="Target Produk">

                <!-- TARGET OMSET -->
                <input type="number"
                    name="target_omset"
                    value="<?= $row['target_omset'] ?? 50000000; ?>"
                    placeholder="Target Omset">

                <button type="submit">Save</button>

            </form>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>
    </div>

</div>

</body>
</html>