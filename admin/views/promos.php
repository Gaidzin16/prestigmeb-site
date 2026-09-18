<?php $promos = load('promos'); $edit = isset($_GET['i']) ? (int)$_GET['i'] : null; $isNew = $edit === -1;
$p = $isNew ? ['title' => '', 'text' => '', 'bullets' => [], 'note' => '', 'image' => '', 'alt' => '', 'active' => true] : ($edit !== null ? ($promos[$edit] ?? null) : null); ?>

<?php if ($p): ?>
<form class="card" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <input type="hidden" name="i" value="<?= $isNew ? -1 : $edit ?>">
  <h2><?= $isNew ? 'Новая акция' : 'Акция: ' . e($p['title']) ?></h2>
  <label>Название<input name="title" value="<?= e($p['title']) ?>" maxlength="120" required></label>
  <label>Описание (1–2 предложения)<textarea name="text" rows="3" maxlength="600"><?= e($p['text']) ?></textarea></label>
  <label>Пункты списка — по одному в строке (необязательно)<textarea name="bullets" rows="5"><?= e(implode("\n", $p['bullets'])) ?></textarea></label>
  <label>Примечание курсивом (например «Количество ограничено»)<input name="note" value="<?= e($p['note']) ?>" maxlength="200"></label>
  <div class="row">
    <?php if ($p['image']): ?><img class="thumb" src="/img/<?= e($p['image']) ?>" alt=""><?php endif; ?>
    <label class="grow"><?= $p['image'] ? 'Заменить фото' : 'Фото (обязательно)' ?><input type="file" name="image" accept="image/jpeg,image/png,image/webp"<?= $p['image'] ? '' : ' required' ?>></label>
  </div>
  <label>Подпись к фото (alt)<input name="alt" value="<?= e($p['alt']) ?>" maxlength="200"></label>
  <label class="check"><input type="checkbox" name="active" value="1"<?= !empty($p['active']) ? ' checked' : '' ?>> Показывать на сайте</label>
  <p class="toolbar"><button class="btn" type="submit">Сохранить</button> <a class="btn btn--ghost" href="?s=promos">Отмена</a></p>
</form>
<?php else: ?>

<p class="hint">Акции показываются на странице «Акции» в этом порядке. Выключенные не видны посетителям, но остаются здесь.</p>
<p class="toolbar"><a class="btn" href="?s=promos&i=-1">+ Новая акция</a></p>
<ol class="list">
<?php foreach ($promos as $i => $q): ?>
  <li class="item<?= empty($q['active']) ? ' item--off' : '' ?>">
    <img class="thumb" src="/img/<?= e($q['image']) ?>" alt="">
    <div class="grow">
      <b><?= e($q['title']) ?></b><?= empty($q['active']) ? ' <span class="tag">выключена</span>' : '' ?>
      <p class="muted"><?= e($q['text']) ?></p>
    </div>
    <div class="item__tools">
      <a class="btn btn--ghost" href="?s=promos&i=<?= $i ?>">Изменить</a>
      <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="i" value="<?= $i ?>"><input type="hidden" name="dir" value="-1"><button class="ico" title="Выше"<?= $i === 0 ? ' disabled' : '' ?>>↑</button></form>
      <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="i" value="<?= $i ?>"><input type="hidden" name="dir" value="1"><button class="ico" title="Ниже"<?= $i === count($promos) - 1 ? ' disabled' : '' ?>>↓</button></form>
      <form method="post" data-confirm="Удалить акцию «<?= e($q['title']) ?>»?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="i" value="<?= $i ?>"><button class="ico ico--del" title="Удалить">✕</button></form>
    </div>
  </li>
<?php endforeach; ?>
</ol>
<?php endif; ?>
