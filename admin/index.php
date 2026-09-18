<?php
/* Админка сайта «Престиж». Разделы: акции, работы, отзывы, контакты, заявки.
 * Вход: логины и хэши паролей в api/config.php → 'admin_users'. */
declare(strict_types=1);
require __DIR__ . '/lib.php';
session_start_secure();

$section = preg_replace('/[^a-z]/', '', (string)($_GET['s'] ?? 'works')) ?: 'works';
$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
function flash(string $msg, bool $ok = true): void { $_SESSION['flash'] = ['msg' => $msg, 'ok' => $ok]; }
function redirect(string $to): never { header('Location: ' . $to); exit; }

/* ---------- вход / выход ---------- */
if ($section === 'logout') { alog('выход'); session_destroy(); redirect('./'); }
if (!is_logged_in()) {
    $err = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        check_csrf();
        if (try_login(clean((string)($_POST['login'] ?? ''), 50), (string)($_POST['password'] ?? ''))) redirect('./');
        $err = login_locked() ? 'Слишком много попыток. Подождите 15 минут.' : 'Неверный логин или пароль';
    }
    require __DIR__ . '/views/login.php';
    exit;
}

$TYPES = ['kuhni' => 'Кухни', 'shkafy' => 'Шкафы-купе', 'detskie' => 'Детские', 'prihozhie' => 'Прихожие'];
$MATERIALS = ['' => '—', 'plenka' => 'Плёнка ПВХ', 'plastik' => 'Пластик', 'emal' => 'Эмаль', 'massiv' => 'Массив', 'ramochnye' => 'Рамочные'];

