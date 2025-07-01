<?php

use yii\db\Migration;

/**
 * Class m240827_231602_create_table_bitacora
 */
class m240827_231602_create_table_bitacora extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ENGINE=InnoDB';
        $this->createTable('bitacora', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'user' => $this->integer(11),
            'accion' => $this->tinyInteger()->comment('0=> creado, 1 => Entrada, 2 => Salida, 3 => Actualiza información'),
            'descripcion' => $this->text(),
        ], $tableOptions);

        $this->addForeignKey('fk_bitacora_user', 'bitacora', 'user', 'user', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240827_231602_create_table_bitacora cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240827_231602_create_table_bitacora cannot be reverted.\n";

        return false;
    }
    */
}
