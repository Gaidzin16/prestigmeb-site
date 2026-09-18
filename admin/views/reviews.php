<?php $reviews = load('reviews'); ?>
<p class="hint">Отзывы показываются на главной в этом порядке. Пустой текст — отзыв удаляется при сохранении.</p>
<form method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <ol class="list" id="reviews-list">
  <?php foreach (array_merge($reviews, [['text' => '', 'who' => '', 'where' => 'отзыв с сайта']]) as $i => $r): ?>
    <li class="card review<?= $i === count($reviews) ? ' review--new' : '' ?>">
      <?php if ($i === count($reviews)): ?><h2>Новый отзыв</h2><?php endif; ?>
      <label>Текст<textarea name="r[<?= $i ?>][text]" rows="4" maxlength="1000"><?= e($r['text']) ?></textarea></label>
      <div class="row">
        <label class="grow">Кто<input name="r[<?= $i ?>][who]" value="<?= e($r['who']) ?>" maxlength="80"></label>
        <label class="grow">Откуда<input name="r[<?= $i ?>][where]" value="<?= e($r['where']) ?>" maxlength="80" placeholder="отзыв с сайта / Яндекс / ВКонтакте"></label>
      </div>
    </li>
  <?php endforeach; ?>
  </ol>
  <p class="toolbar"><button class="btn" type="submit">Сохранить отзывы</button></p>
</form>
