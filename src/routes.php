<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/cnchelper', function () {
    $this->group('/v1', function () {

        $this->get('', function (Request $request, Response $response) {
            $this->logger->info("GET: '/'", ["ip" => $request->getAttribute('ip_address')]);
            $res = [
                'response' => 1
            ];

            return $response->withJson($res);
        });

        $this->get('/version', function (Request $request, Response $response) {
            $this->logger->info("GET: '/version'", ["ip" => $request->getAttribute('ip_address')]);
            $res = [
                'version' => '1.0.0'
            ];

            return $response->withJson($res);
        });

        $this->post('/get_token', function (Request $request, Response $response) {
            $this->logger->info("POST: '/get_token'", ["ip" => $request->getAttribute('ip_address')]);
            if (!isset($uuid)) {
                $uuid = '';
            }
            $name = uniqid($uuid, true);

            $res = [
                'token' => $name,
            ];

            return $response->withJson($res);
        });

        $this->get('/db', function (Request $request, Response $response) {
            $this->logger->info("GET: '/db'", ["ip" => $request->getAttribute('ip_address')]);
            $selectStatement = $this->db->select()->from('debug');
            $stmt = $selectStatement->execute();
            $data = $stmt->fetchAll();
            return $response->withJson($data);
        });

        $this->post('/get_vtoken', function (Request $request, Response $response) {
            $this->logger->info("POST: '/get_token'", ["ip" => $request->getAttribute('ip_address')]);


            $req = $request->getParsedBody();
            $uuid = $req->uuid;

            $res = [
                'uuid' => $uuid,
                'ip' => $request->getAttribute('ip_address'),

            ];

            return $response->withJson($res);
        });


        $this->get('/checkToken', function (Request $request, Response $response) {
            $this->logger->info("GET: '/checkToken'", ["ip" => $request->getAttribute('ip_address')]);

            $token = $this->api->checkToken('token');

            $res = ['response' => 1, 'token' => $token, 'ip' => $request->getAttribute('ip_address')];
            return $response->withJson($res);
        });

    });

});