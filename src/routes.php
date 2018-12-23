<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/cnchelper', function () {
    $this->group('/v1', function () {
        $this->map(['GET', 'POST'], '/', 'CNCHelper\Api:index');
        $this->post('/getToken', 'CNCHelper\Api:getToken');
        $this->post('/checkToken', 'CNCHelper\Api:checkToken');
    });
});

// Admin routes
$app->post('/login', 'CNCHelper\Admin:login');
$app->group('/admin/cnchelper', function () {
    $this->map(['GET', 'POST'], '/', 'CNCHelper\Admin:index');
    $this->get('/tokens', 'CNCHelper\Admin:tokens');
});