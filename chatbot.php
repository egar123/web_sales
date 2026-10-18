<?php
declare(strict_types=1);
/**
 * Halaman bantuan Sales Egar — satu file (HTML + CSS + JS + basis pengetahuan).
 */

$intro = <<<'TXT'
**Sales Egar** adalah sistem manajemen penjualan elektronik untuk admin dan tim sales.

**Ringkasan fitur web ini:**
- **Beranda (`index.php`)**: statistik total penjualan, jumlah produk & sales, daftar produk dengan pencarian, dan profil tim sales.
- **Login**: masuk dengan username/password; peran **admin** ke panel admin, **sales** ke dashboard sales.
- **Admin — Dashboard**: ringkasan bisnis, tabel produk (edit/hapus), set **target bulanan** per sales (produk & omset), pantau **transfer komisi** sales ke admin.
- **Admin — Produk**: tambah produk (gambar, harga, stok, penugasan ke sales tertentu atau semua), edit produk.
- **Admin — User**: tambah akun sales, daftar user non-admin dan hapus user.
- **Sales — Dashboard**: ringkasan transaksi & omset, progres target, **catat penjualan** per produk (qty), **lapor transfer komisi**, riwayat transfer, pencarian produk.
- **Sales — Transaksi**: riwayat penjualan Anda (produk, qty, total, tanggal).

Saya menjawab dari kata kunci. Gunakan tombol saran di bawah atau ketik pertanyaan singkat.
TXT;

$hints = [
    'Apa saja fitur web ini?',
    'Cara login admin dan sales',
    'Bagaimana sales mencatat penjualan?',
    'Apa itu transfer komisi?',
    'Bagaimana admin set target sales?',
];

$pairs = [
    ['keys' => ['fitur', 'apa', 'saja', 'web', 'lengkap', 'sistem', 'aplikasi'], 'answer' => $intro],
    ['keys' => ['apa', 'sales', 'egar', 'sistem', 'ini'], 'answer' => '**Sales Egar** adalah sistem manajemen penjualan elektronik: admin mengatur produk, user, dan target; sales mencatat penjualan dan melapor transfer komisi.'],
    ['keys' => ['login', 'masuk', 'dashboard', 'akun'], 'answer' => 'Buka **Login** dari menu beranda. Setelah sukses: peran **admin** ke `admin/dashboard.php`, peran **sales** ke `sales/dashboard.php`.'],
    ['keys' => ['admin', 'sales', 'beda', 'role', 'peran'], 'answer' => '**Admin** mengelola master data produk, user sales, target bulanan, dan melihat laporan transfer komisi. **Sales** hanya melihat produk yang ditugaskan, mencatat penjualan, dan melapor transfer komisi.'],
    ['keys' => ['produk', 'cari', 'search', 'stok', 'beranda'], 'answer' => 'Di **index.php** ada daftar produk publik. Kotak pencarian memakai parameter URL `search` untuk menyaring nama produk.'],
    ['keys' => ['salah', 'error', 'gagal', 'password', 'username'], 'answer' => 'Pesan error login berarti username/password tidak cocok. Pastikan caps lock dan data dari admin benar.'],
    ['keys' => ['target', 'omset', 'produk', 'persen', 'admin'], 'answer' => 'Di **admin dashboard**, tabel **Target Bulanan Sales**: isi target produk & target omset lalu **Save** — data diproses lewat `update_target.php`; sales melihat progres persentase di dashboard mereka.'],
    ['keys' => ['edit', 'hapus', 'produk', 'aksi', 'admin'], 'answer' => 'Di tabel produk admin: **Edit** membuka `edit_produk.php`, **Delete** menghapus via `hapus_produk.php` (biasanya dengan konfirmasi).'],
    ['keys' => ['komisi', 'transfer', 'bulan', 'admin', 'pantau'], 'answer' => 'Admin melihat berapa sales yang sudah melapor transfer komisi dan total nominal bulan berjalan di dashboard admin.'],
    ['keys' => ['sidebar', 'menu', 'navigasi', 'admin'], 'answer' => 'Menu admin: Dashboard, Tambah Produk, Tambah Sales, Daftar User, Logout — ditambah tautan **Bantuan** ke halaman ini.'],
    ['keys' => ['gambar', 'foto', 'upload', 'file', 'produk'], 'answer' => 'Saat **tambah/edit produk**, unggah gambar; file disimpan di folder uploads dan tampil di kartu produk untuk sales.'],
    ['keys' => ['sales', 'dropdown', 'semua', 'umum', 'penugasan'], 'answer' => 'Saat tambah produk: pilih sales tertentu agar produk hanya untuk sales itu, atau **Semua sales** untuk produk umum.'],
    ['keys' => ['stok', 'harga', 'nama', 'edit'], 'answer' => 'Perubahan di edit produk langsung mempengaruhi kartu di dashboard sales dan batas qty saat mencatat penjualan.'],
    ['keys' => ['password', 'hash', 'user', 'baru'], 'answer' => 'Password user disimpan ter-hash di database (sesuai implementasi aplikasi). Bagikan kredensial dengan aman ke user baru.'],
    ['keys' => ['hapus', 'delete', 'user', 'daftar'], 'answer' => 'Hapus user dari daftar memakai `hapus_user.php` dengan konfirmasi browser.'],
    ['keys' => ['jual', 'penjualan', 'qty', 'simpan', 'sales'], 'answer' => 'Di **sales dashboard**, pada kartu produk: isi **qty** lalu **Simpan Penjualan** — POST ke `proses_transaksi.php` yang mengurangi stok dan menambah data penjualan.'],
    ['keys' => ['komisi', 'transfer', 'lapor', 'nominal', 'sales'], 'answer' => 'Form **Transfer komisi** di dashboard sales mencatat nominal yang sudah Anda transfer ke rekening admin. Maksimal sesuai komisi yang belum dilaporkan.'],
    ['keys' => ['target', 'card', 'persen', 'sales'], 'answer' => 'Persentase target dihitung dari penjualan Anda dibanding target yang di-set admin.'],
    ['keys' => ['cari', 'search', 'filter', 'sales', 'produk'], 'answer' => 'Kotak pencarian di dashboard sales memfilter produk yang ditugaskan ke Anda.'],
    ['keys' => ['urut', 'terbaru', 'tanggal', 'transaksi'], 'answer' => 'Halaman **Transaksi** sales menampilkan riwayat penjualan, biasanya urut dari yang terbaru.'],
    ['keys' => ['total', 'rp', 'jumlah', 'transaksi'], 'answer' => 'Kolom total adalah nilai rupiah untuk baris penjualan (qty × harga sesuai logika backend).'],
    ['keys' => ['logout', 'keluar'], 'answer' => 'Gunakan menu **Logout** di sidebar untuk mengakhiri sesi.'],
];

