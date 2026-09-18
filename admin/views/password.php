<form class="card" method="post" autocomplete="off" style="max-width:26rem">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <p class="hint">Пользователь: <b><?= e($_SESSION['user']) ?></b></p>
  <label>Текущий пароль<input name="current" type="password" autocomplete="current-password" required></label>
  <label>Новый пароль (не короче 10 символов)<input name="new" type="password" autocomplete="new-password" minlength="10" required></label>
  <label>Ещё раз новый пароль<input name="confirm" type="password" autocomplete="new-password" minlength="10" required></label>
  <p class="toolbar"><button class="btn" type="submit">Сменить пароль</button></p>
</form>
