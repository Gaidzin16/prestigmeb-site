<?php $leads = read_leads(); ?>
<p class="hint">Все заявки с форм сайта, новые сверху. Они же приходят на почту и во ВКонтакте.</p>
<?php if (!$leads): ?><p class="muted">Заявок пока нет.</p><?php endif; ?>
<ol class="list">
<?php foreach ($leads as $l): ?>
  <li class="card lead">
    <div class="lead__head"><b><?= e($l['fields']['Имя'] ?? '—') ?></b>
      <?php if (!empty($l['fields']['Телефон'])): ?> · <a href="tel:<?= e(phone_tel($l['fields']['Телефон'])) ?>"><?= e($l['fields']['Телефон']) ?></a><?php endif; ?>
      <span class="sp"></span><span class="muted"><?= e($l['when']) ?></span></div>
    <?php foreach ($l['fields'] as $k => $v): if (in_array($k, ['Имя', 'Телефон', 'Время'], true) || $v === '') continue; ?>
      <div class="lead__row"><span class="muted"><?= e($k) ?>:</span>
        <?php if ($k === 'Страница' && preg_match('#^https?://#i', $v)): /* ссылка только для http(s) — иначе javascript: и т. п. */ ?><a href="<?= e($v) ?>" target="_blank" rel="noopener"><?= e(preg_replace('#^https?://[^/]+#i', '', $v) ?: '/') ?></a><?php else: ?><?= e($v) ?><?php endif; ?>
      </div>
    <?php endforeach; ?>
  </li>
<?php endforeach; ?>
</ol>
