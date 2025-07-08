<?php

namespace frontend\modules\api\controllers;

use yii\rest\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        return 'test';
    }

    public function actionHello()
    {
        return 'Hello, World!';
    }
}