$cfg = [
    'pageTitle' => 'Sales Egar',
    'intro' => $intro,
    'hints' => $hints,
    'pairs' => $pairs,
];

$json = json_encode(
    $cfg,
    JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
);
if ($json === false) {
    $json = '{}';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan — Sales Egar</title>
    <style>
        :root {
            --bg: #0f1419;
            --panel: #1a2332;
            --text: #e8eef5;
            --muted: #8b9cb3;
            --accent: #3d8bfd;
            --accent-dim: #2a5fad;
            --user: #2d3f56;
            --bot: #243044;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(160deg, var(--bg) 0%, #151c28 100%);
            color: var(--text);
        }
        .wrap {
            max-width: 720px;
            margin: 0 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        header h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }
        header p { margin: .25rem 0 0; font-size: .85rem; color: var(--muted); }
        .nav a {
            color: var(--accent);
            text-decoration: none;
            font-size: .9rem;
        }
        .nav a:hover { text-decoration: underline; }
        .thread {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }
        .msg {
            max-width: 92%;
            padding: .75rem 1rem;
            border-radius: 12px;
            line-height: 1.5;
            font-size: .95rem;
        }
        .msg--bot {
            align-self: flex-start;
            background: var(--bot);
            border: 1px solid rgba(255,255,255,.06);
        }
        .msg--user {
            align-self: flex-end;
            background: var(--user);
        }
        .msg strong { color: #fff; }
        .hints {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            padding: 0 0 .5rem;
        }
        .chip {
            border: 1px solid rgba(61,139,253,.4);
            background: rgba(61,139,253,.12);
            color: var(--text);
            padding: .4rem .75rem;
            border-radius: 999px;
            font-size: .8rem;
            cursor: pointer;
        }
        .chip:hover { background: rgba(61,139,253,.22); }
        .composer {
            display: flex;
            gap: .5rem;
            padding-top: .75rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .composer input {
            flex: 1;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.12);
            background: var(--panel);
            color: var(--text);
            padding: .65rem .85rem;
            font-size: 1rem;
        }
        .composer input:focus {
            outline: 2px solid var(--accent);
            border-color: transparent;
        }
        .composer button {
            border: none;
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            padding: 0 1.1rem;
            cursor: pointer;
        }
        .composer button:hover { background: var(--accent-dim); }
        .sr { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); border: 0; }
    </style>
</head>
<body>
<div class="wrap">
    <header>
        <div>
            <h1>💬 assisten Sales Egar</h1>
            <p>Asisten penjelasan fitur & cara pakai</p>
        </div>
        <nav class="nav">
            <a href="index.php">← Beranda</a>
            ·
            <a href="javascript:history.back()">Kembali</a>
        </nav>
    </header>
    <div class="hints" id="hints" aria-label="Saran pertanyaan"></div>
    <div class="thread" id="messages" aria-live="polite"></div>
    <form class="composer" id="form" autocomplete="off">
        <label class="sr" for="q">Pertanyaan</label>
        <input type="text" id="q" maxlength="500" placeholder="Tanya seputar fitur Sales Egar…">
        <button type="submit">Kirim</button>
    </form>
</div>
<script>window.SALES_EGAR_CHATBOT = <?= $json ?>;</script>
<script>
(function () {
    'use strict';
    var cfg = window.SALES_EGAR_CHATBOT;
    if (!cfg || typeof cfg !== 'object') return;

    var messagesEl = document.getElementById('messages');
    var hintsEl = document.getElementById('hints');
    var form = document.getElementById('form');
    var input = document.getElementById('q');
    if (!messagesEl || !hintsEl || !form || !input) return;

    var pairs = Array.isArray(cfg.pairs) ? cfg.pairs : [];
    var hints = Array.isArray(cfg.hints) ? cfg.hints : [];
    var intro = typeof cfg.intro === 'string' ? cfg.intro : '';
    var pageTitle = typeof cfg.pageTitle === 'string' ? cfg.pageTitle : 'Sales Egar';

    function escapeHtml(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
    function formatAnswer(text) {
        return escapeHtml(text).replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
    }
    function appendMessage(role, html) {
        var div = document.createElement('div');
        div.className = 'msg msg--' + (role === 'user' ? 'user' : 'bot');
        div.innerHTML = html;
        messagesEl.appendChild(div);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }
    function tokenize(msg) {
        return String(msg).toLowerCase().replace(/[^a-z0-9]+/g, ' ').split(/\s+/).filter(function (w) { return w.length > 1; });
    }
    function scoreAnswer(userTokens, keys) {
        if (!keys || !keys.length) return 0;
        var set = {};
        keys.forEach(function (k) { set[String(k).toLowerCase()] = true; });
        var score = 0;
        userTokens.forEach(function (t) { if (set[t]) score += 2; });
        return score;
    }
    function replyForQuestion(q) {
        var tokens = tokenize(q);
        if (!tokens.length) return null;
        var best = null;
        var bestScore = 0;
        pairs.forEach(function (pair) {
            var sc = scoreAnswer(tokens, pair.keys || []);
            if (sc > bestScore) {
                bestScore = sc;
                best = pair.answer;
            }
        });
        if (bestScore >= 2 && best) return best;
        return 'Coba klik salah satu **saran** di atas, atau gunakan kata kunci: login, produk, target, komisi, transaksi, admin, sales.';
    }
    hints.forEach(function (h) {
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'chip';
        b.textContent = h;
        b.addEventListener('click', function () {
            input.value = h;
            submitQuestion(h);
        });
        hintsEl.appendChild(b);
    });
    appendMessage('bot', formatAnswer(intro));

    function submitQuestion(text) {
        var q = String(text || '').trim();
        if (!q) return;
        appendMessage('user', escapeHtml(q));
        var ans = replyForQuestion(q);
        appendMessage('bot', formatAnswer(ans || 'Maaf, coba pertanyaan lain.'));
        input.value = '';
    }
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitQuestion(input.value);
    });
})();
</script>
</body>
</html>
