<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/v1/cnchelper/', function () {

    $this->get('', function (Request $request, Response $response) {
        $this->logger->info("Request: '/' - Connection", ["ip" => $request->getAttribute('ip_address')]);
        $res = [
            'response' => 1,
        ];

        return $response->withJson($res);
    });

    $this->post('get_token', function (Request $request, Response $response) {
        $this->logger->info("Request: '/get_token' - Connection", ["ip" => $request->getAttribute('ip_address')]);
        if(!isset($uuid)){
            $uuid = '';
        }
        $name = uniqid($uuid, true);

        $res = [
            'token' => $name,
        ];

        return $response->withJson($res);
    });

    $this->get('db', function (Request $request, Response $response) {
        $this->logger->info("Request: '/db' - Connection", ["ip" => $request->getAttribute('ip_address')]);
        $selectStatement = $this->db->select()->from('debug');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        return $response->withJson($data);
    });

    $this->post('get_vtoken', function (Request $request, Response $response) {
        $this->logger->info("Request: '/get_token' - Connection", ["ip" => $request->getAttribute('ip_address')]);



        $req = $request->getParsedBody();
        $uuid = $req->uuid;

        $res = [
            'uuid' => $uuid,
            'ip' => $request->getAttribute('ip_address'),

        ];

        return $response->withJson($res);
    });

    $this->get('index', function (Request $request, Response $response) {
        $this->logger->info("Request: 'index'");

        $res = ['response' => 1, 'ip' => $request->getAttribute('ip_address')];
        return $response->withJson($res);
    });

    $this->get('checkToken', function (Request $request, Response $response) {
        $this->logger->info("Request: '/checkToken' - Connection", ["ip" => $request->getAttribute('ip_address')]);

        $token = $this->api->checkToken();

        $res = ['response' => 1, 'token' => $token, 'ip' => $request->getAttribute('ip_address')];
        return $response->withJson($res);
    });

});