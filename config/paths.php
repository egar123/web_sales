<?php
/**
 * Base URL path aplikasi relatif ke document root (mis. /sales_egar2).
 * Dipakai agar asset CSS/JS/img selalu resolve benar dari folder admin/ maupun sales/.
 */
function app_base_path(): string
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    $projectRoot = str_replace('\\', '/', dirname(__DIR__));

    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';
    $docRoot = str_replace('\\', '/', rtrim($docRoot, '/\\'));

    /* Windows: DOCUMENT_ROOT bisa "C:/..." sedangkan __DIR__ "c:/..." — pakai perbandingan case-insensitive */
    if ($docRoot !== '' && stripos($projectRoot, $docRoot) === 0) {
        $rel = substr($projectRoot, strlen($docRoot));
        $rel = '/' . ltrim($rel, '/');
        $cached = rtrim($rel, '/') ?: '';
    } else {
        $cached = '';
    }

    return $cached;
}

function asset_url(string $path): string
{
    $path = ltrim(str_replace('\\', '/', $path), '/');
    $base = app_base_path();
    if ($base === '') {
        return '/' . $path;
    }
    return $base . '/' . $path;
}

/**
 * Satukan beberapa file CSS (urutan penting: core.css selalu pertama).
 */
function css_links(string ...$files): string
{
    $out = [];
    foreach ($files as $file) {
        $file = ltrim($file, '/');
        if (!preg_match('/^[a-zA-Z0-9_-]+\.css$/', $file)) {
            continue;
        }
        $href = asset_url('assets/css/' . $file);
        $out[] = '<link rel="stylesheet" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '">';
    }
    return implode("\n    ", $out);
}
