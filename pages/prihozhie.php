<?php
/* Hallmark · page: категория · macrostructure: Long Document (обложка → типы → материалы → работы → проза → FAQ)
     shares design.md system · nav N6 · footer Ft1 · section heads S2 · tokens tokens.css
     Инстанс шаблона категории — «Прихожие». Без RAL-блока: материалы — ЛДСП/МДФ/массив. */
$page += [
  'title' => 'Прихожие на заказ в Дзержинске по индивидуальным размерам — салон «Престиж»',
  'description' => 'Открытые, модульные прихожие и прихожие-купе по вашим размерам. Отдельно стоящие, встроенные и угловые. Бесплатный замер в Дзержинске и области, рассрочка на 8 месяцев без банка.',
  'og_image' => '/img/prihozhaya-klassika.jpg',
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>

  <!-- 1 · Хлебные крошки -->
  <nav class="wrap crumbs" aria-label="Хлебные крошки">
    <ol>
      <li><a href="/">Главная</a></li>
      <li aria-current="page">Прихожие</li>
    </ol>
  </nav>

  <!-- 2 · Обложка -->
  <section class="wrap pagehead" data-deco="hall" aria-labelledby="cat-title">
    <div class="pagehead__grid">
      <div class="rise">
        <h1 id="cat-title">Прихожие на заказ по индивидуальным размерам</h1>
        <p class="pagehead__lead">Открытые и закрытые, прямые и угловые, для просторных холлов
          и для коридоров, где полтора метра свободной стены. Отдельно стоящие, встроенные
          и угловые. Замер и дизайн-проект бесплатные.</p>
        <div class="pagehead__cta">
          <a class="btn" href="#form">Вызвать замерщика бесплатно</a>
          <a class="tlink" href="#works">Работы по прихожим <span class="arw">→</span></a>
        </div>
        <!-- 3 · Факты строкой -->
        <ul class="facts">
          <li><b>Рассрочка 8 месяцев</b> без банка</li>
          <li><b>Замер и проект</b> бесплатно</li>
          <li><b>Гарантия 18 месяцев</b></li>
          <li><b>Срок</b> 20–45 рабочих дней</li>
        </ul>
      </div>
      <div class="pagehead__photo photo rise">
        <img class="photo__img" src="/img/prihozhaya-klassika.jpg" srcset="/img/prihozhaya-klassika-800.jpg 800w, /img/prihozhaya-klassika.jpg 1600w" sizes="(max-width: 700px) 100vw, 50vw" alt="Прихожая на заказ: кремовый шкаф с витриной и туалетный столик, Дзержинск" loading="eager" decoding="async">
      </div>
    </div>
  </section>
  <!-- 4 · Блок «Стоимость» (от N ₽/пог. м) добавим, когда заказчик даст вилки цен -->

  <!-- 4b · Типы прихожих -->
  <section class="section" aria-labelledby="types-title">
    <div class="wrap">
      <p class="section__kicker">Конструкция</p>
      <h2 class="section__title" id="types-title">Какие бывают прихожие</h2>
      <p class="section__lead measure">Подберём тип под размер холла и то, что нужно хранить.
        Размещение — отдельно стоящая, встроенная или угловая.</p>
      <div class="matgrid">
        <div class="matcard">
          <div class="matcard__name">Открытая</div>
          <p class="matcard__desc">Для маленьких помещений: открытые полки и вешалки, ничего
            лишнего. Компактно и недорого.</p>
        </div>
        <div class="matcard">
          <div class="matcard__name">Модульная</div>
          <p class="matcard__desc">Собирается из тумб, полок, ящиков и шкафов под вашу конфигурацию.
            Можно дополнять со временем.</p>
        </div>
        <div class="matcard">
          <div class="matcard__name">Прихожая-купе</div>
          <p class="matcard__desc">Максимально вместительная и при этом компактно вписанная
            в проём — с раздвижными дверями вместо распашных.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 5 · Материалы (прихожая: ЛДСП / МДФ / массив) -->
  <section class="section" aria-labelledby="mat-title">
    <div class="wrap">
      <p class="section__kicker">Материалы</p>
      <h2 class="section__title" id="mat-title">Из чего делаем прихожую</h2>
      <p class="section__lead measure">От самого доступного корпуса до массива дерева —
        подбираем под бюджет и стиль коридора.</p>
      <div class="matgrid">
        <div class="matcard">
          <div class="matcard__name">ЛДСП</div>
          <p class="matcard__desc">Более 100 цветов, включая имитацию дерева и камня. Практично
            и устойчиво к влаге и грязи, которую несут с улицы.</p>
        </div>
        <div class="matcard">
          <div class="matcard__name">МДФ</div>
          <p class="matcard__desc">Плита средней плотности под плёнку или эмаль. Гнутые и фрезерованные
            фасады, мягкие формы — для классических прихожих.</p>
        </div>
        <div class="matcard">
          <div class="matcard__name">Массив дерева</div>
          <p class="matcard__desc">Натуральное дерево — самый статусный вариант. Ясень и бук,
            чистые цвета и декор оксидной плёнкой.</p>
        </div>
      </div>
      <p style="margin-top:var(--space-md);color:var(--color-ink-2);font-size:var(--text-sm)">
        <b>Стекло и зеркало</b> на дверцах-купе и в витринах — с пескоструйным рисунком
        или фотопечатью по вашему макету.</p>
    </div>
  </section>

  <!-- 6 · Работы этой категории -->
  <section class="section" id="works" aria-labelledby="works-title">
    <div class="wrap">
      <h2 class="section__title" id="works-title">Прихожие, которые мы сделали</h2>
      <p class="section__lead measure">Всё сделано на нашем производстве и стоит в квартирах
        Дзержинска и области.</p>
      <div class="works-strip">
<?php render_category_strip('prihozhie'); ?>
      </div>
      <p style="margin-top:var(--space-lg)"><a class="btn btn--ghost" href="/portfolio/">Все работы по прихожим</a></p>
    </div>
  </section>

  <!-- 7 · Текст категории -->
  <section class="section" aria-labelledby="about-title">
    <div class="wrap">
      <h2 class="section__title" id="about-title">Из чего состоит прихожая</h2>
      <div class="prose">
        <h3>Корпус и размещение</h3>
        <p>Основа — ламинированная плита (ЛДСП), МДФ или массив. Прихожую делаем отдельно
          стоящей, встроенной в нишу или угловой — под геометрию коридора. Встроенная экономит
          место и вмещает больше, отдельно стоящую можно перевезти при переезде.</p>
        <h3>Наполнение</h3>
        <p>Полки, ящики, вешалки и крючки, корзины, пантографы для верхней одежды и обувницы.
          Собираем под то, что вы реально храните: место под верхнюю одежду, обувь по сезону,
          сумки, ключи и мелочь.</p>
        <h3>Зеркало и стекло</h3>
        <p>Зеркало в полный рост — почти обязательный элемент прихожей. Дверцы-купе и витрины
          делаем со стеклом или зеркалом, с пескоструйным рисунком или фотопечатью по макету.</p>
        <h3>Фурнитура</h3>
        <ul>
          <li><strong>Системы дверей</strong> — распашные петли с доводчиком или раздвижные
            направляющие для прихожей-купе.</li>
          <li><strong>Крючки и штанги</strong> — под вес верхней одежды, с запасом.</li>
          <li><strong>Ручки</strong> — под бронзу, золото, серебро, хром или в цвет корпуса.</li>
          <li><strong>Подсветка</strong> — споты и светодиодные ленты, датчик движения по желанию.</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- 8 · Как мы работаем (свёрнуто) -->
  <section class="section" aria-labelledby="how-title">
    <div class="wrap">
      <p class="section__kicker">Процесс</p>
      <h2 class="section__title" id="how-title">Как мы работаем</h2>
      <ul class="steps-mini">
        <li>Заявка</li>
        <li>Бесплатный замер</li>
        <li>Дизайн-проект</li>
        <li>Изготовление</li>
        <li>Доставка и сборка</li>
      </ul>
      <p style="margin-top:var(--space-md)"><a class="tlink" href="/rassrochka/">Подробнее о том, как мы работаем <span class="arw">→</span></a></p>
    </div>
  </section>

  <!-- 9 · Вопрос-ответ (аккордеон) -->
  <section class="section" aria-labelledby="faq-title">
    <div class="wrap">
      <h2 class="section__title" id="faq-title">Частые вопросы</h2>
      <div class="faq">
        <details class="faq__item" open>
          <summary>У меня узкий коридор — полтора метра стены. Что-то получится?<span class="faq__mark" aria-hidden="true">+</span></summary>
          <p class="faq__a">Да. Для узких коридоров делаем открытые или неглубокие прихожие,
            а прихожая-купе вмещает максимум при минимуме глубины. Всё по фактическим размерам.</p>
        </details>
        <details class="faq__item">
          <summary>Можно встроить прихожую в нишу или угол?<span class="faq__mark" aria-hidden="true">+</span></summary>
          <p class="faq__a">Да, делаем отдельно стоящие, встроенные и угловые прихожие. Встроенная
            в нишу экономит место и выглядит аккуратнее — стенками служат стены помещения.</p>
        </details>
        <details class="faq__item">
          <summary>Сколько будет стоить прихожая?<span class="faq__mark" aria-hidden="true">+</span></summary>
          <p class="faq__a">Зависит от типа, материала корпуса и наполнения. Точную цену назовём
            после замера — он бесплатный и ни к чему вас не обязывает.</p>
        </details>
        <details class="faq__item">
          <summary>Сколько стоит замер?<span class="faq__mark" aria-hidden="true">+</span></summary>
          <p class="faq__a">Замер, подбор вариантов дизайна и расчёт прихожей бесплатны.</p>
        </details>
      </div>
    </div>
  </section>

  <!-- 10 · Форма заявки (сквозная) -->
  <section class="section leadform" id="form" aria-labelledby="form-title">
    <div class="wrap">
      <h2 class="section__title" id="form-title">Рассчитаем прихожую бесплатно</h2>
      <div class="form-grid">
        <form class="form" novalidate data-lead action="/api/lead.php" method="post">
          <input type="hidden" name="subject" value="Прихожие">
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
          <p>Замер, дизайн-проект и расчёт стоимости бесплатны и ни к чему вас не обязывают.</p>
          <p>Заявка уходит менеджеру на почту и во ВКонтакте одновременно, поэтому не потеряется.
            Перезвоним в рабочее время — <?= e($site['hours']) ?>.</p>
          <p class="ask"><a class="tlink" href="/#cont-title">Не готовы к замеру? Задайте вопрос <span class="arw">→</span></a></p>
        </aside>
      </div>
    </div>
  </section>

  <!-- 11 · Другие категории -->
  <section class="section" aria-labelledby="other-title">
    <div class="wrap">
      <h2 class="section__title" id="other-title">Другие категории</h2>
      <div class="cats">
        <a class="cat" href="/kuhni/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/kuhnya-shalfej.jpg" alt="Кухня цвета шалфея на заказ, классические фасады" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Кухни</h3><p class="cat__desc">Прямые, угловые, классика и модерн</p></div>
        </a>
        <a class="cat" href="/shkafy-kupe/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/shkaf-kupe-steklo.jpg" srcset="/img/shkaf-kupe-steklo-800.jpg 800w, /img/shkaf-kupe-steklo.jpg 1600w" sizes="(max-width: 700px) 100vw, 50vw" alt="Встроенный шкаф-купе с фасадами из сатинового стекла на заказ" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Шкафы-купе</h3><p class="cat__desc">Встроенные, угловые, радиусные</p></div>
        </a>
        <a class="cat" href="/detskie/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/detskaya-krovat.jpg" srcset="/img/detskaya-krovat-800.jpg 800w, /img/detskaya-krovat.jpg 1600w" sizes="(max-width: 700px) 100vw, 50vw" alt="Детская на заказ: угловой шкаф, комод и кровать" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Детские</h3><p class="cat__desc">С учётом возраста и роста</p></div>
        </a>
      </div>
    </div>
  </section>

</main>

<?php require PARTIALS . '/footer.php';
