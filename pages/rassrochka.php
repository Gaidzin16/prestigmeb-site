<?php
/* Hallmark · page: статичная · macrostructure: Letter (крошки → H1+лид → одноколоночная проза → форма → ссылки в сторону)
     shares design.md system · nav N6 · footer Ft1 · tokens tokens.css
     Пример шаблона — «Рассрочка». Один шаблон на rassrochka, kak-rabotaem, garantiya,
     o-kompanii, otzyvy, akcii, policy, soglasie. */
$page += [
  'title' => 'Рассрочка на мебель на 8 месяцев без банка — Дзержинск, салон «Престиж»',
  'description' => 'Даём рассрочку сами: 8 месяцев, без банка, без процентов и переплаты. Первый взнос 30%, договор оформляется в салоне. Кухни, шкафы-купе и мебель на заказ в Дзержинске.',
  'og_image' => '/img/kuhnya-sinyaya-mramor.jpg',
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>

  <!-- 1 · Хлебные крошки -->
  <nav class="wrap crumbs" aria-label="Хлебные крошки">
    <ol>
      <li><a href="/">Главная</a></li>
      <li aria-current="page">Рассрочка</li>
    </ol>
  </nav>

  <!-- 2 · Заголовок и лид -->
  <section class="wrap section pagedecor" data-deco="static" style="border-top:0" aria-labelledby="art-title">
    <div class="article rise">
      <h1 class="section__title" id="art-title" style="max-width:22ch">Рассрочка на 8 месяцев без банка</h1>
      <p class="article__lead">Мебель вы получаете сразу, а платите частями восемь месяцев.
        Без банка, без процентов и без переплаты — сколько стоит мебель, столько вы и заплатите.</p>

      <!-- 3 · Тело страницы -->
      <table class="spec-table">
        <tbody>
          <tr><th scope="row">Срок</th><td>8 месяцев</td></tr>
          <tr><th scope="row">Первый взнос</th><td>30%</td></tr>
          <tr><th scope="row">Проценты</th><td>Нет</td></tr>
          <tr><th scope="row">Переплата</th><td>Нет</td></tr>
          <tr><th scope="row">Участие банка</th><td>Не требуется</td></tr>
          <tr><th scope="row">Гарантия</th><td>Та же, что при оплате целиком</td></tr>
        </tbody>
      </table>

      <div class="prose" style="margin-top:var(--space-xl)">
        <h3>Как это работает</h3>
        <p>Рассрочку даёт сама компания, а не банк. Поэтому нет заявки, нет одобрения, нет проверки
          кредитной истории и нет отказа из-за старой просрочки по другому кредиту.</p>
        <p>Договор оформляется в салоне на Грибоедова, там же вносится первый взнос. Платежи приносите
          в офис или переводите — как удобнее.</p>
        <h3>Что нужно от вас</h3>
        <p>Паспорт и первый взнос.</p>
      </div>

      <h3 class="prose" style="max-width:none;margin-top:var(--space-xl);font-size:var(--text-lg)">Порядок</h3>
      <ol class="steps-list">
        <li>Бесплатный замер и дизайн-проект</li>
        <li>Договор в салоне</li>
        <li>Первый взнос 30%</li>
        <li>Изготовление и установка</li>
        <li>Восемь равных платежей</li>
      </ol>

      <!-- Вопрос-ответ -->
      <h3 class="prose" style="max-width:none;margin-top:var(--space-xl);font-size:var(--text-lg)">Частые вопросы</h3>
      <div class="faq" style="margin-top:var(--space-sm)">
        <details class="faq__item" open>
          <summary>Гарантия при рассрочке такая же?<span class="faq__mark" aria-hidden="true">+</span></summary>
          <p class="faq__a">Да. Условия гарантии не зависят от того, платите вы сразу или частями.</p>
        </details>
      </div>

      <!-- 5 · Ссылки в сторону -->
      <div class="sidelinks">
        <a class="tlink" href="/#steps-title">Как мы работаем <span class="arw">→</span></a>
        <a class="tlink" href="/#trust-title">Гарантия 18 месяцев <span class="arw">→</span></a>
        <a class="tlink" href="/portfolio/">Наши работы <span class="arw">→</span></a>
      </div>
    </div>
  </section>

  <!-- 4 · Форма заявки -->
  <section class="section leadform" id="form" aria-labelledby="form-title">
    <div class="wrap">
      <h2 class="section__title" id="form-title">Оформить заказ в рассрочку</h2>
      <div class="form-grid">
        <form class="form" novalidate data-lead action="/api/lead.php" method="post">
          <input type="hidden" name="subject" value="Рассрочка">
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
            <label for="f-comment">Комментарий <span style="color:var(--color-muted);font-weight:400">— необязательно</span></label>
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
          <p>Оставьте заявку — расскажем про условия рассрочки под ваш заказ и запишем на бесплатный замер.</p>
          <p>Заявка уходит менеджеру на почту и во ВКонтакте одновременно, поэтому не потеряется.</p>
        </aside>
      </div>
    </div>
  </section>

</main>

<?php require PARTIALS . '/footer.php';
