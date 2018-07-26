<?php

namespace app\controllers;

use app\models\User;
use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AccesstokenController extends \yii\rest\Controller
{
    public $params = [];

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
}
