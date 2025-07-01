<?php

use yii\db\Migration;

/**
 * Class m240827_011639_add_permisos_to_user
 */
class m240827_011639_add_permisos_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','see_invet', $this->tinyInteger());
        $this->addColumn('user','add_new_product', $this->tinyInteger());
        $this->addColumn('user','add_num_products', $this->tinyInteger());
        $this->addColumn('user','activate_products', $this->tinyInteger());
        $this->addColumn('user','see_out_product', $this->tinyInteger());
        $this->addColumn('user','out_product', $this->tinyInteger());
        $this->addColumn('user','see_history', $this->tinyInteger());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user','see_invet');
        $this->dropColumn('user','add_new_product');
        $this->dropColumn('user','add_num_products');
        $this->dropColumn('user','activate_products');
        $this->dropColumn('user','see_out_product');
        $this->dropColumn('user','out_product');
        $this->dropColumn('user','see_history');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240827_011639_add_permisos_to_user cannot be reverted.\n";

        return false;
    }
    */
}
