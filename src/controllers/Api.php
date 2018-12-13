<?php

namespace Api;


class Api
{
    public function __construct()
    {
        echo 'Api';
    }

    public function checkToken($token){
        echo $token;
    }
}