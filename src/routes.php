<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/cnchelper', function () {
    $this->group('/v1', function () {

        $this->get('/', function (Request $request, Response $response) {
            $this->logger->info("GET: '/'", ["ip" => $request->getAttribute('ip_address')]);
            $res = ['response' => 1];
            return $response->withJson($res);
        });

        $this->post('/getToken', 'CNCHelper\Api:getToken');
        $this->post('/checkToken', 'CNCHelper\Api:checkToken');

    });

});