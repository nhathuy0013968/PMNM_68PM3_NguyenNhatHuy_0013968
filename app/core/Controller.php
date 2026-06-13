<?php

class Controller
{
    protected function model(string $modelName)
    {
        $modelPath = APP_PATH . '/models/' . $modelName . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $modelName();
        }

        die("Không tìm thấy model: {$modelName}");
    }

    protected function view(string $viewPath, array $data = [], bool $useLayout = true): void
    {
        $fullPath = APP_PATH . '/views/' . $viewPath . '.php';

        if (!file_exists($fullPath)) {
            die("Không tìm thấy view: {$viewPath}");
        }

        extract($data);

        if (!$useLayout) {
            require $fullPath;
            return;
        }

        $contentView = $fullPath;
        require APP_PATH . '/views/partials/layout.php';
    }
}
