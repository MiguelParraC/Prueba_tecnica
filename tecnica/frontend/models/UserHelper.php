<?php
namespace frontend\models;

use common\models\User;
use yii\helpers\ArrayHelper;

class UserHelper
{
    public static function getUserList()
    {
        return ArrayHelper::map(User::find()->all(), 'id', 'username');
    }
}
