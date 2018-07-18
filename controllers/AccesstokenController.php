<?php

namespace app\controllers;

use Firebase\JWT\JWT;

class AccesstokenController extends \yii\rest\Controller
{
    public function actionIndex()
    {

    }

    public function actionCreate()
    {
        return 'AAA';
    }
    public function actionRefresh($refresh_token=717171)
    {
        $payload = [
            "sub" => "Access Token",
            "name" => "John Doe",
            "admin" => true
        ];
        $secret = 'secret';

        return ["jwt" => JWT::encode($payload, $secret), "refresh_token" => $refresh_token];
    }
}
