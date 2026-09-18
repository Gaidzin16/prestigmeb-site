<!doctype html>
<html lang="ru" data-bg="greige">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Вход — админка «Престиж»</title>
<link rel="icon" href="/img/favicon-32.png">
<link rel="stylesheet" href="/fonts.css">
<link rel="stylesheet" href="/admin/admin.css?v=2">
</head>
<body class="login">
<form class="login__box" method="post" autocomplete="on">
  <?= csrf_field() ?>
  <img src="/img/logo.png" alt="Престиж" width="200" height="76" class="login__logo">
  <h1>Управление сайтом</h1>
  <?php if ($err): ?><p class="msg msg--err"><?= e($err) ?></p><?php endif; ?>
  <label>Логин<input name="login" type="text" autocomplete="username" required autofocus></label>
  <label>Пароль<input name="password" type="password" autocomplete="current-password" required></label>
  <button class="btn" type="submit">Войти</button>
</form>
</body>
</html>
