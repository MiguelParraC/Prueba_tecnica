<?php

use yii\db\Migration;

/**
 * Class m240826_190833_change_column_users
 */
class m240826_190833_change_column_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user','created_at', $this->dateTime());
        $this->alterColumn('user','updated_at', $this->dateTime());
        $this->addColumn('user','profile',$this->integer(11)->comment('1 => Administrador, 2=> Almacenista'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user','created_at', $this->integer(11));
        $this->alterColumn('user','updated_at', $this->integer(11));
        $this->dropColumn('user','profile');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240826_190833_change_column_users cannot be reverted.\n";

        return false;
    }
    */
}
