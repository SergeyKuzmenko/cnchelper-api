<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// database
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $dsn = 'mysql:host=' . $settings['host'] . ';dbname=' . $settings['db'] . ';charset=utf8';
    $user = $settings['user'];
    $pass = $settings['pass'];
    $pdo = new \Slim\PDO\Database($dsn, $user, $pass);
    return $pdo;
};

// Api Methods
$container['api'] = function ($c) {
    $api = new App\Api;
    return $api;
};