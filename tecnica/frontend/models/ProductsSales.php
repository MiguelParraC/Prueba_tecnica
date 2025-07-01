<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "products_sales".
 *
 * @property int $id
 * @property int|null $poduct_out_id id del movimiento de producto
 * @property int|null $product_id Relación con la tabla productos_pool
 * @property int|null $quantity Cantidad vendida
 * @property float $price Precio del producto al momento de salida
 * @property int|null $exhausted 0 => Se Agotó , 1 => Disponible
 *
 * @property ProductsOuts $poductOut
 * @property ProductsPool $product
 */
class ProductsSales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poduct_out_id', 'product_id', 'quantity', 'exhausted'], 'integer'],
            [['price'], 'required'],
            [['price'], 'number'],
            [['poduct_out_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOuts::class, 'targetAttribute' => ['poduct_out_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsPool::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poduct_out_id' => Yii::t('app', 'Poduct Out ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'exhausted' => Yii::t('app', 'Exhausted'),
        ];
    }

    /**
     * Gets query for [[PoductOut]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoductOut()
    {
        return $this->hasOne(ProductsOuts::class, ['id' => 'poduct_out_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ProductsPool::class, ['id' => 'product_id']);
    }
}