/* ---------- обработка форм ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $action = (string)($_POST['action'] ?? '');
    try {
        switch ("$section/$action") {

        /* --- работы --- */
        case 'works/save': {
            $works = load('works');
            $rows = $_POST['w'] ?? [];
            foreach ($works as $i => &$w) {
                $r = $rows[$i] ?? null; if (!$r) continue;
                $w['alt'] = clean((string)($r['alt'] ?? ''), 200);
                $w['type'] = isset($TYPES[$r['type'] ?? '']) ? $r['type'] : $w['type'];
                $w['material'] = isset($MATERIALS[$r['material'] ?? '']) && $r['material'] !== '' ? $r['material'] : null;
                $w['portfolio'] = !empty($r['portfolio']);
                $w['home'] = ($r['home'] ?? '') !== '' ? max(1, (int)$r['home']) : null;
                $w['category'] = ($r['category'] ?? '') !== '' ? max(1, (int)$r['category']) : null;
            }
            unset($w);
            /* порядок: скрытое поле order = список индексов */
            $order = array_map('intval', array_filter(explode(',', (string)($_POST['order'] ?? '')), 'strlen'));
            if (count($order) === count($works) && count(array_unique($order)) === count($works)) {
                $works = array_map(fn($i) => $works[$i], $order);
            }
            save('works', $works);
            git_sync('работы — правка списка');
            flash('Сохранено');
            break;
        }
        case 'works/upload': {
            $works = load('works');
            $type = isset($TYPES[$_POST['type'] ?? '']) ? $_POST['type'] : 'kuhni';
            $files = $_FILES['photos'] ?? null; $n = 0; $errs = [];
            if ($files) foreach ($files['name'] as $k => $name) {
                $one = ['name' => $name, 'tmp_name' => $files['tmp_name'][$k], 'error' => $files['error'][$k]];
                if ($one['error'] === UPLOAD_ERR_NO_FILE) continue;
                try {
                    $file = store_image($one, $TYPES[$type]);
                    /* новые — в начало портфолио */
                    array_unshift($works, ['file' => $file, 'alt' => $TYPES[$type] . ' на заказ, Дзержинск', 'type' => $type,
                                           'material' => null, 'portfolio' => true, 'home' => null, 'category' => null]);
                    $n++;
                } catch (Throwable $ex) { $errs[] = e($name) . ': ' . $ex->getMessage(); }
            }
            if ($n) { save('works', $works); git_sync("работы — добавлено фото: $n"); }
            flash(($n ? "Загружено фото: $n. " : '') . ($errs ? 'Ошибки: ' . implode('; ', $errs) : ''), !$errs);
            break;
        }
        case 'works/delete': {
            $works = load('works'); $i = (int)($_POST['i'] ?? -1);
            if (isset($works[$i])) {
                remove_image($works[$i]['file']);
                array_splice($works, $i, 1);
                save('works', $works); git_sync('работы — удалено фото');
                flash('Фото удалено');
            }
            break;
        }

        /* --- акции --- */
        case 'promos/save': {
            $promos = load('promos'); $i = (int)($_POST['i'] ?? -1);
            $p = $promos[$i] ?? ['image' => '', 'alt' => ''];
            $p['title'] = clean((string)($_POST['title'] ?? ''), 120);
            $p['text'] = clean((string)($_POST['text'] ?? ''), 600);
            $p['bullets'] = lines((string)($_POST['bullets'] ?? ''));
            $p['note'] = clean((string)($_POST['note'] ?? ''), 200);
            $p['alt'] = clean((string)($_POST['alt'] ?? ''), 200) ?: $p['title'];
            $p['active'] = !empty($_POST['active']);
            if ($p['title'] === '') throw new RuntimeException('Название акции обязательно');
            if (!empty($_FILES['image']['name'])) {
                $new = store_image($_FILES['image'], 'akciya-' . $p['title']);
                remove_image($p['image']); $p['image'] = $new;
            }
            if ($p['image'] === '') throw new RuntimeException('Добавьте фото акции');
            if (isset($promos[$i])) $promos[$i] = $p; else $promos[] = $p;
            save('promos', $promos); git_sync('акции — ' . $p['title']);
            flash('Акция сохранена'); redirect('?s=promos');
        }
        case 'promos/delete': {
            $promos = load('promos'); $i = (int)($_POST['i'] ?? -1);
            if (isset($promos[$i])) { remove_image($promos[$i]['image']); array_splice($promos, $i, 1); save('promos', $promos); git_sync('акции — удаление'); flash('Акция удалена'); }
            break;
        }
        case 'promos/move': {
            $promos = load('promos'); $i = (int)($_POST['i'] ?? -1); $j = $i + (int)($_POST['dir'] ?? 0);
            if (isset($promos[$i], $promos[$j])) { [$promos[$i], $promos[$j]] = [$promos[$j], $promos[$i]]; save('promos', $promos); git_sync('акции — порядок'); }
            break;
        }

        /* --- отзывы --- */
        case 'reviews/save': {
            $out = [];
            foreach ($_POST['r'] ?? [] as $r) {
                $t = clean((string)($r['text'] ?? ''), 1000);
                if ($t === '') continue;
                $out[] = ['text' => trim($t, '«»" '), 'who' => clean((string)($r['who'] ?? ''), 80), 'where' => clean((string)($r['where'] ?? ''), 80)];
            }
            save('reviews', $out); git_sync('отзывы');
            flash('Отзывы сохранены');
            break;
        }

        /* --- контакты --- */
        case 'contacts/save': {
            $site = load('site');
            foreach (['address_short', 'address_full', 'email', 'hours', 'hours_note', 'vk', 'avito', 'route', 'requisites'] as $k) {
                $site[$k] = clean((string)($_POST[$k] ?? ''), 300);
            }
            $site['phones'] = array_map(fn($l) => ['tel' => phone_tel($l), 'text' => $l], lines((string)($_POST['phones'] ?? '')));
            if (!$site['phones']) throw new RuntimeException('Нужен хотя бы один телефон');
            if (!filter_var($site['email'], FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Проверьте адрес почты');
            save('site', $site); git_sync('контакты');
            flash('Контакты сохранены');
            break;
        }
        default:
            flash('Неизвестное действие', false);
        }
    } catch (Throwable $ex) {
        flash('Ошибка: ' . $ex->getMessage(), false);
    }
    redirect('?s=' . $section);
}

/* ---------- вывод ---------- */
$views = ['works', 'promos', 'reviews', 'contacts', 'leads'];
if (!in_array($section, $views, true)) $section = 'works';
$titles = ['works' => 'Работы', 'promos' => 'Акции', 'reviews' => 'Отзывы', 'contacts' => 'Контакты', 'leads' => 'Заявки'];
require __DIR__ . '/views/layout-top.php';
require __DIR__ . "/views/$section.php";
require __DIR__ . '/views/layout-bottom.php';
