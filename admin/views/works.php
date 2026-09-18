<?php $works = load('works'); ?>
<p class="hint">Порядок здесь = порядок в портфолио (первые 12 видны сразу, остальные под «Показать ещё»).
  Перетаскивайте карточки или используйте стрелки. <b>Главная</b> и <b>Категория</b> — номер позиции
  в слайдере на главной и в ленте из 4 фото на странице раздела; пусто — не показывать.</p>

<form class="card" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="upload">
  <h2>Добавить фото</h2>
  <div class="row">
    <label>Раздел
      <select name="type"><?php foreach ($TYPES as $k => $t): ?><option value="<?= $k ?>"><?= e($t) ?></option><?php endforeach; ?></select>
    </label>
    <label class="grow">Файлы (JPEG/PNG, можно несколько, до 20 МБ каждый)
      <input type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple required>
    </label>
    <button class="btn" type="submit">Загрузить</button>
  </div>
  <p class="hint">Фото уменьшаются до 1600 px и попадают в начало портфолио. Подпись можно поправить ниже.</p>
</form>

<form method="post" id="works-form">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <input type="hidden" name="order" id="works-order" value="">
  <div class="toolbar">
    <div class="chips" data-filter>
      <button class="chip" type="button" data-type="all" aria-pressed="true">Все (<?= count($works) ?>)</button>
      <?php foreach ($TYPES as $k => $t): ?>
        <button class="chip" type="button" data-type="<?= $k ?>" aria-pressed="false"><?= e($t) ?> (<?= count(array_filter($works, fn($w) => $w['type'] === $k)) ?>)</button>
      <?php endforeach; ?>
    </div>
    <span class="sp"></span>
    <button class="btn" type="submit">Сохранить все изменения</button>
  </div>

  <ol class="works" id="works-list">
    <?php foreach ($works as $i => $w): ?>
    <li class="work" data-i="<?= $i ?>" data-type="<?= e($w['type']) ?>" draggable="true">
      <div class="work__photo"><img src="/img/<?= e($w['file']) ?>" alt="" loading="lazy"><span class="work__n"><?= $i + 1 ?></span></div>
      <div class="work__body">
        <label>Подпись (alt)<input name="w[<?= $i ?>][alt]" value="<?= e($w['alt']) ?>" maxlength="200"></label>
        <div class="row">
          <label>Раздел<select name="w[<?= $i ?>][type]"><?php foreach ($TYPES as $k => $t): ?><option value="<?= $k ?>"<?= $w['type'] === $k ? ' selected' : '' ?>><?= e($t) ?></option><?php endforeach; ?></select></label>
          <label>Материал<select name="w[<?= $i ?>][material]"><?php foreach ($MATERIALS as $k => $t): ?><option value="<?= $k ?>"<?= ($w['material'] ?? '') === $k ? ' selected' : '' ?>><?= e($t) ?></option><?php endforeach; ?></select></label>
        </div>
        <div class="row row--flags">
          <label class="check"><input type="checkbox" name="w[<?= $i ?>][portfolio]" value="1"<?= !empty($w['portfolio']) ? ' checked' : '' ?>> В портфолио</label>
          <label>Главная<input type="number" name="w[<?= $i ?>][home]" value="<?= e((string)($w['home'] ?? '')) ?>" min="1" max="20" inputmode="numeric"></label>
          <label>Категория<input type="number" name="w[<?= $i ?>][category]" value="<?= e((string)($w['category'] ?? '')) ?>" min="1" max="4" inputmode="numeric"></label>
        </div>
      </div>
      <div class="work__tools">
        <button type="button" class="ico" data-move="-1" title="Выше">↑</button>
        <button type="button" class="ico" data-move="1" title="Ниже">↓</button>
        <button type="button" class="ico ico--del" data-delete="<?= $i ?>" title="Удалить">✕</button>
      </div>
    </li>
    <?php endforeach; ?>
  </ol>
  <p class="toolbar"><button class="btn" type="submit">Сохранить все изменения</button></p>
</form>

<form method="post" id="delete-form" hidden>
  <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="i" value="">
</form>
