<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m240827_014717_insert_admin_user
 */
class m240827_014717_insert_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin123'); // Cambia la contraseña según prefieras
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->save(false);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $user = User::findOne(['username' => 'admin']);
        if ($user) {
            $user->delete();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240827_014717_insert_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
