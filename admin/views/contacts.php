<?php $site = load('site'); ?>
<p class="hint">Эти данные подставляются в шапку, подвал, блок «Приезжайте в салон» и юридические страницы.</p>
<form class="card" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <label>Адрес коротко (шапка и подвал)<input name="address_short" value="<?= e($site['address_short']) ?>" required></label>
  <label>Адрес полностью с индексом (юридические страницы)<input name="address_full" value="<?= e($site['address_full']) ?>" required></label>
  <label>Телефоны — по одному в строке, первый показывается в шапке<textarea name="phones" rows="3" required><?= e(implode("\n", array_column($site['phones'], 'text'))) ?></textarea></label>
  <label>Почта для связи<input name="email" type="email" value="<?= e($site['email']) ?>" required></label>
  <div class="row">
    <label class="grow">Часы работы<input name="hours" value="<?= e($site['hours']) ?>" required></label>
    <label class="grow">Примечание к часам<input name="hours_note" value="<?= e($site['hours_note']) ?>"></label>
  </div>
  <label>Ссылка ВКонтакте<input name="vk" type="url" value="<?= e($site['vk']) ?>"></label>
  <label>Ссылка Avito<input name="avito" type="url" value="<?= e($site['avito']) ?>"></label>
  <label>Ссылка «Построить маршрут» (Яндекс.Карты)<input name="route" type="url" value="<?= e($site['route']) ?>"></label>
  <label>Реквизиты в подвале<input name="requisites" value="<?= e($site['requisites']) ?>"></label>
  <p class="toolbar"><button class="btn" type="submit">Сохранить контакты</button></p>
</form>
