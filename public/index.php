<?php
session_start();

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('BASE_PATH', '/PMNM_68PM3_NguyenNhatHuy_0013968');

require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/ConnectDB.php';
require_once APP_PATH . '/core/Middleware.php';

$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'sinhvien';
$urlParts = explode('/', $url);

$controllerKey = $urlParts[0] ?? 'sinhvien';
$method = $urlParts[1] ?? 'index';

if ($controllerKey === 'login') {
    $controllerKey = 'auth';
    $method = 'login';
}

if ($controllerKey === 'logout') {
    $controllerKey = 'auth';
    $method = 'logout';
}

Middleware::handle($controllerKey, $method, BASE_PATH);

$controllerName = ucfirst(strtolower($controllerKey)) . 'Controller';
$controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    die("Không tìm thấy controller: {$controllerName}");
}

require_once $controllerFile;

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    die("Không tìm thấy phương thức: {$method}");
}

$params = array_slice($urlParts, 2);
call_user_func_array([$controller, $method], $params);
