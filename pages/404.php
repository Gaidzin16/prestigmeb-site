<?php
/* Hallmark · page: статичная · macrostructure: Letter (крошки → H1+лид → одноколоночная проза → форма → ссылки в сторону)
     shares design.md system · nav N6 · footer Ft1 · tokens tokens.css
     Пример шаблона — «Рассрочка». Один шаблон на rassrochka, kak-rabotaem, garantiya,
     o-kompanii, otzyvy, akcii, policy, soglasie. */
$page += [
  'title' => 'Страница не найдена — салон «Престиж»',
  'description' => 'Такой страницы нет. Перейдите на главную или в каталог кухонь и шкафов-купе на заказ в Дзержинске.',
  'noindex' => true,
  'cta_home' => true,
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>
  <section class="wrap section pagedecor" data-deco="static" style="border-top:0" aria-labelledby="art-title">
    <div class="article rise">
      <p class="section__kicker">Ошибка 404</p>
      <h1 class="section__title" id="art-title" style="max-width:22ch">Такой страницы нет</h1>
      <p class="section__lead measure">Возможно, адрес изменился или в ссылке опечатка.
        Вот куда можно пойти отсюда:</p>
      <ul style="margin-top:var(--space-md)">
        <li><a class="tlink" href="/">Главная <span class="arw">→</span></a></li>
        <li><a class="tlink" href="/kuhni/">Кухни на заказ <span class="arw">→</span></a></li>
        <li><a class="tlink" href="/shkafy-kupe/">Шкафы-купе <span class="arw">→</span></a></li>
        <li><a class="tlink" href="/portfolio/">Наши работы <span class="arw">→</span></a></li>
        <li><a class="tlink" href="/#cont-title">Контакты <span class="arw">→</span></a></li>
      </ul>
      <p style="margin-top:var(--space-lg)">Или позвоните: <a href="tel:<?= e($site['phones'][0]['tel']) ?>"><?= e($site['phones'][0]['text']) ?></a> — <?= e($site['hours']) ?>.</p>
    </div>
  </section>
</main>

<?php require PARTIALS . '/footer.php';
