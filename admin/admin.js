/* Админка: подтверждения, фильтр и перестановка работ. Без зависимостей. */
(function () {
  'use strict';

  /* Подтверждение на формах с data-confirm */
  document.querySelectorAll('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (ev) { if (!confirm(f.dataset.confirm)) ev.preventDefault(); });
  });

  var list = document.getElementById('works-list');
  if (!list) return;
  var form = document.getElementById('works-form');
  var orderField = document.getElementById('works-order');

  function renumber() {
    list.querySelectorAll('.work').forEach(function (li, n) { li.querySelector('.work__n').textContent = n + 1; });
  }
  function currentOrder() {
    return Array.prototype.map.call(list.querySelectorAll('.work'), function (li) { return li.dataset.i; }).join(',');
  }
  form.addEventListener('submit', function () { orderField.value = currentOrder(); });

  /* Фильтр по разделу — прячет карточки, порядок не трогает */
  document.querySelectorAll('[data-filter] .chip').forEach(function (chip) {
    chip.addEventListener('click', function () {
      document.querySelectorAll('[data-filter] .chip').forEach(function (c) { c.setAttribute('aria-pressed', c === chip ? 'true' : 'false'); });
      var t = chip.dataset.type;
      list.querySelectorAll('.work').forEach(function (li) { li.hidden = t !== 'all' && li.dataset.type !== t; });
    });
  });
  /* смена раздела в селекте — обновить data-type для фильтра */
  list.addEventListener('change', function (ev) {
    if (ev.target.name && /\[type\]$/.test(ev.target.name)) ev.target.closest('.work').dataset.type = ev.target.value;
  });

  /* Стрелки ↑ ↓ */
  list.addEventListener('click', function (ev) {
    var b = ev.target.closest('[data-move]');
    if (b) {
      var li = b.closest('.work'), dir = +b.dataset.move;
      var sib = dir < 0 ? li.previousElementSibling : li.nextElementSibling;
      while (sib && sib.hidden) sib = dir < 0 ? sib.previousElementSibling : sib.nextElementSibling;
      if (sib) { dir < 0 ? list.insertBefore(li, sib) : list.insertBefore(sib, li); renumber(); markDirty(); }
      return;
    }
    var d = ev.target.closest('[data-delete]');
    if (d) {
      if (!confirm('Удалить это фото с сайта?')) return;
      var df = document.getElementById('delete-form');
      df.querySelector('[name=i]').value = d.dataset.delete;
      df.submit();
    }
  });

  /* Drag & drop мышью (на телефоне — стрелки) */
  var dragging = null;
  list.addEventListener('dragstart', function (ev) {
    dragging = ev.target.closest('.work'); if (!dragging) return;
    dragging.classList.add('is-dragging'); ev.dataTransfer.effectAllowed = 'move';
    try { ev.dataTransfer.setData('text/plain', ''); } catch (e) {}
  });
  list.addEventListener('dragover', function (ev) {
    var over = ev.target.closest('.work'); if (!over || !dragging || over === dragging) return;
    ev.preventDefault();
    var r = over.getBoundingClientRect(), before = ev.clientY < r.top + r.height / 2;
    list.insertBefore(dragging, before ? over : over.nextSibling);
  });
  list.addEventListener('dragend', function () {
    if (dragging) { dragging.classList.remove('is-dragging'); dragging = null; renumber(); markDirty(); }
  });

  /* Предупреждение, если уходят с несохранёнными правками */
  var dirty = false;
  function markDirty() { dirty = true; }
  form.addEventListener('input', markDirty);
  form.addEventListener('submit', function () { dirty = false; });
  window.addEventListener('beforeunload', function (ev) { if (dirty) { ev.preventDefault(); ev.returnValue = ''; } });
})();
