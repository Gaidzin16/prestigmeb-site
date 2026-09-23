<!doctype html>
<html lang="ru" data-bg="greige">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon-180.png">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<?php if (!empty($page['noindex'])): ?>
<meta name="robots" content="noindex, follow">
<?php endif; ?>
<?php if (!empty($page['url'])): ?>
<link rel="canonical" href="<?= SITE_URL . $page['url'] ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="ru_RU">
<meta property="og:site_name" content="Салон «Престиж»">
<meta property="og:url" content="<?= SITE_URL . $page['url'] ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:image" content="<?= SITE_URL . e($page['og_image'] ?? '/img/kuhnya-klassika-zoloto.jpg') ?>">
<?php endif; ?>
<?php if (!empty($page['lcp'])): /* картинка первого экрана — грузится параллельно с CSS */ ?>
<link rel="preload" as="image" href="/img/<?= e($page['lcp']) ?>.jpg"
      imagesrcset="/img/<?= e($page['lcp']) ?>-800.jpg 800w, /img/<?= e($page['lcp']) ?>.jpg 1600w"
      imagesizes="(max-width: 700px) 100vw, 50vw" fetchpriority="high">
<?php endif; ?>
<link rel="preload" as="font" type="font/woff2" href="/fonts/CormorantGaramond-600-cyrillic.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="/fonts/Manrope-400-cyrillic.woff2" crossorigin>
<?php if (!empty($page['url'])):
/* Разметка организации для поиска: адрес, телефоны, часы, соцсети.
   Часы берём из site.json — если формат разошёлся с «Пн–Пт 10:00–19:00», блок часов опускаем. */
$ld = [
  '@context' => 'https://schema.org',
  '@type' => 'FurnitureStore',
  '@id' => SITE_URL . '/#org',
  'name' => 'Салон мебели «' . $site['name'] . '»',
  'url' => SITE_URL . '/',
  'image' => SITE_URL . '/img/kuhnya-klassika-zoloto.jpg',
  'logo' => SITE_URL . '/img/logo.png',
  'telephone' => array_column($site['phones'], 'tel'),
  'email' => $site['email'],
  'address' => [
    '@type' => 'PostalAddress',
    'streetAddress' => 'ул. Грибоедова, д. 3',
    'addressLocality' => 'Дзержинск',
    'addressRegion' => 'Нижегородская область',
    'postalCode' => '606000',
    'addressCountry' => 'RU',
  ],
  'geo' => ['@type' => 'GeoCoordinates', 'latitude' => 56.243204, 'longitude' => 43.454592],
  'areaServed' => ['Дзержинск', 'Нижний Новгород', 'Нижегородская область'],
  'priceRange' => '₽₽',
  'currenciesAccepted' => 'RUB',
  'sameAs' => array_values(array_filter([$site['vk'] ?? '', $site['avito'] ?? ''])),
];
if (preg_match('/(\d{1,2}:\d{2}).{1,3}(\d{1,2}:\d{2})/u', $site['hours'], $h)) {
  $ld['openingHoursSpecification'] = [[
    '@type' => 'OpeningHoursSpecification',
    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    'opens' => $h[1], 'closes' => $h[2],
  ]];
}
?>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endif; ?>
<link rel="stylesheet" href="/tokens.css?v=<?= ASSET_V ?>">
<link rel="stylesheet" href="/site.css?v=<?= ASSET_V ?>">
<!-- шрифты не блокируют первый экран: все @font-face объявлены с font-display: swap -->
<link rel="stylesheet" href="/fonts.css?v=<?= ASSET_V ?>" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="/fonts.css?v=<?= ASSET_V ?>"></noscript>
</head>
<body data-phone="<?= e($site['phones'][0]['text']) ?>" data-hours="<?= e($site['hours']) ?>">

