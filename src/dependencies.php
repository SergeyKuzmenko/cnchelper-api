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
    return new \Slim\PDO\Database($dsn, $user, $pass);

};

// get container in controller
$container['api'] = function ($container) {
    return new CNCHelper\Api($container);
};

// custom page for error 404
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $c->logger->info("Error 404", ['url' => $request->getUri()->getPath(),"ip" => $request->getAttribute('ip_address')]);

        $res = [
            'error' => 404,
            'description' => 'Page not found'

        ];

        return $response->withJson($res)->withStatus(404);
    };
};

// custom page for error 405
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $c->logger->info("Error 405", ['url' => $request->getUri()->getPath(),"ip" => $request->getAttribute('ip_address')]);
        $res = [
            'error' => 405,
            'description' => 'Method not allowed. Method must be one of: '.implode(', ', $methods)

        ];
        return $response->withJson($res)->withStatus(405);
    };
};

// custom page for error 500
//$container['notFoundHandler'] = function ($c) {
//    return function ($request, $response, $exception) use ($c) {
//        $c->logger->info("Error 500", ['url' => $request->getUri()->getPath(), "ip" => $request->getAttribute('ip_address')]);
//        $res = [
//            'error' => 500,
//            'description' => 'Internal Error'
//        ];
//        return $response->withJson($res)->withStatus(500);
//    };
//};

