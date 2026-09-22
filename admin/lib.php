<?php
/* Админка сайта «Престиж»: общие функции.
 * Данные — data/*.json, фото — img/works/, каждое сохранение = коммит в GitHub. */
declare(strict_types=1);

define('ROOT', dirname(__DIR__));
define('DATA_DIR', ROOT . '/data');
define('UPLOAD_DIR', ROOT . '/img/works');
define('UPLOAD_URL', 'works/');           /* префикс в поле file относительно /img/ */
define('ADMIN_LOG', __DIR__ . '/admin.log');

$cfg = is_file(ROOT . '/api/config.php') ? require ROOT . '/api/config.php' : [];

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

function alog(string $msg): void {
    @file_put_contents(ADMIN_LOG, date('Y-m-d H:i:s') . ' ' . ($_SESSION['user'] ?? '-') . ' ' . $msg . "\n", FILE_APPEND | LOCK_EX);
}

/* ---------- сессия и вход ---------- */
function session_start_secure(): void {
    session_name('prestige_admin');
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/admin/', 'httponly' => true, 'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
function is_logged_in(): bool { return !empty($_SESSION['user']); }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">'; }
function check_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(400); exit('Сессия устарела — обновите страницу и повторите.');
    }
}

/* Защита от перебора: после 5 ошибок подряд с IP — пауза 15 минут */
function login_lock_file(): string { return sys_get_temp_dir() . '/prestige-admin-' . md5($_SERVER['REMOTE_ADDR'] ?? ''); }
const LOGIN_TRIES = 5;
const LOGIN_LOCK_SEC = 900;
/* [число ошибок, время последней]; после истечения паузы счётчик начинается заново */
function login_state(): array {
    $f = login_lock_file();
    if (!is_file($f)) return [0, 0];
    [$n, $t] = array_map('intval', explode(' ', (string)file_get_contents($f)) + [0, 0]);
    return time() - $t < LOGIN_LOCK_SEC ? [$n, $t] : [0, 0];
}
function mask_login(string $l): string { return $l === '' ? '(пусто)' : mb_substr($l, 0, 2) . str_repeat('*', max(1, mb_strlen($l) - 2)); }
function login_locked(): bool { return login_state()[0] >= LOGIN_TRIES; }
function login_fail(string $login): void {
    [$n] = login_state();
    file_put_contents(login_lock_file(), ($n + 1) . ' ' . time(), LOCK_EX);
    /* логин маскируем: в это поле по ошибке часто вводят пароль */
    alog('неверный пароль: ' . mask_login($login) . ' ip=' . ($_SERVER['REMOTE_ADDR'] ?? '-') . ' попытка ' . ($n + 1));
}
/* Пользователи: api/admin-users.json (пишется при смене пароля), иначе config.php → admin_users */
define('USERS_FILE', ROOT . '/api/admin-users.json');
function admin_users(): array {
    global $cfg;
    if (is_file(USERS_FILE)) return json_decode((string)file_get_contents(USERS_FILE), true) ?: [];
    return $cfg['admin_users'] ?? [];
}
function set_password(string $login, string $password): void {
    $users = admin_users();
    $users[$login] = password_hash($password, PASSWORD_DEFAULT);
    if (file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT) . "\n", LOCK_EX) === false) {
        throw new RuntimeException('Не удалось записать файл пользователей');
    }
    @chmod(USERS_FILE, 0600);
    alog('смена пароля');
}
function try_login(string $login, string $password): bool {
    $users = admin_users();
    if (login_locked()) { alog('вход при блокировке: ' . mask_login($login) . ' ip=' . ($_SERVER['REMOTE_ADDR'] ?? '-')); return false; }
    if (isset($users[$login]) && password_verify($password, $users[$login])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $login;
        @unlink(login_lock_file());
        alog('вход ip=' . ($_SERVER['REMOTE_ADDR'] ?? '-'));
        return true;
    }
    login_fail($login);
    usleep(500000);
    return false;
}
function logout(): void {
    alog('выход');
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', ['expires' => time() - 86400, 'path' => $p['path'], 'domain' => $p['domain'],
                                       'secure' => $p['secure'], 'httponly' => $p['httponly'], 'samesite' => $p['samesite']]);
    }
    session_destroy();
}

/* ---------- данные ---------- */
function load(string $name): array {
    $f = DATA_DIR . "/$name.json";
    return is_file($f) ? (json_decode((string)file_get_contents($f), true) ?: []) : [];
}
function save(string $name, array $data): void {
    $f = DATA_DIR . "/$name.json";
    $json = json_encode(array_values_if_list($data), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    $tmp = $f . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false || !rename($tmp, $f)) {
        throw new RuntimeException("Не удалось записать $name.json");
    }
}
function array_values_if_list(array $a): array { return array_is_list($a) || $a === [] ? array_values($a) : $a; }

/* Работы адресуются по стабильному id, а не по индексу: иначе две открытые вкладки
 * (удалили в одной — сохранили в другой) сдвигают правки на соседние фото. */
function new_id(): string { return bin2hex(random_bytes(4)); }
function load_works(): array {
    $works = load('works'); $added = false;
    foreach ($works as &$w) {
        if (empty($w['id']) || !is_string($w['id'])) { $w = ['id' => new_id()] + $w; $added = true; }
    }
    unset($w);
    if ($added) save('works', $works);
    return $works;
}
function works_index(array $works, string $id): ?int {
    foreach ($works as $i => $w) if (($w['id'] ?? null) === $id) return $i;
    return null;
}

