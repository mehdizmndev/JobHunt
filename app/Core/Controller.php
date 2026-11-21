<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        $basePath = dirname(__DIR__, 2) . '/resources/views';
        $viewPath = $basePath . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view); 
        }

        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}
