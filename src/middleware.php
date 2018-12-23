<?php
// Application middleware

//$app->add(new \Slim\Csrf\Guard);
$app->add(new RKA\Middleware\IpAddress);

$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "path" => "/admin/cnchelper", /* or ["/api", "/admin"] */
    "attribute" => "data",
    "secure" => false,
    "secret" => "JhMdheUe3FB3sj3KFLFkYNysHaPQ06P8",
    "algorithm" => ["HS256"],
    "error" => function ($response, $arguments) {
        $res = [
            'error' => true,
            'code' => 401,
            'description' => 'Unauthorized',
            'message' => $arguments["message"]
        ];
        return $response->withJson($res)->withStatus(401);
    }
]));