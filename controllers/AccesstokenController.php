<?php

namespace app\controllers;

use app\models\User;
use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\web\UnauthorizedHttpException;

class AccesstokenController extends \yii\rest\Controller
{
    public $params = [];

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpHeaderAuth::class,
                'header'=>'X-Access-Token',
                'except' => ['refresh','login']
            ],
        ]);
    }

    public function beforeAction($action)
    {
        $this->params = \Yii::$app->getRequest()->getBodyParams();
        return parent::beforeAction($action);
    }

    public function actionRefresh()
    {
        if (!in_array('refresh_token', array_keys($this->params))) {
            throw new BadRequestHttpException(\Yii::t('yii', 'Missing required parameters: {params}', [
                'params' => 'refresh_token']));
        }
        $user = User::findOne(['refresh_token' => $this->params['refresh_token']]);

        \Yii::$app->getResponse()->setStatusCode(201);
        return ['jwt' => $user->getJWT()];
    }

    public function actionLogin()
    {
        if (!in_array('email', array_keys($this->params)) || !in_array('password', array_keys($this->params))) {
            throw new BadRequestHttpException(\Yii::t('yii', 'Missing required parameters: email or password'));
        }
        $user = User::findOne(['email' => $this->params['email']]);
        if (password_verify($this->params['password'], $user->password)) {
            \Yii::$app->getResponse()->setStatusCode(201);
            return ['jwt' => $user->getJWT(), 'refresh_token' => $user->refresh_token];
        } else {
            throw new UnauthorizedHttpException(\Yii::t('yii', 'Email or password is not correct'));
        }
    }

    public function actionLogout()
    {
        if (!in_array('refresh_token', array_keys($this->params)) || \Yii::$app->user->identity->refresh_token != $this->params['refresh_token']) {
            throw new BadRequestHttpException(\Yii::t('yii', 'Missing or incorrect required parameter: refresh_token'));
        }
        if(\Yii::$app->user->logout()) {
            \Yii::$app->getResponse()->setStatusCode(204);
            return ['message' => 'User logged out'];
//        } else {
//            throw new UnauthorizedHttpException(\Yii::t('yii', 'Email or password is not correct'));
        }
    }
}
