<?php
namespace app\controllers;

use app\models\User;
use yii\data\ArrayDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use \Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
                'except' => ['create', 'signup']
            ],
        ]);
    }

    public function actionSignup()
    {
        $model = new User([
//            'scenario' => 'signup',
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->refresh_token = sha1($model->getJWT());

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
//            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        } else {

        }

        return ['jwt'=>$model->getJWT(),'refresh_token'=>$model->refresh_token];
    }

    public function actions()
    {
        $actions = parent::actions();
//        $actions['create']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider($action)
    {
        var_dump($action);
        die;

        $payload = \Yii::$app->request->post();
        $payload = [
            "sub" => "asdads",
            "name" => "John Doe",
            "admin" => true
        ];
        $secret = 'secret';

        $jwt = JWT::encode($payload, $secret);


    }
}