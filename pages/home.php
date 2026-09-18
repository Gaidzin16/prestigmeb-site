<?php
$page += [
  'title' => 'Кухни и мебель на заказ в Дзержинске — салон «Престиж»',
  'description' => 'Изготавливаем кухни, шкафы-купе и корпусную мебель по вашим размерам с 2004 года. Собственное производство в Дзержинске, работаем по всей Нижегородской области. Замер и дизайн-проект бесплатно, рассрочка на 8 месяцев без банка.',
  'og_image' => '/img/kuhnya-sinyaya-mramor.jpg',
];
require PARTIALS . '/head.php';
require PARTIALS . '/header.php';
?>
<main>

  <!-- 1 · Первый экран -->
  <section class="hero-band" aria-labelledby="hero-title">
    <!-- фоновые мебельные эскизы + тёплое свечение (декор, скрыт от скринридеров) -->
    <div class="hero__fx" aria-hidden="true">
      <svg width="0" height="0" class="hero__defs"><defs>
        <symbol id="f-kitchen" viewBox="0 0 150 112">
          <rect x="6" y="6" width="42" height="34"/><rect x="52" y="6" width="42" height="34"/><rect x="98" y="6" width="42" height="34"/>
          <line x1="27" y1="30" x2="27" y2="35"/><line x1="73" y1="30" x2="73" y2="35"/><line x1="119" y1="30" x2="119" y2="35"/>
          <line x1="0" y1="52" x2="150" y2="52"/>
          <rect x="6" y="60" width="30" height="46"/><rect x="40" y="60" width="30" height="46"/><rect x="74" y="60" width="66" height="46"/>
          <circle cx="107" cy="83" r="6"/>
        </symbol>
        <symbol id="f-ruler" viewBox="0 0 140 42">
          <rect x="2" y="10" width="136" height="24" rx="4"/>
          <line x1="16" y1="10" x2="16" y2="24"/><line x1="30" y1="10" x2="30" y2="20"/><line x1="44" y1="10" x2="44" y2="24"/><line x1="58" y1="10" x2="58" y2="20"/><line x1="72" y1="10" x2="72" y2="24"/><line x1="86" y1="10" x2="86" y2="20"/><line x1="100" y1="10" x2="100" y2="24"/><line x1="114" y1="10" x2="114" y2="20"/>
        </symbol>
        <symbol id="f-lamp" viewBox="0 0 70 120">
          <path d="M18 40 L52 40 L44 8 L26 8 Z"/><line x1="35" y1="40" x2="35" y2="108"/><path d="M18 112 L52 112"/>
        </symbol>
        <symbol id="f-wardrobe" viewBox="0 0 88 130">
          <rect x="6" y="6" width="76" height="118"/><line x1="44" y1="6" x2="44" y2="124"/>
          <line x1="20" y1="6" x2="20" y2="124"/><line x1="68" y1="6" x2="68" y2="124"/>
          <line x1="36" y1="58" x2="36" y2="74"/><line x1="52" y1="58" x2="52" y2="74"/>
        </symbol>
        <symbol id="f-dresser" viewBox="0 0 120 92">
          <rect x="6" y="6" width="108" height="80"/><line x1="6" y1="32" x2="114" y2="32"/><line x1="6" y1="58" x2="114" y2="58"/>
          <line x1="50" y1="19" x2="70" y2="19"/><line x1="50" y1="45" x2="70" y2="45"/><line x1="50" y1="71" x2="70" y2="71"/>
          <line x1="14" y1="86" x2="10" y2="92"/><line x1="106" y1="86" x2="110" y2="92"/>
        </symbol>
        <symbol id="f-chair" viewBox="0 0 80 112">
          <path d="M20 8 L20 60 M60 8 L60 60 M14 60 L66 60 L62 70 L18 70 Z M22 70 L18 106 M58 70 L62 106 M22 40 L58 40"/>
        </symbol>
        <symbol id="f-sofa" viewBox="0 0 150 84">
          <path d="M10 40 Q10 22 28 22 L122 22 Q140 22 140 40 L140 66 L10 66 Z"/>
          <path d="M24 40 L24 54 M126 40 L126 54 M24 54 L126 54"/>
          <line x1="20" y1="66" x2="18" y2="78"/><line x1="130" y1="66" x2="132" y2="78"/>
        </symbol>
        <symbol id="f-shelf" viewBox="0 0 110 120">
          <rect x="6" y="6" width="98" height="108"/><line x1="6" y1="42" x2="104" y2="42"/><line x1="6" y1="78" x2="104" y2="78"/>
          <rect x="16" y="14" width="10" height="24"/><rect x="30" y="18" width="10" height="20"/>
        </symbol>
      </defs></svg>
      <div class="hero__glow"></div>
      <svg class="hero__sketch hero__sketch--kitchen" viewBox="0 0 150 112"><use href="#f-kitchen"/></svg>
      <svg class="hero__sketch hero__sketch--ruler" viewBox="0 0 140 42"><use href="#f-ruler"/></svg>
      <svg class="hero__sketch hero__sketch--lamp" viewBox="0 0 70 120"><use href="#f-lamp"/></svg>
      <svg class="hero__sketch hero__sketch--wardrobe" viewBox="0 0 88 130"><use href="#f-wardrobe"/></svg>
      <svg class="hero__sketch hero__sketch--dresser" viewBox="0 0 120 92"><use href="#f-dresser"/></svg>
      <svg class="hero__sketch hero__sketch--chair" viewBox="0 0 80 112"><use href="#f-chair"/></svg>
      <svg class="hero__sketch hero__sketch--sofa" viewBox="0 0 150 84"><use href="#f-sofa"/></svg>
      <svg class="hero__sketch hero__sketch--shelf" viewBox="0 0 110 120"><use href="#f-shelf"/></svg>
    </div>
    <div class="wrap hero">
    <div class="hero__grid">
      <div class="rise">
        <p class="hero__slogan">Мебель в ритме жизни…</p>
        <h1 class="hero__title" id="hero-title">Кухни на заказ в Дзержинске и&nbsp;Нижегородской области</h1>
        <div class="hero__cta">
          <a class="btn" href="#form">Вызвать замерщика бесплатно</a>
          <a class="tlink" href="#works">Посмотреть работы <span class="arw">→</span></a>
        </div>
        <ul class="facts">
          <li><b>Рассрочка 8 месяцев</b> без банка</li>
          <li><b>Замер и проект</b> бесплатно</li>
          <li><b>Гарантия 18 месяцев</b></li>
        </ul>
      </div>
      <div class="slider slider--hero rise" data-slider data-autoplay="6000" tabindex="0" role="group" aria-roledescription="слайдер" aria-label="Наши кухни">
        <div class="slider__viewport">
          <div class="slider__track">
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-sinyaya-mramor.jpg" alt="Синяя классическая кухня с белой мраморной столешницей на заказ, Дзержинск" loading="eager" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-belaya-glyanec.jpg" alt="Белая глянцевая кухня на заказ, Дзержинск" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-modern-bezruchek.jpg" alt="Современная кухня без ручек на заказ" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-shalfej.jpg" alt="Кухня цвета шалфея на заказ" loading="lazy" decoding="async"></div></div>
          </div>
          <button class="slider__arrow slider__arrow--prev" type="button" aria-label="Предыдущее фото">‹</button>
          <button class="slider__arrow slider__arrow--next" type="button" aria-label="Следующее фото">›</button>
        </div>
        <div class="slider__dots" aria-hidden="true"></div>
      </div>
    </div>
    </div>
  </section>

  <!-- 2 · Рассрочка -->
  <section class="section rassrochka" aria-labelledby="rass-title">
    <div class="wrap">
      <h2 class="section__title" id="rass-title">Рассрочка на 8 месяцев без банка</h2>
      <p class="section__lead">Рассрочку даём сами, без банка и без процентов. Никаких заявок, одобрений
        и проверок кредитной истории — договор оформляется прямо в салоне. Мебель вы получаете
        сразу, платите частями восемь месяцев и не переплачиваете ни рубля.</p>
      <div class="rass-row">
        <div class="rass-row__item"><div class="rass-row__k">Без&nbsp;банка</div><div class="rass-row__v">договор в салоне, без заявок</div></div>
        <div class="rass-row__item"><div class="rass-row__k">0%</div><div class="rass-row__v">без процентов и переплаты</div></div>
        <div class="rass-row__item"><div class="rass-row__k">8&nbsp;мес.</div><div class="rass-row__v">равными частями</div></div>
        <div class="rass-row__item"><div class="rass-row__k">30%</div><div class="rass-row__v">первый взнос</div></div>
      </div>
      <p style="margin-top:var(--space-lg)"><a class="tlink" href="/rassrochka/">Условия рассрочки <span class="arw">→</span></a></p>
    </div>
  </section>

  <!-- 3 · Категории -->
  <section class="section" aria-labelledby="cats-title">
    <div class="wrap">
      <h2 class="section__title" id="cats-title">Что мы делаем</h2>
      <div class="cats">
        <a class="cat cat--lead" href="/kuhni/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/kuhnya-belaya-modern.jpg" alt="Белая угловая кухня в стиле модерн на заказ" loading="lazy" decoding="async"></div></div>
          <div class="cat__body">
            <h3 class="cat__name">Кухни на заказ</h3>
            <p class="cat__desc">Фасады из плёнки, пластика, эмали и массива. Прямые, угловые, с островом.</p>
          </div>
        </a>
        <a class="cat" href="/shkafy-kupe/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/shkaf-kupe-steklo.jpg" alt="Встроенный шкаф-купе с фасадами из сатинового стекла на заказ" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Шкафы-купе</h3><p class="cat__desc">Встроенные, угловые, радиусные</p></div>
        </a>
        <a class="cat" href="/detskie/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/detskaya-krovat.jpg" alt="Детская на заказ: угловой шкаф, комод и кровать" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Детские</h3><p class="cat__desc">С учётом возраста и роста</p></div>
        </a>
        <a class="cat" href="/prihozhie/">
          <div class="cat__photo"><div class="photo"><img class="photo__img" src="/img/prihozhaya-mramor.jpg" alt="Прихожая на заказ: мрамор, зеркало, встроенный шкаф" loading="lazy" decoding="async"></div></div>
          <div class="cat__body"><h3 class="cat__name">Прихожие</h3><p class="cat__desc">Открытые, модульные, купе</p></div>
        </a>
      </div>
    </div>
  </section>

  <!-- 4 · Как мы работаем · 3D-проект фоном (разделяет «Что делаем» и остальное) -->
  <section class="section steps-band" data-reveal aria-labelledby="steps-title">
    <div class="steps-band__bg" aria-hidden="true">
      <img class="reveal__img reveal__img--color" src="/img/proekt-render.jpg" alt="" loading="lazy" decoding="async">
      <img class="reveal__img reveal__img--blueprint" src="/img/proekt-render.jpg" alt="" loading="lazy" decoding="async">
    </div>
    <div class="steps-band__scrim" aria-hidden="true"></div>
    <span class="reveal__scan" aria-hidden="true"></span>
    <div class="wrap">
      <h2 class="section__title" id="steps-title">Новая кухня в пять шагов</h2>
      <p class="steps-band__sub">Показываем дизайн-проект кухни до изготовления — правки бесплатны.</p>
      <div class="steps">
        <div class="step"><div class="step__n">1</div><div><div class="step__t">Заявка</div><p class="step__d">Оставьте заявку на сайте или позвоните. Ответим на вопросы и запишем на замер.</p></div></div>
        <div class="step"><div class="step__n">2</div><div><div class="step__t">Бесплатный замер</div><p class="step__d">Замерщик приезжает к вам домой в удобное время и снимает точные размеры. Замер бесплатный, даже если вы закажете не у нас.</p></div></div>
        <div class="step"><div class="step__n">3</div><div><div class="step__t">Дизайн-проект</div><p class="step__d">Рисуем эскиз по вашим размерам. Вы выбираете материалы, цвет и фурнитуру по образцам, мы считаем точную стоимость. Проект тоже бесплатный.</p></div></div>
        <div class="step"><div class="step__n">4</div><div><div class="step__t">Изготовление</div><p class="step__d">Делаем мебель на собственном производстве — от 20 до 45 рабочих дней в зависимости от сложности проекта.</p></div></div>
        <div class="step"><div class="step__n">5</div><div><div class="step__t">Доставка и сборка</div><p class="step__d">Привозим, собираем, врезаем мойку и подключаем технику. Кухню обычно собираем за один день.</p></div></div>
      </div>
      <p style="margin-top:var(--space-lg)"><a class="tlink" href="/rassrochka/">Подробнее о том, как мы работаем <span class="arw">→</span></a></p>
    </div>
  </section>

  <!-- 5 · Материалы и поставщики -->
  <section class="section suppliers" aria-labelledby="supp-title">
    <div class="wrap">
      <h2 class="section__title" id="supp-title">С чем мы работаем</h2>
      <p class="section__lead measure">Комбинируем производителей, чтобы получить разумное соотношение
        цены и качества, а не самые дорогие бренды ради названия.</p>
      <div class="supp-wall">
        <div class="supp">Blum</div>
        <div class="supp">Hettich</div>
        <div class="supp">Aristo</div>
        <div class="supp">Boyard</div>
        <div class="supp">GTV</div>
        <div class="supp">Кедр</div>
        <div class="supp">Скиф</div>
        <div class="supp" style="color:var(--color-muted)">и другие</div>
      </div>
    </div>
  </section>

  <!-- 6 · Почему нам можно доверять -->
  <section class="section trust" aria-labelledby="trust-title">
    <div class="wrap">
      <h2 class="section__title" id="trust-title" style="color:var(--color-on-carbon)">Почему нам можно доверять</h2>
      <div class="stat-strip" style="margin-top:var(--space-xl)">
        <div class="stat"><div class="stat__n">2004</div><div class="stat__l">салон работает с этого года</div></div>
        <div class="stat"><div class="stat__n">1000 м²</div><div class="stat__l">собственного производства</div></div>
        <div class="stat"><div class="stat__n">3000+</div><div class="stat__l">изготовленных кухонь</div></div>
        <div class="stat"><div class="stat__n">18 мес.</div><div class="stat__l">гарантия на изделие целиком</div></div>
      </div>
      <p class="trust__note">Работаем на автоматизированных станках из Германии, Италии и Испании —
        от точности раскроя зависит, сойдётся ли кухня по месту.</p>
    </div>
  </section>

  <!-- Наши работы -->
  <section class="section" id="works" aria-labelledby="works-title">
    <div class="wrap">
      <h2 class="section__title" id="works-title">Наши работы</h2>
      <p class="section__lead measure">Всё, что вы видите, сделано на нашем производстве и стоит
        в квартирах Дзержинска и области.</p>
      <div class="slider slider--works" data-slider data-autoplay="0" tabindex="0" role="group" aria-roledescription="слайдер" aria-label="Наши работы">
        <div class="slider__viewport">
          <div class="slider__track">
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-seraya-modern.jpg" alt="Серая кухня модерн с деревянной столешницей на заказ" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/shkaf-kupe-uglovoj.jpg" alt="Угловой шкаф-купе с зеркальными фасадами на заказ" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/detskaya-stol.jpg" alt="Детская на заказ: письменный стол и стеллаж" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/garderobnaya.jpg" alt="Открытая гардеробная система на заказ" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/prihozhaya-mramor.jpg" alt="Прихожая на заказ: мрамор, зеркало, встроенный шкаф" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/kuhnya-klassika-zoloto.jpg" alt="Классическая кухня с золотой патиной на заказ" loading="lazy" decoding="async"></div></div>
            <div class="slider__slide"><div class="photo"><img class="photo__img" src="/img/detskaya-stenka.jpg" alt="Детская стенка на заказ" loading="lazy" decoding="async"></div></div>
          </div>
          <button class="slider__arrow slider__arrow--prev" type="button" aria-label="Предыдущая работа">‹</button>
          <button class="slider__arrow slider__arrow--next" type="button" aria-label="Следующая работа">›</button>
        </div>
        <div class="slider__dots" aria-hidden="true"></div>
      </div>
      <p style="margin-top:var(--space-lg)"><a class="btn btn--ghost" href="/portfolio/">Смотреть все работы</a></p>
    </div>
  </section>

  <!-- Отзывы -->
  <section class="section" aria-labelledby="rev-title">
    <div class="wrap">
      <h2 class="section__title" id="rev-title">Что говорят клиенты</h2>
      <div class="reviews-grid">
        <blockquote class="review">
          <p class="review__q">«Сделали бесплатный замер, составили эскиз, подобрали материал. Месяц ждали
            изготовление, установили за один день быстро и красиво! Рассрочка на 8 месяцев без банка,
            без переплат. Советую!»</p>
          <div class="review__who">Александр и Ирина Максимовы</div>
          <div class="review__where">отзыв с сайта</div>
        </blockquote>
        <blockquote class="review">
          <p class="review__q">«Заказывал кухню матери, сам живу в другом городе. Замерщик приехал по
            заявке, сам согласовал время. Матери понравилась кухня. Понравилось, что не пришлось
            участвовать в организации».</p>
          <div class="review__who">Александр Маркин</div>
          <div class="review__where">отзыв с сайта</div>
        </blockquote>
        <blockquote class="review">
          <p class="review__q">«Не первый раз заказываю мебель в этой организации, делают всё прекрасно,
            качественно. Спасибо, что есть такие исполнители».</p>
          <div class="review__who">Сергей Пискунов</div>
          <div class="review__where">отзыв с сайта</div>
        </blockquote>
      </div>
    </div>
  </section>

  <!-- 8 · Форма -->
  <section class="section leadform" id="form" aria-labelledby="form-title">
    <div class="wrap">
      <h2 class="section__title" id="form-title">Запишитесь на бесплатный замер</h2>
      <div class="form-grid">
        <form class="form" novalidate data-lead action="/api/lead.php" method="post">
          <input type="hidden" name="subject" value="Главная">
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
            <span>Согласен на обработку персональных данных в соответствии с <a href="/policy/">политикой</a>.</span>
          </label>
          <button class="btn" type="submit">Отправить заявку</button>
          <p class="form__status" role="status" aria-live="polite" hidden></p>
        </form>
        <aside class="form-aside">
          <p>Приедем в удобное время, снимем размеры и посчитаем стоимость. Замер бесплатный —
            даже если в итоге закажете не у нас.</p>
          <p>Заявка уходит менеджеру на почту и во ВКонтакте одновременно, поэтому не потеряется.
            Перезвоним в рабочее время — с понедельника по пятницу с 10:00 до 19:00.</p>
          <p class="ask"><a class="tlink" href="#cont-title">Не готовы к замеру? Задайте вопрос <span class="arw">→</span></a></p>
        </aside>
      </div>
    </div>
  </section>

  <!-- 9 · Контакты -->
  <section class="section" aria-labelledby="cont-title">
    <div class="wrap">
      <h2 class="section__title" id="cont-title">Приезжайте в салон</h2>
      <div class="contacts-grid">
        <dl class="contacts">
          <div><dt>Адрес</dt><dd>Дзержинск, ул. Грибоедова, д. 3</dd></div>
          <div><dt>Телефоны</dt><dd>
            <a href="tel:+79047908282">+7 904 790-82-82</a><br>
            <a href="tel:+79103847019">+7 910 384-70-19</a><br>
            <a href="tel:+78313231917">8 (8313) 23-19-17</a>
          </dd></div>
          <div><dt>Почта</dt><dd><a href="mailto:prestig-meb@mail.ru">prestig-meb@mail.ru</a></dd></div>
          <div><dt>Соцсети</dt><dd><a href="https://vk.ru/club210473860" target="_blank" rel="noopener">ВКонтакте</a> · <a href="https://www.avito.ru/dzerzhinsk/mebel_i_interer/kuhni_na_zakaz_4572454241" target="_blank" rel="noopener">Avito</a></dd></div>
          <div><dt>Часы</dt><dd>Пн–Пт 10:00–19:00<br><span style="color:var(--color-muted);font-size:var(--text-sm)">Сб, Вс — выходные. Заявки на сайте — круглосуточно</span></dd></div>
          <div><a class="btn btn--ghost" href="https://yandex.ru/maps/?rtext=~56.243204%2C43.454592&rtt=auto&z=17" target="_blank" rel="noopener">Построить маршрут</a></div>
        </dl>
        <div class="map photo"><span class="photo__label"><b>Карта</b>ул. Грибоедова, 3</span></div>
      </div>
    </div>
  </section>

</main>

<?php require PARTIALS . '/footer.php';
