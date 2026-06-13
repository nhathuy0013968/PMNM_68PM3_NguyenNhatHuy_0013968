<?php

class Middleware
{
    public static function handle(string $controllerKey, string $method, string $basePath): void
    {
        $controllerKey = strtolower($controllerKey);
        $method = strtolower($method);

        $publicRoutes = [
            'auth/login',
        ];

        $currentRoute = $controllerKey . '/' . $method;

        if (in_array($currentRoute, $publicRoutes, true)) {
            return;
        }

        self::checkLogin($basePath);
    }

    public static function checkLogin(string $basePath = BASE_PATH): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $basePath . '/auth/login');
            exit;
        }
    }
}
