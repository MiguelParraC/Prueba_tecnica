<?php
namespace frontend\api\modules\v1\controllers;

use yii\rest\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return ['message' => 'API index'];
    }

    public function actionTest()
    {
        // Mostrar todos los registros de ProductsPool
        return \common\models\ProductsPool::find()->asArray()->all();
    }

    public function actionHello()
    {
        return ['message' => 'Hello, World!'];
    }
}
