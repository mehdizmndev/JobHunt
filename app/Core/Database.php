<?php
// Ce fichier fournit une fonction centrale reutilisee par JobHunt.

namespace App\Core;

class Database
{
    private static $db;

    public static function connection()
    {
        if (self::$db) {
            return self::$db;
        }
        $config = require dirname(__DIR__, 2) . '/config/database.php';
        $dsn = "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        self::$db = new \PDO($dsn, $config['username'], $config['password'], $config['options']);
        return self::$db;
    }
}
