<!-- ============ Ft1 · подвал ============ -->
<footer class="foot">
  <div class="wrap">
    <div class="foot__top">
      <div class="foot__brand">
        <span class="wordmark">Престиж</span>
        <p class="foot__slogan">Мебель в ритме жизни…</p>
      </div>
      <div>
        <h4>Каталог</h4>
        <ul class="foot__links">
          <li><a href="/kuhni/">Кухни</a></li>
          <li><a href="/shkafy-kupe/">Шкафы-купе</a></li>
          <li><a href="/detskie/">Детские</a></li>
          <li><a href="/prihozhie/">Прихожие</a></li>
        </ul>
      </div>
      <div>
        <h4>Компания</h4>
        <ul class="foot__links">
          <li><a href="/portfolio/">Портфолио</a></li>
          <li><a href="/akcii/">Акции</a></li>
          <li><a href="/rassrochka/">Рассрочка</a></li>
          <li><a href="/#steps-title">Как мы работаем</a></li>
          <li><a href="/#trust-title">Гарантия</a></li>
          <li><a href="/#rev-title">Отзывы</a></li>
          <li><a href="/#cont-title">Контакты</a></li>
        </ul>
      </div>
    </div>
    <div class="foot__bottom">
      <span><?= e($site['address_short']) ?> · <?= e($site['phones'][0]['text']) ?></span>
      <span><a href="<?= e($site['vk']) ?>" target="_blank" rel="noopener" style="color:var(--color-on-carbon-2)">ВКонтакте</a> · <a href="<?= e($site['avito']) ?>" target="_blank" rel="noopener" style="color:var(--color-on-carbon-2)">Avito</a></span>
      <span class="sp"></span>
      <a href="/policy/"<?= nav_current('policy') ?> style="color:var(--color-on-carbon-2)">Политика обработки данных</a>
      <a href="/soglasie/"<?= nav_current('soglasie') ?> style="color:var(--color-on-carbon-2)">Согласие на обработку</a>
      <span class="foot__req"><?= e($site['requisites']) ?></span>
<?php if (trim((string)($site['counters'] ?? '')) !== ''): ?>
      <a href="#" data-cookie-reset style="color:var(--color-on-carbon-2)">Настройки cookie</a>
<?php endif; ?>
    </div>
  </div>
</footer>

<?php if (empty($page['no_cta'])): ?>
<!-- липкая мобильная CTA -->
<div class="sticky-cta"><a class="btn" href="<?= empty($page['cta_home']) ? '#form' : '/#form' ?>">Бесплатный замер</a></div>
<?php endif; ?>

<?php $counters = trim((string)($site['counters'] ?? '')); if ($counters !== ''): ?>
<!-- Коды счётчиков и пикселей. Лежат выключенными: site.js включает их только после
     согласия на cookie. Код в base64, чтобы закрывающий тег внутри не ломал разметку. -->
<div id="counters-code" data-code="<?= e(base64_encode($counters)) ?>" hidden></div>
<div class="cookiebar" id="cookiebar" hidden>
  <p class="cookiebar__text">Мы используем файлы cookie и сервисы статистики, чтобы понимать,
    какие страницы полезны посетителям. Без согласия они не загружаются.
    Подробнее — в <a href="/policy/">политике обработки данных</a>.</p>
  <div class="cookiebar__acts">
    <button class="cookiebar__btn" type="button" data-cookie="yes">Принять</button>
    <button class="cookiebar__btn cookiebar__btn--ghost" type="button" data-cookie="no">Только необходимые</button>
  </div>
</div>
<?php endif; ?>

<script src="/site.js?v=<?= ASSET_V ?>"></script>

</body>
</html>
