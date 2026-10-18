<?php
require_once __DIR__ . '/config/paths.php';
session_start();
require_once __DIR__ . '/classes/User.php';

if(isset($_POST['login'])){

    $user = new User();

    $data = $user->login(
        $_POST['username'],
        $_POST['password']
    );

    if($data){
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'admin'){
            header('Location: admin/dashboard.php');
        } else {
            header('Location: sales/dashboard.php');
        }
    } else {
        $error = "Username atau Password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sales</title>
    <?= css_links('core.css', 'login.css') ?>

</head>
<body class="page-login">

<div class="login-bg-blur login-bg-blur--1" aria-hidden="true"></div>
<div class="login-bg-blur login-bg-blur--2" aria-hidden="true"></div>

<div class="login-container">
    <form method="POST" class="login-box">

        <h1>Sales Egar</h1>
        <p>Silahkan Login</p>

        <?php if(isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required>

        <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="Password" required>

        <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>

        <button type="submit" name="login">
            Login
        </button>
    </form>
</div>

<script src="<?= htmlspecialchars(asset_url('assets/js/script.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
</body>
</html>