function clean(string $s, int $max = 2000): string {
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $s) ?? '';
    return mb_substr(trim($s), 0, $max);
}
function lines(string $s): array {
    return array_values(array_filter(array_map(fn($l) => clean($l, 300), preg_split('/\R/u', $s) ?: []), fn($l) => $l !== ''));
}
/* «8 (8313) 23-19-17» → «+78313231917» */
function phone_tel(string $text): string {
    $d = preg_replace('/\D+/', '', $text) ?? '';
    if (strlen($d) === 11 && $d[0] === '8') $d = '7' . substr($d, 1);
    return '+' . $d;
}

/* ---------- фото ---------- */
const MAX_SIDE = 1600;
const MAX_PIXELS = 30_000_000;
function translit(string $s): string {
    static $map = ['а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'zh','з'=>'z','и'=>'i','й'=>'j','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya'];
    $s = mb_strtolower($s);
    $s = strtr($s, $map);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
    return trim($s, '-') ?: 'foto';
}
/* Принимает элемент $_FILES, кладёт перекодированный JPEG в img/works/, возвращает имя файла
 * относительно /img/ (например "works/kuhnya-2026-09-18-a1b2.jpg") или бросает исключение. */
function store_image(array $file, string $prefix): string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE
            ? 'Файл больше 20 МБ' : 'Файл не загрузился (код ' . (int)$file['error'] . ')');
    }
    $info = @getimagesize($file['tmp_name']);
    if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
        throw new RuntimeException('Нужен JPEG, PNG или WebP');
    }
    /* Размер в пикселях проверяем до декодирования: 30 Мп в GD — это уже ~120 МБ памяти */
    if ($info[0] * $info[1] > MAX_PIXELS) {
        throw new RuntimeException('Слишком большое изображение: ' . $info[0] . '×' . $info[1] . ' px (максимум 30 Мп)');
    }
    $im = @imagecreatefromstring((string)file_get_contents($file['tmp_name']));
    if (!$im) throw new RuntimeException('Не удалось прочитать изображение');

    /* поворот по EXIF (фото с телефона) */
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($file['tmp_name']);
        $o = (int)($exif['Orientation'] ?? 1);
        if ($o === 3) $im = imagerotate($im, 180, 0);
        elseif ($o === 6) $im = imagerotate($im, -90, 0);
        elseif ($o === 8) $im = imagerotate($im, 90, 0);
    }
    $w = imagesx($im); $h = imagesy($im);
    $k = min(1, MAX_SIDE / max($w, $h));
    if ($k < 1) {
        $nw = (int)round($w * $k); $nh = (int)round($h * $k);
        $dst = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dst, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($im); $im = $dst;
    }
    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
    $name = translit($prefix) . '-' . date('Ymd') . '-' . substr(bin2hex(random_bytes(3)), 0, 4) . '.jpg';
    if (!imagejpeg($im, UPLOAD_DIR . '/' . $name, 82)) throw new RuntimeException('Не удалось сохранить файл');
    /* Рядом — webp: nginx отдаст его вместо jpg браузерам, которые умеют (см. $webp_suffix) */
    if (function_exists('imagewebp')) @imagewebp($im, UPLOAD_DIR . '/' . $name . '.webp', 80);
    imagedestroy($im);
    return UPLOAD_URL . $name;
}
/* Удаляем только то, что загрузили через админку (img/works/) */
function remove_image(string $file): void {
    if (str_starts_with($file, UPLOAD_URL) && !str_contains($file, '..')) {
        @unlink(ROOT . '/img/' . $file);
        @unlink(ROOT . '/img/' . $file . '.webp');
    }
}

/* ---------- заявки ---------- */
function read_leads(int $limit = 200): array {
    global $cfg;
    $f = $cfg['log_file'] ?? ROOT . '/api/leads.log';
    if (!is_file($f)) return [];
    $blocks = preg_split('/^=== /m', (string)file_get_contents($f), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $out = [];
    foreach (array_reverse($blocks) as $b) {
        $ls = preg_split('/\R/', trim($b)) ?: [];
        [$when, $ip] = array_map('trim', explode('|', array_shift($ls) ?? '') + ['', '']);
        $fields = [];
        foreach ($ls as $l) {
            if (preg_match('/^\s*\[(\w+) error\]/', $l)) { $fields['Ошибка'] = trim($l); continue; }
            if (preg_match('/^([^:]+): ?(.*)$/u', $l, $m)) $fields[$m[1]] = $m[2];
        }
        $out[] = ['when' => $when, 'ip' => $ip, 'fields' => $fields];
        if (count($out) >= $limit) break;
    }
    return $out;
}

/* ---------- git: каждое сохранение → коммит и push в GitHub ---------- */
function git_sync(string $message): string {
    $repo = escapeshellarg(ROOT);
    $who = escapeshellarg('Престиж (админка) <admin@prestigmeb.ru>');
    $msg = escapeshellarg('Админка: ' . $message);
    $cmd = "cd $repo && git add -A data img && (git diff --cached --quiet || git -c user.name='Престиж (админка)' -c user.email=admin@prestigmeb.ru commit -q --author=$who -m $msg) && git push -q origin HEAD:main 2>&1";
    $out = (string)shell_exec($cmd . ' ; echo "exit=$?"');
    alog("git: $message → " . trim($out));
    return $out;
}
