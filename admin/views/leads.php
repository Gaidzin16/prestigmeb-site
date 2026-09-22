<?php
$leads = read_leads();
$done = leads_done();
$onlyNew = ($_GET['f'] ?? '') === 'new';
$newCount = count(array_filter($leads, fn($l) => !isset($done[$l['key']])));
?>
<p class="hint">Все заявки с форм сайта, новые сверху. Они же приходят на почту и во ВКонтакте.
  Отметка «обработана» видна только здесь — на сайт и в письма не влияет.</p>
<?php if (!$leads): ?><p class="muted">Заявок пока нет.</p><?php endif; ?>
<?php if ($leads): ?>
<p class="toolbar">
  <a class="btn<?= $onlyNew ? ' btn--ghost' : '' ?>" href="?s=leads">Все (<?= count($leads) ?>)</a>
  <a class="btn<?= $onlyNew ? '' : ' btn--ghost' ?>" href="?s=leads&amp;f=new">Новые (<?= $newCount ?>)</a>
</p>
<?php endif; ?>
<ol class="list">
<?php foreach ($leads as $l): $d = $done[$l['key']] ?? null; if ($onlyNew && $d) continue; ?>
  <li class="card lead<?= $d ? ' lead--done' : '' ?>">
    <div class="lead__head"><b><?= e($l['fields']['Имя'] ?? '—') ?></b>
      <?php if (!empty($l['fields']['Телефон'])): ?> · <a href="tel:<?= e(phone_tel($l['fields']['Телефон'])) ?>"><?= e($l['fields']['Телефон']) ?></a><?php endif; ?>
      <?php if ($d): ?> <span class="tag">обработана<?= $d['by'] !== '' ? ' · ' . e($d['by']) : '' ?></span><?php endif; ?>
      <span class="sp"></span><span class="muted"><?= e($l['when']) ?></span></div>
    <?php foreach ($l['fields'] as $k => $v): if (in_array($k, ['Имя', 'Телефон', 'Время'], true) || $v === '') continue; ?>
      <div class="lead__row"><span class="muted"><?= e($k) ?>:</span>
        <?php if ($k === 'Страница' && preg_match('#^https?://#i', $v)): /* ссылка только для http(s) — иначе javascript: и т. п. */ ?><a href="<?= e($v) ?>" target="_blank" rel="noopener"><?= e(preg_replace('#^https?://[^/]+#i', '', $v) ?: '/') ?></a><?php else: ?><?= e($v) ?><?php endif; ?>
      </div>
    <?php endforeach; ?>
    <form method="post" class="lead__tools">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="done">
      <input type="hidden" name="key" value="<?= e($l['key']) ?>">
      <input type="hidden" name="state" value="<?= $d ? '0' : '1' ?>">
      <button class="btn btn--ghost btn--sm" type="submit"><?= $d ? 'Вернуть в работу' : 'Отметить обработанной' ?></button>
    </form>
  </li>
<?php endforeach; ?>
</ol>
