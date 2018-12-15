<?php

namespace CNCHelper;

use Slim\Http\Request;
use Slim\Http\Response;


class Api
{
    public function __construct($container)
    {
        $this->db = $container->db;
        $this->logger = $container->logger;
    }

    public function getToken(Request $request, Response $response)
    {
        $this->logger->info("POST: '/getToken'", ["ip" => $request->getAttribute('ip_address'), 'uuid' => $request->getParam('uuid')]);

        $ip = $request->getAttribute('ip_address');
        $uuid = $request->getParam('uuid');
        $manufacturer = $request->getParam('manufacturer');
        $model = $request->getParam('model');
        $platform = $request->getParam('platform');
        $version = $request->getParam('version');
        $timeNow = date("Y-m-d H:i:s");
        $token = $this->generateToken($uuid);
        $note = $request->getParam('note');

        $data = [];

        if ($this->checkUuid($uuid) >= 1) {
            $query = $this->db->select(['token'])->from('tokens')->where('uuid', '=', $uuid);
            $queryResponse = $query->execute();
            $data = $queryResponse->fetch();
        } else {
            $query = $this->db->insert()
                ->into('tokens')
                ->columns(array('ip', 'uuid', 'manufacturer', 'model', 'platform', 'version', 'date_added', 'token', 'note'))
                ->values(array($ip, $uuid, $manufacturer, $model, $platform, $version, $timeNow, $token, $note));
            $query->execute();
            $data = ['token' => $token];
        }
        return $response->withJson($data);
    }

    public function checkToken(Request $request, Response $response)
    {
        $this->logger->info("POST: '/checkToken'", ["ip" => $request->getAttribute('ip_address'), 'uuid' => $request->getParam('uuid')]);

        $token = $request->getParam('token');
        $query = $this->db->select()->from('tokens')->where('token', '=', $token);
        $queryResponse = $query->execute();
        $data = $queryResponse->fetch();
        ($data) ? $data = ['token' => true] : $data = ['token' => false];
        return $response->withJson($data);
    }

    private function generateToken($uuid = null)
    {
        return md5($uuid).'-'.uniqid(null, true);
    }

    private function checkUuid($uuid)
    {
        $query = $this->db->select()->from('tokens')->where('uuid', '=', $uuid);
        $queryResponse = $query->execute();
        $data = $queryResponse->fetchAll();
        return count($data);
    }

}