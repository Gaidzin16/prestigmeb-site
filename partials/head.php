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
<link rel="stylesheet" href="/fonts.css">
<link rel="stylesheet" href="/site.css?v=<?= ASSET_V ?>">
</head>
<body>

