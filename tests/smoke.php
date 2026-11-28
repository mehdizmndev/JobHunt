<?php
// Ce fichier verifie automatiquement une partie essentielle de l installation.

require dirname(__DIR__) . '/config/app.php';
require dirname(__DIR__) . '/app/Core/Database.php';
require dirname(__DIR__) . '/app/Models/JobHuntData.php';

use App\Core\Database;
use App\Models\JobHuntData;

function checkSmoke(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "ECHEC: {$message}\n");
        exit(1);
    }
    echo "OK: {$message}\n";
}

try {
    $db = Database::connection();
    checkSmoke($db->query('SELECT 1')->fetchColumn() === 1, 'Connexion PDO à MySQL');

    $tables = $db->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
    foreach (['users', 'roles', 'company_profiles', 'job_offers', 'applications', 'saved_jobs'] as $table) {
        checkSmoke(in_array($table, $tables, true), 'Table SQL presente: ' . $table);
    }

    $demoAccounts = $db->query(
        "SELECT email, password_hash FROM users
         WHERE email IN ('candidate@jobhunt.test', 'company@jobhunt.test', 'admin@jobhunt.test')"
    )->fetchAll();
    checkSmoke(count($demoAccounts) === 3, 'Trois comptes de demonstration');

    $passwords = [
        'candidate@jobhunt.test' => 'Candidate123!',
        'company@jobhunt.test' => 'Company123!',
        'admin@jobhunt.test' => 'Admin123!',
    ];
    foreach ($demoAccounts as $account) {
        checkSmoke(
            password_verify($passwords[$account['email']], $account['password_hash']),
            'Mot de passe valide pour ' . $account['email']
        );
    }

    checkSmoke(count(JobHuntData::jobs()) >= 2, 'Au moins deux offres actives');
} catch (\Throwable $error) {
    fwrite(STDERR, "ECHEC: " . $error->getMessage() . "\n");
    exit(1);
}

