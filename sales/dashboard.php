<?php
require_once __DIR__ . '/../config/paths.php';
session_start();

if($_SESSION['role'] != 'sales'){
    header('Location: ../login.php');
}

require_once '../classes/Produk.php';
require_once '../classes/Penjualan.php';
require_once '../classes/KomisiTransfer.php';

$produk = new Produk();
$penjualan = new Penjualan();
$komisiTransfer = new KomisiTransfer();

$sales_id = $_SESSION['id'];

$dataProduk = $produk->getBySales($sales_id);
$transaksiHariIni = $penjualan->transaksiHariIni($sales_id);
$totalBulanan = $penjualan->totalBulanan($sales_id);
$totalKomisi = $penjualan->totalKomisiBulanan($sales_id);
$targetProduk = $penjualan->targetProduk($sales_id);
$targetOmset = $penjualan->targetOmset($sales_id);

$totalKomisiSudahTf = $komisiTransfer->totalDitransfer($sales_id);
$sisaKomisiBelumTf = $komisiTransfer->sisaKomisi($sales_id);

$riwayatTfRows = [];
$rqTf = $komisiTransfer->riwayatSales($sales_id, 15);
while($rTf = mysqli_fetch_assoc($rqTf)){
    $riwayatTfRows[] = $rTf;
}

$keyword = '';

if(isset($_GET['search'])){
    $keyword = $_GET['search'];
}

$dataProduk = $produk->searchSales($sales_id,$keyword);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>

    <?= css_links('core.css', 'dashboard.css') ?>

</head>
<body class="page-dashboard">

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div>

            <h2 class="logo">
                Sales Egar
            </h2>

            <div class="menu">
                <a href="dashboard.php" class="active">
                    Dashboard
                </a>

                <a href="transaksi.php">
                    Transaksi
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

            <div>
                <h1>Halo, <?= $_SESSION['nama']; ?></h1>
                <p>Selamat datang di dashboard sales Egar</p>
            </div>

        </div>

        <?php if(!empty($_SESSION['flash_transfer'])): ?>
        <div class="<?= !empty($_SESSION['flash_transfer_ok']) ? 'flash-ok' : 'flash-err'; ?>">
            <?= htmlspecialchars($_SESSION['flash_transfer'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php
            unset($_SESSION['flash_transfer'], $_SESSION['flash_transfer_ok']);
        endif;
        ?>

        <div class="card-container">

            <div class="card">
                <h3>Transaksi Hari Ini</h3>

                <span>
                    <?= $transaksiHariIni; ?>
                </span>
            </div>

            <div class="card">
                <h3>Total Bulanan</h3>

                <span>
                    Rp <?= number_format($totalBulanan); ?>
                </span>
            </div>


            <div class="card">
                <h3>Target Produk</h3>
                <span><?= $targetProduk; ?>%</span>
            </div>

            <div class="card">
                <h3>Target Omset</h3>
                <span><?= $targetOmset; ?>%</span>
            </div>

            <div class="card">
                <h3>Komisi Saya</h3>

                <span>
                    Rp <?= number_format($totalKomisi); ?>
                </span>
            </div>

            <div class="card">
                <h3>Gaji / TF terkirim</h3>

                <span>
                    Rp <?= number_format($totalKomisiSudahTf); ?>
                </span>
            </div>

            <div class="card">
                <h3>Komisi belum ditransfer</h3>

                <span>
                    Rp <?= number_format($sisaKomisiBelumTf); ?>
                </span>
            </div>

        </div>

        <div class="tf-box">
            <h2>Transfer komisi ke Admin</h2>
            <p>Catat nominal yang sudah Anda transfer ke rekening atasan. Maksimal sesuai komisi yang belum ditransfer.</p>

            <?php if($sisaKomisiBelumTf <= 0): ?>
            <p class="text-muted">Saat ini tidak ada komisi yang bisa dilaporkan ditransfer (sudah habis atau belum ada penjualan).</p>
            <?php else: ?>
            <form method="POST" action="proses_transfer_komisi.php" class="tf-form">

                <label>
                    Nominal (Rp)
                    <input type="number"
                           name="nominal"
                           min="1"
                           step="1"
                           max="<?= (int) floor($sisaKomisiBelumTf); ?>"
                           required
                           placeholder="Jumlah TF">
                </label>

                <label>
                    Penerima
                    <select name="penerima" required>
                        <option value="admin">Admin</option>
                    </select>
                </label>

                <button type="submit" name="kirim_transfer" value="1">
                    Simpan laporan TF
                </button>
            </form>
            <?php endif; ?>
        </div>

        <?php if(count($riwayatTfRows) > 0): ?>
        <div class="table-box">
            <div class="table-title">
                <h2>Riwayat transfer komisi</h2>
            </div>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Ke</th>
                </tr>
                <?php foreach($riwayatTfRows as $tr): ?>
                <tr>
                    <td><?= htmlspecialchars($tr['tanggal'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>Rp <?= number_format((float) $tr['nominal']); ?></td>
                    <td><?= ($tr['penerima'] ?? '') === 'boss' ? 'Boss' : 'Admin'; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <!-- PRODUK -->
<!-- PRODUK -->
<div class="table-box">

    <div class="table-title">
        <h2>Produk Sales</h2>
    </div>

    <form method="GET" class="search-box">

    <input type="text"
           name="search"
           placeholder="Cari produk elektronik..."
           value="<?= $keyword; ?>">

    <button type="submit">
        Search
    </button>

</form>

    <div class="product-grid">

        <?php while($row = mysqli_fetch_assoc($dataProduk)) : ?>

        <div class="product-card">

            <img src="<?= htmlspecialchars(asset_url('assets/uploads/' . $row['gambar']), ENT_QUOTES, 'UTF-8') ?>"
                 class="product-img">

    <div class="product-content">

    <form method="POST" action="proses_transaksi.php">

        <input type="hidden"
               name="produk_id"
               value="<?= $row['id']; ?>">

        <h3>
            <?= $row['nama_produk']; ?>
        </h3>

        <p>
            Stok : <?= $row['stok']; ?>
        </p>

        <span>
            Rp <?= number_format($row['harga']); ?>
        </span>

        <input type="number"
               name="qty"
               placeholder="Jumlah Terjual"
               min="1"
               max="<?= $row['stok']; ?>"
               required
               class="qty-input">

        <button type="submit"
                name="jual"
                class="btn-jual">

            ✔ Simpan Penjualan

        </button>

    </form>

</div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

    </div>

</div>

</body>
</html>