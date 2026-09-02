/* Hallmark · Престиж — общее поведение страниц второго уровня.
 * Главная (home.html) имеет собственный инлайн-скрипт; здесь — категория,
 * портфолио, карточка проекта, статика, материалы.
 * Всё опционально: код срабатывает только если соответствующий блок есть в DOM.
 */
(function () {
  'use strict';

  /* --- Переключатель заднего фона (аид для показа заказчику, в продакшн не идёт) --- */
  var bgSwitch = document.querySelector('[data-bg-switch]');
  if (bgSwitch) {
    bgSwitch.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        if (b.dataset.bg === 'ivory') document.documentElement.removeAttribute('data-bg');
        else document.documentElement.setAttribute('data-bg', b.dataset.bg);
        bgSwitch.querySelectorAll('button').forEach(function (x) {
          x.setAttribute('aria-pressed', String(x === b));
        });
      });
    });
  }

  /* --- Палитра акцентов (аид для показа заказчику) --- */
  var redSwitch = document.querySelector('[data-red-switch]');
  if (redSwitch) {
    redSwitch.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        if (b.dataset.set === 'burgundy') document.documentElement.removeAttribute('data-red');
        else document.documentElement.setAttribute('data-red', b.dataset.set);
        redSwitch.querySelectorAll('button').forEach(function (x) {
          x.setAttribute('aria-pressed', String(x === b));
        });
      });
    });
  }

  /* --- Бургер-меню --- */
  var burger = document.querySelector('.burger');
  var nav = document.querySelector('.mastnav');
  if (burger && nav) {
    burger.addEventListener('click', function () {
      var open = nav.style.display === 'block';
      nav.style.display = open ? '' : 'block';
      burger.setAttribute('aria-expanded', String(!open));
    });
  }

  /* --- Липкая мобильная CTA: появляется после прокрутки первого экрана --- */
  var sticky = document.querySelector('.sticky-cta');
  if (sticky) {
    var onScroll = function () {
      sticky.classList.toggle('is-shown', window.scrollY > 480);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* --- Портфолио: фильтр по типу + постраничный показ (старт 4, шаг +4,
         «Показать все фото» — со второго нажатия «Показать ещё») --- */
  var pgrid = document.querySelector('[data-portfolio]');
  if (pgrid) {
    var typeWrap = document.querySelector('[data-type-filter]');
    var moreBtn = document.querySelector('[data-load-more]');
    var allBtn = document.querySelector('[data-load-all]');
    var BASE = 4, STEP = 4;
    var curType = 'all', shown = BASE;
    var works = Array.prototype.slice.call(pgrid.querySelectorAll('[data-work]'));

    var render = function () {
      var matched = 0;
      works.forEach(function (w) {
        var ok = curType === 'all' || w.dataset.type === curType;
        w.classList.toggle('is-hidden', !ok);
        if (ok) {
          matched++;
          w.classList.toggle('is-collapsed', matched > shown);
        } else {
          w.classList.remove('is-collapsed');
        }
      });
      var remaining = matched - shown;
      if (moreBtn) moreBtn.hidden = remaining <= 0;
      if (allBtn) allBtn.hidden = !(remaining > 0 && shown >= BASE + 2 * STEP);
    };

    if (typeWrap) typeWrap.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        curType = b.dataset.type; shown = BASE;
        typeWrap.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        render();
      });
    });

    if (moreBtn) moreBtn.addEventListener('click', function () { shown += STEP; render(); });
    if (allBtn) allBtn.addEventListener('click', function () { shown = Infinity; render(); });

    render();
  }

  /* --- Свёрнутый каталог RAL: кнопка «Показать все» / «Свернуть» --- */
  var ralCat = document.querySelector('[data-ral-cat]');
  var ralToggle = document.querySelector('[data-ral-toggle]');
  var setRal = function (expanded) {
    if (!ralCat) return;
    ralCat.classList.toggle('is-clamped', !expanded);
    if (ralToggle) {
      ralToggle.setAttribute('aria-expanded', String(expanded));
      ralToggle.textContent = expanded ? 'Свернуть палитру' : 'Показать все 216 цветов';
    }
  };
  if (ralToggle && ralCat) {
    ralToggle.addEventListener('click', function () {
      setRal(ralCat.classList.contains('is-clamped'));
    });
  }

  /* --- «Проявление проекта»: чертёж → цветной рендер один раз при прокрутке --- */
  var reveals = document.querySelectorAll('[data-reveal]');
  if (reveals.length) {
    reveals.forEach(function (r) { r.classList.add('reveal--armed'); });
    if ('IntersectionObserver' in window) {
      var rio = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) { e.target.classList.add('is-revealed'); rio.unobserve(e.target); }
        });
      }, { threshold: 0.35 });
      reveals.forEach(function (r) { rio.observe(r); });
    } else {
      reveals.forEach(function (r) { r.classList.add('is-revealed'); });
    }
  }

  /* --- Слайдеры фото (главная: hero и «Наши работы») --- */
  var sliders = document.querySelectorAll('[data-slider]');
  if (sliders.length) {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    Array.prototype.forEach.call(sliders, function (root) {
      var track = root.querySelector('.slider__track');
      if (!track) return;
      var slides = Array.prototype.slice.call(track.children);
      if (slides.length < 2) return;

      var idx = 0, timer = null;
      var delay = parseInt(root.getAttribute('data-autoplay'), 10) || 0;
      var dotsWrap = root.querySelector('.slider__dots');
      var dots = [];
      var thumbs = Array.prototype.slice.call(root.querySelectorAll('[data-slider-thumb]'));

      var go = function (n) {
        idx = (n % slides.length + slides.length) % slides.length;
        track.style.transform = 'translateX(' + (-idx * 100) + '%)';
        dots.forEach(function (d, i) { d.setAttribute('aria-current', String(i === idx)); });
        thumbs.forEach(function (t, i) { t.setAttribute('aria-current', String(i === idx)); });
        slides.forEach(function (s, i) { s.setAttribute('aria-hidden', String(i !== idx)); });
      };
      var next = function () { go(idx + 1); };
      var prev = function () { go(idx - 1); };

      var stop = function () { if (timer) { clearInterval(timer); timer = null; } };
      var start = function () { if (delay && !reduce && !timer) timer = setInterval(next, delay); };
      var rearm = function () { stop(); start(); };

      if (dotsWrap) slides.forEach(function (s, i) {
        var d = document.createElement('button');
        d.type = 'button';
        d.className = 'slider__dot';
        d.setAttribute('aria-label', 'Слайд ' + (i + 1));
        d.addEventListener('click', function () { go(i); rearm(); });
        dotsWrap.appendChild(d);
        dots.push(d);
      });

      thumbs.forEach(function (t, i) {
        t.addEventListener('click', function () { go(i); rearm(); });
      });

      var prevBtn = root.querySelector('.slider__arrow--prev');
      var nextBtn = root.querySelector('.slider__arrow--next');
      if (prevBtn) prevBtn.addEventListener('click', function () { prev(); rearm(); });
      if (nextBtn) nextBtn.addEventListener('click', function () { next(); rearm(); });

      root.addEventListener('mouseenter', stop);
      root.addEventListener('mouseleave', start);
      root.addEventListener('focusin', stop);
      root.addEventListener('focusout', start);
      root.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { prev(); rearm(); }
        else if (e.key === 'ArrowRight') { next(); rearm(); }
      });

      var x0 = null;
      root.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
      root.addEventListener('touchend', function (e) {
        if (x0 === null) return;
        var dx = e.changedTouches[0].clientX - x0;
        if (Math.abs(dx) > 40) { if (dx < 0) next(); else prev(); rearm(); }
        x0 = null;
      }, { passive: true });

      go(0);
      start();
    });
  }

  /* --- Лайтбокс портфолио: клик по плитке открывает фото крупно --- */
  var tiles = Array.prototype.slice.call(
    document.querySelectorAll('[data-portfolio] .work')
  ).filter(function (w) { return w.querySelector('.photo__img'); });

  if (tiles.length) {
    var lb = document.createElement('div');
    lb.className = 'lightbox';
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-modal', 'true');
    lb.setAttribute('aria-label', 'Просмотр фотографии');
    lb.innerHTML =
      '<button class="lightbox__close" type="button" aria-label="Закрыть">✕</button>' +
      '<button class="lightbox__btn lightbox__prev" type="button" aria-label="Предыдущее">‹</button>' +
      '<img class="lightbox__img" alt="">' +
      '<button class="lightbox__btn lightbox__next" type="button" aria-label="Следующее">›</button>' +
      '<p class="lightbox__cap"></p>';
    document.body.appendChild(lb);

    var lbImg = lb.querySelector('.lightbox__img');
    var lbCap = lb.querySelector('.lightbox__cap');
    var cur = 0;

    var show = function (i) {
      cur = (i + tiles.length) % tiles.length;
      var img = tiles[cur].querySelector('.photo__img');
      var cap = tiles[cur].querySelector('.work__cap');
      lbImg.src = img.currentSrc || img.src;
      lbImg.alt = img.alt || '';
      lbCap.textContent = cap ? cap.textContent.trim() : (img.alt || '');
    };
    var open = function (i) { show(i); lb.classList.add('is-open'); document.body.style.overflow = 'hidden'; };
    var close = function () { lb.classList.remove('is-open'); document.body.style.overflow = ''; };

    tiles.forEach(function (w, i) {
      w.addEventListener('click', function (e) {
        e.preventDefault();
        open(i);
      });
    });

    lb.querySelector('.lightbox__close').addEventListener('click', close);
    lb.querySelector('.lightbox__prev').addEventListener('click', function (e) { e.stopPropagation(); show(cur - 1); });
    lb.querySelector('.lightbox__next').addEventListener('click', function (e) { e.stopPropagation(); show(cur + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') close();
      else if (e.key === 'ArrowLeft') show(cur - 1);
      else if (e.key === 'ArrowRight') show(cur + 1);
    });
  }

  /* --- Фильтр каталога образцов по производителю (материалы) --- */
  var swWrap = document.querySelector('[data-swatch]');
  if (swWrap) {
    var swFilter = document.querySelector('[data-swatch-filter]');
    if (swFilter) swFilter.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        var f = b.dataset.producer;
        swWrap.querySelectorAll('.swatch').forEach(function (s) {
          s.classList.toggle('is-hidden', !(f === 'all' || s.dataset.producer === f));
        });
        swFilter.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        if (ralCat) setRal(true);   /* выбор группы — разворачиваем каталог целиком */
      });
    });
  }
})();
