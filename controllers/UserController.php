<?php

namespace app\controllers;

use app\models\User;
use yii\base\Exception;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;
use \Yii;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpHeaderAuth::class,
                'header' => 'X-Access-Token',
                'except' => ['signup']
            ],
        ]);
    }

    public function actionSignup()
    {
        $response = Yii::$app->getResponse();
        try {
            $model = new User;
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            $model->refresh_token = sha1($model->getJWT());

            if ($model->save()) {
                $response->setStatusCode(201);
                return ['jwt' => $model->getJWT(), 'refresh_token' => $model->refresh_token];
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            } else {
                $response->setStatusCode(422);
                return ['errors' => $model->getErrorSummary(true)];
            }
        } catch (Exception $e) {
            $response->setStatusCode(422);
            return ['errors' => $model->errors];
        }
    }

    public function actionMe()
    {
        $user = \Yii::$app->user->identity;
        return ['email' => $user->email, 'name' => $user->name, 'avatar_url' => $user->gravatar];
    }
}