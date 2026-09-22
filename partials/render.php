<?php
/* Рендер редактируемых блоков из data/*.json. Разметка 1:1 с исходной вёрсткой —
 * классы и атрибуты здесь менять только вместе с site.css / site.js. */
declare(strict_types=1);

/* Текст → HTML с неразрывными пробелами в числах и единицах: «100 000 ₽», «2400 мм» */
function t(?string $s): string {
    $s = e($s);
    $s = preg_replace('/(\d) (?=\d{3}(?!\d))/u', '$1&nbsp;', $s);
    return preg_replace('/(\d) (₽|мм|см|м|мес|лет|года|год|дн|%)(?![\p{L}])/u', '$1&nbsp;$2', $s);
}

/* srcset: рядом с foto.jpg лежит foto-800.jpg (tools/make_sizes.py, админка делает при загрузке).
 * Браузер сам берёт версию по ширине экрана; webp подменяет nginx по заголовку Accept. */
function img_tag(array $w, string $extra = ''): string {
    $file = (string)$w['file'];
    $small = preg_replace('/\.jpe?g$/i', '-800.jpg', $file);
    $srcset = ($small !== $file && is_file(ROOT . '/img/' . $small))
        ? ' srcset="/img/' . e($small) . ' 800w, /img/' . e($file) . ' 1600w" sizes="(max-width: 700px) 100vw, 33vw"' : '';
    return '<img class="photo__img" src="/img/' . e($file) . '" alt="' . e($w['alt']) . '"' . $srcset . $extra . ' loading="lazy" decoding="async">';
}

/* Портфолио: все работы с флагом portfolio, первые 12 открыты, остальные под «Показать ещё» */
function render_portfolio(int $visible = 12): void {
    $i = 0;
    foreach (data('works') as $w) {
        if (empty($w['portfolio'])) continue;
        $cls = 'work' . ($i++ >= $visible ? ' is-collapsed' : '');
        $mat = !empty($w['material']) ? ' data-material="' . e($w['material']) . '"' : '';
        echo '      <a class="' . $cls . '" data-work data-type="' . e($w['type']) . '"' . $mat
           . ' href="/img/' . e($w['file']) . '">' . "\n"
           . '        <div class="photo">' . img_tag($w) . '</div>' . "\n"
           . '      </a>' . "\n";
    }
}

/* Слайдер «Наши работы» на главной: works с номером home, по возрастанию */
function render_home_slider(): void {
    $list = array_filter(data('works'), fn($w) => !empty($w['home']));
    usort($list, fn($a, $b) => $a['home'] <=> $b['home']);
    foreach ($list as $w) {
        echo '            <div class="slider__slide"><div class="photo">' . img_tag($w) . '</div></div>' . "\n";
    }
}

/* Лента из 4 работ на странице категории: works нужного типа с номером category */
function render_category_strip(string $type, int $max = 4): void {
    $list = array_filter(data('works'), fn($w) => $w['type'] === $type && !empty($w['category']));
    usort($list, fn($a, $b) => $a['category'] <=> $b['category']);
    foreach (array_slice($list, 0, $max) as $w) {
        echo '        <div class="photo">' . img_tag($w) . '</div>' . "\n";
    }
}

function render_reviews(): void {
    foreach (data('reviews') as $r) {
        echo '        <blockquote class="review">' . "\n"
           . '          <p class="review__q">«' . t($r['text']) . '»</p>' . "\n"
           . '          <div class="review__who">' . e($r['who']) . '</div>' . "\n"
           . '          <div class="review__where">' . e($r['where']) . '</div>' . "\n"
           . '        </blockquote>' . "\n";
    }
}

/* Карточки акций: только active */
function render_promos(): void {
    foreach (data('promos') as $p) {
        if (empty($p['active'])) continue;
        echo '        <a class="cat" href="#form" role="listitem">' . "\n"
           . '          <div class="cat__photo" style="flex:none"><div class="photo" style="aspect-ratio:3/2">'
           . '<img class="photo__img" src="/img/' . e($p['image']) . '" alt="' . e($p['alt']) . '" decoding="async" onerror="this.replaceWith(Object.assign(document.createElement(\'span\'),{className:\'photo__label\',textContent:\'фото акции\'}))"></div></div>' . "\n"
           . '          <div class="cat__body">' . "\n"
           . '            <h3 class="cat__name">' . t($p['title']) . '</h3>' . "\n"
           . '            <p class="cat__desc">' . t($p['text']) . '</p>' . "\n";
        if (!empty($p['bullets'])) {
            echo '            <ul style="margin:.7rem 0 0;padding-left:1.1rem;font-size:var(--text-sm);color:var(--color-ink-2);line-height:1.55">' . "\n";
            foreach ($p['bullets'] as $b) echo '              <li>' . t($b) . '</li>' . "\n";
            echo '            </ul>' . "\n";
        }
        if (!empty($p['note'])) {
            echo '            <p class="cat__desc" style="margin-top:.7rem;font-style:italic">' . t($p['note']) . '</p>' . "\n";
        }
        echo '          </div>' . "\n"
           . '        </a>' . "\n";
    }
}
