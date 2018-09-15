<?php

namespace app\controllers;

use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use yii\filters\auth\HttpHeaderAuth;
use yii\web\UnauthorizedHttpException;
use yii\rest\ActiveController;

class IdeaController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Idea';

    public $params = [];

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpHeaderAuth::class,
                'header'=>'X-Access-Token',
            ],
        ]);
    }

    public function beforeAction($action)
    {
        $this->params = \Yii::$app->getRequest()->getBodyParams();
        return parent::beforeAction($action);
    }

    public function actionList()
    {

        return new \yii\data\ActiveDataProvider([
            'query' => \app\models\Idea::find()->where(['created_by'=>\Yii::$app->user->id])->orderBy(['average_score'=>SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
}

}
