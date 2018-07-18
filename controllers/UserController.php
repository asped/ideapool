<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;


class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class
            ]
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider($data)
    {

        $payload = [
            "sub" => "asdads",
            "name" => "John Doe",
            "admin" => true
        ];
        $secret = 'secret';

        $jwt = JWT::encode($payload, $secret);
        $decoded = JWT::decode($jwt, $secret, array('HS256'));

        var_dump($jwt);
        var_dump($decoded);
die;
         return "aaa";
    }
}