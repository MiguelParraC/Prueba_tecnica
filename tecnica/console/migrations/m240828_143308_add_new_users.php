<?php

use yii\db\Migration;
use common\models\User;
/**
 * Class m240828_143308_add_new_users
 */
class m240828_143308_add_new_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // admin1
        $user = new User();
        $user->username = 'admin1';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin123'); // Cambia la contraseña según prefieras
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->email = 'admin1@example.com';
        $user->status = 10;
        $user->profile = 1;
        $user->see_invet =1;
        $user->add_new_product= 1;
        $user->add_num_products= 1;
        $user->activate_products= 1;
        $user->see_out_product= 0;
        $user->out_product= 0;
        $user->see_history= 1;
        $user->save(false);

        $user = new User();
        $user->username = 'almacenista';
        $user->password_hash = Yii::$app->security->generatePasswordHash('almacenista123'); // Cambia la contraseña según prefieras
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->email = 'almacenista@example.com';
        $user->status = 10;
        $user->profile = 1;
        $user->see_invet =1;
        $user->add_new_product= 0;
        $user->add_num_products= 0;
        $user->activate_products= 0;
        $user->see_out_product= 1;
        $user->out_product= 1;
        $user->see_history= 0;
        $user->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_143308_add_new_users cannot be reverted.\n";

        return false;
    }
    */
}
