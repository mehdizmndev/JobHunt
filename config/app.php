<?php

// Charge simplement les variables du fichier .env lorsqu'elles existent.
// Cette methode reste volontairement legere pour garder le projet facile a comprendre.
$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if ($name !== '' && !array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv($name . '=' . $value);
        }
    }
}

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
]);

return [
    'app_name' => 'JobHunt',
    'app_tagline' => "Let's Find Your Next Job.",
    'base_path' => dirname(__DIR__),
    'public_path' => dirname(__DIR__) . '/public',
    'base_url' => '/tests/jobhunt/public',
    'env' => 'development',
    'debug' => true,
    'roles' => ['candidate', 'company', 'admin'],
];
