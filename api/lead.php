<?php
/* Приём заявок с форм сайта.
 * POST (JSON или form-data): name, phone, comment, consent, page, subject, website (honeypot).
 * Ответ JSON: {ok: true} либо {ok: false, error: "..."}.
 * Заявка уходит на почту и во ВКонтакте, дублируется в leads.log. */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$cfg = file_exists(__DIR__ . '/config.php')
    ? require __DIR__ . '/config.php'
    : require __DIR__ . '/config.example.php';

function fail($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $msg], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail('Метод не поддерживается', 405);

/* --- Входные данные: JSON или обычная форма --- */
$raw = file_get_contents('php://input');
$in = [];
if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    $in = json_decode($raw, true) ?: [];
} else {
    $in = $_POST;
}
$get = function ($k, $max = 500) use ($in) {
    $v = isset($in[$k]) ? (string)$in[$k] : '';
    $v = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $v));
    return mb_substr($v, 0, $max);
};

/* --- Антиспам: скрытое поле, которое человек не заполнит --- */
if ($get('website') !== '') {
    echo json_encode(['ok' => true]); /* боту отвечаем «ок», письмо не шлём */
    exit;
}

/* --- Антиспам: лимит по IP --- */
$ip = $_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$rateFile = sys_get_temp_dir() . '/prestige-rate-' . md5($ip);
$hits = file_exists($rateFile) ? array_filter(
    array_map('intval', file($rateFile, FILE_IGNORE_NEW_LINES)),
    function ($t) use ($cfg) { return $t > time() - $cfg['rate_window']; }
) : [];
if (count($hits) >= $cfg['rate_limit']) fail('Слишком много заявок. Позвоните нам: +7 904 790-82-82', 429);

/* --- Проверка полей --- */
$name    = $get('name', 100);
$phone   = $get('phone', 30);
$comment = $get('comment', 1000);
$page    = $get('page', 200);
$subject = $get('subject', 100);
$consent = !empty($in['consent']) && $in['consent'] !== 'false';

if ($name === '') fail('Напишите, как к вам обращаться');
$digits = preg_replace('/\D/', '', $phone);
if (strlen($digits) < 10 || strlen($digits) > 15) fail('Проверьте номер телефона');
if (!$consent) fail('Нужно согласие на обработку данных');
if (preg_match('~https?://|www\.~i', $name . ' ' . $comment)) fail('Уберите ссылки из сообщения');

/* Телефон в единый вид +7 XXX XXX-XX-XX */
if (strlen($digits) === 11 && ($digits[0] === '8' || $digits[0] === '7')) $digits = '7' . substr($digits, 1);
if (strlen($digits) === 10) $digits = '7' . $digits;
$phoneFmt = strlen($digits) === 11
    ? sprintf('+%s %s %s-%s-%s', $digits[0], substr($digits, 1, 3), substr($digits, 4, 3), substr($digits, 7, 2), substr($digits, 9, 2))
    : '+' . $digits;

$when = date('d.m.Y H:i');
$lines = [
    "Имя: $name",
    "Телефон: $phoneFmt",
];
if ($subject !== '') $lines[] = "Тема: $subject";
if ($comment !== '') $lines[] = "Комментарий: $comment";
$lines[] = "Страница: " . ($page ?: '—');
$lines[] = "Время: $when";
$text = implode("\n", $lines);

/* --- Журнал (всегда, до отправки) --- */
@file_put_contents($cfg['log_file'], "=== $when | $ip\n$text\n\n", FILE_APPEND | LOCK_EX);
file_put_contents($rateFile, implode("\n", array_merge($hits, [time()])));

/* --- Почта --- */
$mailOk = false;
if (!empty($cfg['mail_to'])) {
    $subj = '=?UTF-8?B?' . base64_encode("Заявка с сайта: $name, $phoneFmt") . '?=';
    $fromName = '=?UTF-8?B?' . base64_encode($cfg['mail_from_name']) . '?=';
    $headers = implode("\r\n", [
        "From: $fromName <{$cfg['mail_from']}>",
        "Reply-To: {$cfg['mail_from']}",
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'X-Mailer: prestigmeb-site',
    ]);
    $mailOk = @mail($cfg['mail_to'], $subj, $text, $headers);
}

/* --- ВКонтакте: сообщение от сообщества администратору --- */
$vkOk = false;
if (!empty($cfg['vk_token']) && !empty($cfg['vk_peer_id']) && function_exists('curl_init')) {
    $ch = curl_init('https://api.vk.com/method/messages.send');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 8,
        CURLOPT_POSTFIELDS => http_build_query([
            'access_token' => $cfg['vk_token'],
            'v' => '5.199',
            'peer_id' => (int)$cfg['vk_peer_id'],
            'random_id' => random_int(1, PHP_INT_MAX),
            'message' => "Новая заявка с сайта\n\n$text",
        ]),
    ]);
    $res = json_decode((string)curl_exec($ch), true);
    curl_close($ch);
    $vkOk = isset($res['response']);
    if (!$vkOk) @file_put_contents($cfg['log_file'], "  [vk error] " . json_encode($res, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);
}

if (!$mailOk && !$vkOk) {
    /* Заявка в журнале, но ни один канал не сработал — честно говорим клиенту */
    fail('Не получилось отправить. Позвоните нам: +7 904 790-82-82', 500);
}

echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
