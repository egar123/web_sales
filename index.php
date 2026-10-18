<?php
require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/classes/Produk.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Penjualan.php';

$produk = new Produk();
$user = new User();
$penjualan = new Penjualan();

$totalProduk = $produk->totalProduk();
$totalKaryawan = $user->totalKaryawan();
$totalPenjualan = $penjualan->totalPenjualan();

$dataProduk = $produk->getAll();
$dataSales = $user->getSales();

$keyword = '';

if(isset($_GET['search'])){
    $keyword = $_GET['search'];
}

$dataProduk = $produk->search($keyword);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>egar sales</title>

    <?= css_links('core.css', 'landing.css') ?>

</head>
<body class="page-landing">

<!-- NAVBAR -->
<nav class="navbar">

    <div class="logo">
        Sales Egar
    </div>

    <div class="menu">
        <a href="#">Home</a>
        <a href="chatbot.php">Bantuan</a>
        <a href="login.php" class="nav-btn">Login</a>
    </div>

</nav>

<!-- HERO -->
<section class="landing-page">

    <div class="hero-text">

        <span class="badge">
            Sales Egar Management
        </span>

        <h1>
            Dashboard Sales
        </h1>

        <p>
            Sistem management penjualan elektronik dengan
            tampilan premium, cepat, responsive, dan modern
            untuk admin maupun sales perusahaan.
        </p>

        <div class="hero-button">
            <a href="login.php" class="btn-primary">
                Masuk Dashboard
            </a>

            <a href="#produk" class="btn-secondary">
                Lihat Produk
            </a>

            <a href="chatbot.php" class="btn-secondary">
                Chat Bantuan
            </a>
        </div>

    </div>

    <div class="hero-image">

        <div class="glass-card">
            <h3>Total Penjualan</h3>

            <span>
                Rp <?= number_format($totalPenjualan); ?>
            </span>
        </div>

        <div class="glass-card">
            <h3>Total Produk</h3>

            <span>
                <?= $totalProduk; ?>
            </span>
        </div>

        <div class="glass-card">
            <h3>Total Sales</h3>

            <span>
                <?= $totalKaryawan; ?>
            </span>
        </div>

    </div>

</section>

<!-- PRODUK -->
<section class="section" id="produk">

    <div class="section-title">
        <h2>Daftar Produk</h2>
        <p>Daftar terbaru</p>
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

    <h3>
        <?= $row['nama_produk']; ?>
    </h3>

    <p>
        Rp <?= number_format($row['harga']); ?>
    </p>

</div>

        <?php endwhile; ?>

    </div>

</section>

<!-- SALES -->
<section class="section">

    <div class="section-title">
        <h2>Tim Sales</h2>
        <p>Seluruh sales aktif</p>
    </div>

    <div class="employee-container">

        <?php while($sales = mysqli_fetch_assoc($dataSales)) : ?>

        <div class="employee-card">

            <h3>
                <?= $sales['nama']; ?>
            </h3>

            <p>
                <?= ucfirst($sales['role']); ?>
            </p>

            <span>
                Staff Active
            </span>

        </div>

        <?php endwhile; ?>

    </div>

</section>

<!-- FOOTER -->
<footer class="footer">
    <p>
        © 2026  Sales Egar Management System
    </p>
</footer>

</body>
</html>