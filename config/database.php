<?php

$getValue = static function (string $name, $default) {
    $value = getenv($name);
    if ($value === false && isset($_ENV[$name])) {
        $value = $_ENV[$name];
    }
    return $value === false || $value === null || $value === '' ? $default : $value;
};

return [
    'driver' => 'mysql',
    'host' => $getValue('DB_HOST', '127.0.0.1'),
    'port' => (int) $getValue('DB_PORT', 3306),
    'database' => $getValue('DB_DATABASE', 'jobhunt'),
    'username' => $getValue('DB_USERNAME', 'root'),
    'password' => $getValue('DB_PASSWORD', ''),
    'charset' => $getValue('DB_CHARSET', 'utf8mb4'),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
