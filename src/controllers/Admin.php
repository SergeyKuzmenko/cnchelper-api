<?php

namespace CNCHelper;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

class Admin
{
    public function __construct($container)
    {
        $this->db = $container->db;
        $this->settings = $container->settings;
    }

    public function index(Request $request, Response $response)
    {
        $res = ['response' => 'Admin', 'method' => $request->getMethod(), 'time' => time()];
        return $response->withJson($res);
    }

    public function login(Request $request, Response $response)
    {
        $login = $request->getParam('login');
        $password  = $request->getParam('password');

        $query = $this->db->select()->from('users')->where('login', '=', $login);
        $queryResponse = $query->execute();
        $user = $queryResponse->fetch();

        if(!$user) {
            return $response->withJson(['error' => true, 'message' => 'User Not Found'])->withStatus(401);
        }

        // verify password.
        if (!password_verify($password, $user['password'])) {
            return $response->withJson(['error' => true, 'message' => 'Wrong Password'])->withStatus(401);
        }

        $settings = $this->settings['jwt']['secret'];
        $token = JWT::encode(['id' => $user['id'], 'login' => $user['login'], 'password' => $user['password']], $settings, "HS256");

        // Write token in db
        $timeNow = date("Y-m-d H:i:s");
        $query = $this->db->update(array('token' => $token))
            ->set(array('updated_at' => $timeNow))
            ->table('users')
            ->where('id', '=', $user['id']);
        $query->execute();


        return $response->withJson(['token' => $token]);
    }

    public function tokens(Request $request, Response $response)
    {
        $query = $this->db->select()->from('tokens');
        $queryResponse = $query->execute();
        $data = $queryResponse->fetchAll();
        return $response->withJson($data);
    }
}