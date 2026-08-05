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

  /* --- Галерея карточки проекта: миниатюра меняет главное фото --- */
  var gMain = document.querySelector('[data-gallery-main]');
  if (gMain) {
    var gLabel = gMain.querySelector('.photo__label');
    document.querySelectorAll('[data-gallery-thumb]').forEach(function (t) {
      t.addEventListener('click', function () {
        if (gLabel) gLabel.innerHTML = t.dataset.full || t.getAttribute('aria-label') || gLabel.innerHTML;
        document.querySelectorAll('[data-gallery-thumb]').forEach(function (x) {
          x.setAttribute('aria-current', String(x === t));
        });
      });
    });
  }

  /* --- Фильтр портфолио: тип (сквозной) + материал (только у кухонь) --- */
  var pgrid = document.querySelector('[data-portfolio]');
  if (pgrid) {
    var typeWrap = document.querySelector('[data-type-filter]');
    var subWrap = document.querySelector('[data-material-filter]');
    var curType = 'all', curMat = 'all';

    var apply = function () {
      pgrid.querySelectorAll('[data-work]').forEach(function (w) {
        var okT = curType === 'all' || w.dataset.type === curType;
        var okM = curMat === 'all' || w.dataset.material === curMat;
        w.classList.toggle('is-hidden', !(okT && okM));
      });
    };

    if (typeWrap) typeWrap.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        curType = b.dataset.type; curMat = 'all';
        typeWrap.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        if (subWrap) {
          subWrap.classList.toggle('is-hidden', curType !== 'kuhni');
          subWrap.querySelectorAll('button').forEach(function (x, i) { x.setAttribute('aria-pressed', String(i === 0)); });
        }
        apply();
      });
    });

    if (subWrap) subWrap.querySelectorAll('button').forEach(function (b) {
      b.addEventListener('click', function () {
        curMat = b.dataset.material;
        subWrap.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        apply();
      });
    });
  }

  /* --- «Показать ещё»: раскрывает свёрнутые плитки порциями --- */
  var moreBtn = document.querySelector('[data-load-more]');
  if (moreBtn) {
    var scope = pgrid || document;
    moreBtn.addEventListener('click', function () {
      var hidden = scope.querySelectorAll('.is-collapsed');
      Array.prototype.slice.call(hidden, 0, 8).forEach(function (el) { el.classList.remove('is-collapsed'); });
      if (!scope.querySelectorAll('.is-collapsed').length) moreBtn.parentNode.removeChild(moreBtn);
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
      });
    });
  }
})();
