<?php
/* Hallmark · page: акции (статичная) · macrostructure: Letter (крошки → H1+лид → сетка карточек-акций → постоянное предложение → форма → ссылки в сторону)
     shares design.md system · nav N6 · footer Ft1 · tokens tokens.css
     Экземпляр статичного шаблона. Акции — карточки .cat (пока плейсхолдеры под фото/тексты заказчика). */
$page += [
  'title' => 'Акции и скидки на мебель — салон «Престиж», Дзержинск',
  'description' => 'Действующие акции салона «Престиж»: мойка из керамогранита в подарок при заказе кухни и рассрочка на 8 месяцев без банка и без процентов. Дзержинск.',
  'og_image' => '/img/akciya-kuhnya-100k.jpg',
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>

  <!-- 1 · Хлебные крошки -->
  <nav class="wrap crumbs" aria-label="Хлебные крошки">
    <ol>
      <li><a href="/">Главная</a></li>
      <li aria-current="page">Акции</li>
    </ol>
  </nav>

  <!-- 2 · Заголовок и лид -->
  <section class="wrap section pagedecor" data-deco="akcii" style="border-top:0" aria-labelledby="art-title">
    <div class="article rise">
      <h1 class="section__title" id="art-title" style="max-width:16ch">Акции</h1>
      <p class="article__lead">Что действует прямо сейчас. По любой акции оставьте заявку —
        менеджер подтвердит условия и запишет на бесплатный замер.</p>

      <!-- 3 · Сетка акций -->
      <div class="cats" style="grid-template-columns:repeat(2,minmax(0,1fr));max-width:52rem" role="list">
<?php render_promos(); ?>
      </div>

      <!-- Постоянное предложение -->
      <div class="prose" style="margin-top:var(--space-xl)">
        <h3>Постоянное предложение</h3>
        <p><strong>Рассрочка на 8 месяцев</strong> — без банка, без процентов и без переплаты.
          Первый взнос 30%, договор оформляется в салоне. Действует всегда.</p>
      </div>

      <!-- 5 · Ссылки в сторону -->
      <div class="sidelinks">
        <a class="tlink" href="/rassrochka/">Условия рассрочки <span class="arw">→</span></a>
        <a class="tlink" href="/portfolio/">Наши работы <span class="arw">→</span></a>
        <a class="tlink" href="/#trust-title">Гарантия 18 месяцев <span class="arw">→</span></a>
      </div>
    </div>
  </section>

  <!-- 4 · Форма заявки -->
  <section class="section leadform" id="form" aria-labelledby="form-title">
    <div class="wrap">
      <h2 class="section__title" id="form-title">Оставить заявку по акции</h2>
      <div class="form-grid">
        <form class="form" novalidate data-lead data-item-label="Акция" action="/api/lead.php" method="post">
          <input type="hidden" name="subject" value="Акции">
          <input type="hidden" name="item" value="">
          <p class="form__pick" hidden></p>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">
          <div class="field">
            <label for="f-name">Ваше имя</label>
            <input id="f-name" name="name" type="text" autocomplete="name" required>
          </div>
          <div class="field">
            <label for="f-phone">Телефон</label>
            <input id="f-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required>
          </div>
          <div class="field">
            <label for="f-comment">Вопрос или пожелание <span style="color:var(--color-muted);font-weight:400">— необязательно</span></label>
            <textarea id="f-comment" name="comment" rows="3"></textarea>
          </div>
          <label class="consent">
            <input type="checkbox" name="consent" required>
            <span>Даю <a href="/soglasie/">согласие на обработку персональных данных</a> и принимаю <a href="/policy/">политику конфиденциальности</a>.</span>
          </label>
          <button class="btn" type="submit">Отправить заявку</button>
          <p class="form__status" role="status" aria-live="polite" hidden></p>
        </form>
        <aside class="form-aside">
          <p>Оставьте заявку — подтвердим условия акции под ваш заказ и запишем на бесплатный замер.</p>
          <p>Заявка уходит менеджеру на почту и во ВКонтакте одновременно, поэтому не потеряется.</p>
        </aside>
      </div>
    </div>
  </section>

</main>

<?php require PARTIALS . '/footer.php';
