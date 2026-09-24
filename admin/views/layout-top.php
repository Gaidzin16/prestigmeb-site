<!doctype html>
<html lang="ru" data-bg="greige">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($titles[$section]) ?> — админка «Престиж»</title>
<link rel="icon" href="/img/favicon-32.png">
<link rel="stylesheet" href="/fonts.css">
<link rel="stylesheet" href="/admin/admin.css?v=4">
</head>
<body>
<header class="top">
  <a class="top__brand" href="./"><img src="/img/logo.svg" alt="Престиж" width="120" height="45"></a>
  <nav class="top__nav">
    <?php foreach ($titles as $k => $t): ?>
      <a href="?s=<?= $k ?>"<?= $k === $section ? ' aria-current="page"' : '' ?>><?= e($t) ?></a>
    <?php endforeach; ?>
  </nav>
  <span class="sp"></span>
  <a class="top__site" href="/" target="_blank" rel="noopener">Открыть сайт ↗</a>
  <form class="top__out-form" method="post" action="?s=logout"><?= csrf_field() ?><button class="top__out" type="submit">Выйти</button></form>
</header>
<main class="page">
<?php if ($flash): ?><p class="msg <?= $flash['ok'] ? 'msg--ok' : 'msg--err' ?>"><?= e($flash['msg']) ?></p><?php endif; ?>
<h1><?= e($titles[$section]) ?></h1>
