<?php
/* Hallmark · page: портфолио · macrostructure: Catalogue Grid (счётчик → фильтр-чипсы → сетка → показать ещё)
     shares design.md system · nav N6 · footer Ft1 · tokens tokens.css
     Ось — тип изделия; материал — под-фильтр только у кухонь. */
$page += [
  'title' => 'Наши работы — кухни и мебель на заказ, салон «Престиж», Дзержинск',
  'description' => 'Портфолио салона «Престиж»: кухни, шкафы-купе, детские и прихожие на заказ. Работы с собственного производства, установленные в Дзержинске и Нижегородской области.',
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>

  <!-- 1 · Хлебные крошки -->
  <nav class="wrap crumbs" aria-label="Хлебные крошки">
    <ol>
      <li><a href="/">Главная</a></li>
      <li aria-current="page">Наши работы</li>
    </ol>
  </nav>

  <!-- 2 · Заголовок + счётчик -->
  <section class="wrap section pagedecor" data-deco="works" style="border-top:0" aria-labelledby="pf-title">
    <h1 class="section__title" id="pf-title" style="max-width:24ch">Наши работы</h1>
    <p class="section__lead measure">Всё, что вы видите, сделано на нашем производстве и стоит
      в квартирах Дзержинска и области. Галерею постоянно пополняем.</p>

    <!-- 3 · Фильтр по типу -->
    <div class="chips" data-type-filter role="group" aria-label="Фильтр по типу изделия">
      <button class="chip" type="button" data-type="all" aria-pressed="true">Все</button>
      <button class="chip" type="button" data-type="kuhni" aria-pressed="false">Кухни</button>
      <button class="chip" type="button" data-type="shkafy" aria-pressed="false">Шкафы-купе</button>
      <button class="chip" type="button" data-type="detskie" aria-pressed="false">Детские</button>
      <button class="chip" type="button" data-type="prihozhie" aria-pressed="false">Прихожие</button>
    </div>

    <!-- 4 · Сетка работ · клик по плитке открывает фото в лайтбоксе (href → само фото как фолбэк без JS) -->
    <div class="pgrid" data-portfolio>
<?php render_portfolio(); ?>
    </div>

    <div class="load-more">
      <button class="btn btn--ghost" type="button" data-load-more>Показать ещё</button>
      <button class="btn btn--ghost" type="button" data-load-all hidden>Показать все фото</button>
    </div>
  </section>

  <!-- 6 · Форма заявки -->
  <section class="section leadform" id="form" aria-labelledby="form-title">
    <div class="wrap">
      <h2 class="section__title" id="form-title">Понравилась работа? Сделаем такую же</h2>
      <div class="form-grid">
        <form class="form" novalidate data-lead action="/api/lead.php" method="post">
          <input type="hidden" name="subject" value="Портфолио">
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
          <p>Приедем в удобное время, снимем размеры и посчитаем стоимость. Замер бесплатный —
            даже если в итоге закажете не у нас.</p>
          <p>Заявка уходит менеджеру на почту и во ВКонтакте одновременно, поэтому не потеряется.</p>
        </aside>
      </div>
    </div>
  </section>

</main>

<?php require PARTIALS . '/footer.php';
