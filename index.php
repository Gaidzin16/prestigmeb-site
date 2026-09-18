<?php
/* Роутер сайта. nginx отдаёт сюда всё, что не является файлом.
 * Чистые URL → pages/<slug>.php; старые *.html → 301 на новые адреса. */
declare(strict_types=1);

const SITE_URL = 'https://prestigmeb.ru';
const ASSET_V  = '20260918';
define('ROOT', __DIR__);
define('PARTIALS', ROOT . '/partials');
define('DATA_DIR', ROOT . '/data');

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function nav_current(string $slug): string { global $page; return ($page['nav'] ?? '') === $slug ? ' aria-current="page"' : ''; }
function data(string $name): array {
    static $cache = [];
    if (!isset($cache[$name])) {
        $f = DATA_DIR . "/$name.json";
        $cache[$name] = is_file($f) ? (json_decode(file_get_contents($f), true) ?: []) : [];
    }
    return $cache[$name];
}

$routes = [
    '/'             => 'home',
    '/kuhni/'       => 'kuhni',
    '/shkafy-kupe/' => 'shkafy',
    '/detskie/'     => 'detskie',
    '/prihozhie/'   => 'prihozhie',
    '/portfolio/'   => 'portfolio',
    '/akcii/'       => 'akcii',
    '/rassrochka/'  => 'rassrochka',
    '/policy/'      => 'policy',
    '/soglasie/'    => 'soglasie',
];
/* Адреса демо-версии (до 2026-09-18) */
$legacy = [
    '/index.html' => '/', '/category.html' => '/kuhni/', '/shkafy.html' => '/shkafy-kupe/',
    '/detskie.html' => '/detskie/', '/prihozhie.html' => '/prihozhie/', '/portfolio.html' => '/portfolio/',
    '/akcii.html' => '/akcii/', '/static.html' => '/rassrochka/', '/policy.html' => '/policy/',
    '/soglasie.html' => '/soglasie/',
];

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if (isset($legacy[$path])) {
    header('Location: ' . $legacy[$path], true, 301);
    exit;
}
/* /kuhni → /kuhni/ (один канонический вид) */
if ($path !== '/' && substr($path, -1) !== '/' && isset($routes[$path . '/'])) {
    header('Location: ' . $path . '/', true, 301);
    exit;
}

$slug = $routes[$path] ?? null;
$page = ['nav' => $slug, 'url' => $path];
if ($slug === null) {
    http_response_code(404);
    $page = ['nav' => null, 'url' => null];
    $slug = '404';
}
require ROOT . "/pages/$slug.php";
