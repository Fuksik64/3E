<?php


if (!function_exists('app_path')) {
    function app_path(string $path = ''): string
    {
        return __DIR__ . '/app/' . $path;
    }
}
if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return __DIR__ . $path;
    }
}
if (!function_exists('database_path')) {
    function database_path(string $path = ''): string
    {
        return __DIR__ . '/database/' . $path;
    }
}
if (!function_exists('dd')) {
    function dd($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '<pre>';
        exit;
    }
}
if (!function_exists('view')) {
    function view(string $path, array $data = [])
    {
        extract($data);
        require base_path('/views/' . $path . '.php');
    }
}
if (!function_exists('redirect_back')) {
    function redirect_back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}