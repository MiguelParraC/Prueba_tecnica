<?php

use yii\db\Migration;

/**
 * Class m240827_022342_create_tables_products
 */
class m240827_022342_create_tables_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ENGINE=InnoDB';
        // Tablas del pool de productos 
        $this->createTable(
            'products_pool',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'description' => $this->text()->comment('Descripción del producto'),
                'status' => $this->tinyInteger()->comment('0 => inactivo, 1 => activo, 2 => agotado'),
                'price' => $this->decimal(16, 2)->notNull(),
                'stock' => $this->integer()->defaultValue(0),
                'category_id' => $this->integer(11)->comment('Relación con la tabla categorías'),
                'who_created' => $this->integer(11)->comment('Quien Creó'),
                'created_at' => $this->dateTime()->comment('Fecha de creado'),
                'who_updated' => $this->integer(11)->comment('Quien Actualiza'),
                'updated_at' => $this->dateTime()->comment('Fecha de actualizado'),
            ], $tableOptions
        );

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->tinyInteger()->comment('0 => inactivo, 1 => activo'),
            'who_created' => $this->integer(11)->comment('Quien Creó'),
            'created_at' => $this->dateTime()->comment('Fecha de creado'),
            'who_updated' => $this->integer(11)->comment('Quien Actualiza'),
            'updated_at' => $this->dateTime()->comment('Fecha de actualizado'),
        ], $tableOptions);


        // llaves foráneas 
        $this->addForeignKey('fk_produtspool_user_create', 'products_pool', 'who_created', 'user', 'id');
        $this->addForeignKey('fk_produtspool_user_update1', 'products_pool', 'who_updated', 'user', 'id');
        $this->addForeignKey('fk_produtspool_category', 'products_pool', 'category_id', 'category', 'id');
        $this->addForeignKey('fk_category_user_create', 'category', 'who_created', 'user', 'id');
        $this->addForeignKey('fk_category_user_update', 'category', 'who_updated', 'user', 'id');

        $this->createTable(
            'products_sales',
            [
                'id' => $this->primaryKey(),
                'poduct_out_id' => $this->integer(11)->comment('id del movimiento de producto'),
                'product_id' => $this->integer(11)->comment('Relación con la tabla productos_pool'),
                'quantity' => $this->integer()->comment('Cantidad vendida'),
                'price' => $this->decimal(16, 2)->notNull()->comment('Precio del producto al momento de salida'),
                'exhausted' => $this->tinyInteger()->comment('0 => Se Agotó , 1 => Disponible'),
            ], $tableOptions
        );

        // llaves foráneas 
        $this->addForeignKey('fk_product_productspool', 'products_sales', 'product_id', 'products_pool', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Eliminar llaves foráneas de la tabla 'products_sales'
        $this->dropForeignKey('fk_product_productspool', 'products_sales');
        $this->dropForeignKey('fk_produtssales_user_create', 'products_sales');

        // Eliminar la tabla 'products_sales'
        $this->dropTable('products_sales');

        // Eliminar llaves foráneas de la tabla 'products_pool'
        $this->dropForeignKey('fk_produtspool_user_create', 'products_pool');
        $this->dropForeignKey('fk_produtspool_user_update', 'products_pool');

        // Eliminar la tabla 'products_pool'
        $this->dropTable('products_pool');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240827_022342_create_tables_products cannot be reverted.\n";

        return false;
    }
    */
}
