<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Admin Routes
$app->group('/admin/cnchelper', function () {
    $this->group('/v1', function () {

        $this->get('/get_all_tokens', function (Request $request, Response $response) {
            $selectStatement = $this->db->select()->from('tokens');
            $stmt = $selectStatement->execute();
            $data = $stmt->fetchAll();
            return $response->withJson($data);
        });

    });
});