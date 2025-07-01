<?php

use yii\db\Migration;

/**
 * Class m240828_033742_add_fk_to_productsouts
 */
class m240828_033742_add_fk_to_productsouts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_whoc_productout','products_outs', 'who_created', 'user', 'id' );
        $this->addForeignKey('fk_whou_productout','products_outs', 'who_updated', 'user', 'id' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240828_033742_add_fk_to_productsouts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_033742_add_fk_to_productsouts cannot be reverted.\n";

        return false;
    }
    */
}
