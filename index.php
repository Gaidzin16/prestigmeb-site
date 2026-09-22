<?php
/* Роутер сайта. nginx отдаёт сюда всё, что не является файлом.
 * Чистые URL → pages/<slug>.php; старые *.html → 301 на новые адреса. */
declare(strict_types=1);

const SITE_URL = 'https://prestigmeb.ru';
const ASSET_V  = '20260922b';
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

require PARTIALS . '/render.php';
$site = data('site');

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
    /* Старый сайт (2017–2026), карта: plans/structure.md §3; полный список — archive/manifest.json */
    '/shkafyi-kupe/' => '/shkafy-kupe/',
    '/spalni/' => '/',
    '/about/' => '/',
    '/contacts/' => '/#contacts',
    '/reviews/' => '/#reviews',
    '/installments/' => '/rassrochka/',
    '/sales/' => '/akcii/',
    '/sales/mojka-iz-keramogranita/' => '/akcii/',
    '/sales/novogodnie-podarki-vsem-pokupatelyam/' => '/akcii/',
    '/sales/skidki-ot-10-do/' => '/akcii/',
    /* страницы материалов — на «Кухни», где каталог материалов и RAL */
    '/ldsp/' => '/kuhni/', '/plastik/' => '/kuhni/', '/plastik-arpa/' => '/kuhni/',
    '/plastik/plastik-lemark/' => '/kuhni/', '/plastik/plastik-melaton/' => '/kuhni/',
    '/stoleshnitsyi/' => '/kuhni/', '/stenovyie-paneli/' => '/kuhni/',
    '/stenovyie-paneli-s-fotopechatyu/' => '/kuhni/',
    /* разделы портфолио — общая лента с предвыбранным фильтром по типу */
    '/portfolio/plenka-pvh/' => '/portfolio/?type=kuhni',
    '/portfolio/plastik-bez-alyuminiya/' => '/portfolio/?type=kuhni',
    '/portfolio/plastik-v-alyuminievom-profile/' => '/portfolio/?type=kuhni',
    '/portfolio/emal-krashenyie/' => '/portfolio/?type=kuhni',
    '/portfolio/massiv/' => '/portfolio/?type=kuhni',
    '/portfolio/ramochnyie/' => '/portfolio/?type=kuhni',
    '/portfolio/shkafyi-kupe/' => '/portfolio/?type=shkafy',
    '/portfolio/detskie/' => '/portfolio/?type=detskie',
    '/portfolio/kuhnya-v-hruschevku-plastik/' => '/portfolio/?type=kuhni',
    '/portfolio/kuhnya-v-hruschevku-plastik-1/' => '/portfolio/?type=kuhni',
    '/portfolio/kuhnya-v-hruschevku-pereplanirovka/' => '/portfolio/?type=kuhni',
];

$uri = (string)($_SERVER['REQUEST_URI'] ?? '/');
/* «//kuhni» parse_url прочитал бы как хост → путь пустой → главная. Двойные слэши схлопываем и уводим 301. */
if (preg_match('#//#', strtok($uri, '?'))) {
    header('Location: ' . preg_replace('#/{2,}#', '/', strtok($uri, '?')), true, 301);
    exit;
}
$path = rawurldecode(parse_url($uri, PHP_URL_PATH) ?: '/');

$lp = isset($legacy[$path]) ? $path : (isset($legacy[$path . '/']) ? $path . '/' : null);
if ($lp !== null) {
    header('Location: ' . $legacy[$lp], true, 301);
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
