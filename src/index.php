<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

//Just for task -> should be in migrations
(new \App\Models\AddressBook())->createTable();

$routes = require base_path('/routes/web.php');
$requestRoutes = $routes[$_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD']] ?? null;
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);

$route = $requestRoutes[$path] ?? null;
$controller = $route['controller'] ?? null;
$action = $route['action'] ?? null;

if ($controller && $action) {
    (new $controller())->$action();
    exit();
}

http_response_code(404);
echo 'Page not found';
