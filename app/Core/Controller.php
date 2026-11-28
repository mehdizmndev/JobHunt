<?php
// Ce fichier fournit une fonction centrale reutilisee par JobHunt.

namespace App\Core;

class Controller
{
    protected function redirect(string $page, array $query = []): void
    {
        $query = ['page' => $page] + $query;
        header('Location: index.php?' . http_build_query($query));
        exit;
    }

    protected function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): bool
    {
        return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token']);
    }

    protected function render(string $view, array $data = []): void
    {
        $basePath = dirname(__DIR__, 2) . '/resources/views';
        $viewPath = $basePath . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view); 
        }

        extract($data, EXTR_SKIP);
        $csrf_token = $this->csrfToken();
        $flash_message = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        if (str_starts_with($view, 'public.')) {
            $title = h($data['page_title'] ?? 'JobHunt · Find your next opportunity', ENT_QUOTES, 'UTF-8');
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>' . $title . '</title><link rel="stylesheet" href="assets/css/styles.css"></head><body>';
            if ($flash_message) {
                echo '<div class="container"><div class="notice notice-' . h($flash_message['type'], ENT_QUOTES, 'UTF-8') . '">' . h($flash_message['message'], ENT_QUOTES, 'UTF-8') . '</div></div>';
            }
            require $viewPath;
            echo '<script src="assets/js/app.js"></script></body></html>';
            return;
        }

        ob_start();
        require $viewPath;
        $html = ob_get_clean();
        if ($flash_message && strpos($html, '<body>') !== false) {
            $notice = '<div class="container"><div class="notice notice-' . h($flash_message['type'], ENT_QUOTES, 'UTF-8') . '">' . h($flash_message['message'], ENT_QUOTES, 'UTF-8') . '</div></div>';
            $html = preg_replace('/<body>/', '<body>' . $notice, $html, 1);
        }
        echo $html;
    }
}
