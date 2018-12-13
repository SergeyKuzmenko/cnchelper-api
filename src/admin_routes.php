<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Admin Routes
$app->group('/v1/cnchelper/admin/', function () {

    $this->get('get_all_tokens', function (Request $request, Response $response) {
        $selectStatement = $this->db->select()->from('tokens');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        return $response->withJson($data);
    });

});