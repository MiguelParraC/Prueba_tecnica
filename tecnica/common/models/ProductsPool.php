<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products_pool".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description Descripción del producto
 * @property int|null $status 0 => inactivo, 1 => activo, 2 => agotado
 * @property float $price
 * @property int|null $stock
 * @property int|null $category_id Relación con la tabla categorías
 * @property int|null $who_created Quien Creó
 * @property string|null $created_at Fecha de creado
 * @property int|null $who_updated Quien Actualiza
 * @property string|null $updated_at Fecha de actualizado
 *
 * @property Category $category
 * @property ProductsSales[] $productsSales
 * @property User $whoCreated
 * @property User $whoUpdated
 */
class ProductsPool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_pool';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['description'], 'string'],
            [['status', 'stock', 'category_id', 'who_created', 'who_updated'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['who_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['who_created' => 'id']],
            [['who_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['who_updated' => 'id']],

            [['description', 'status', 'stock', 'category_id', 'who_created', 'created_at', 'who_updated', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'price' => Yii::t('app', 'Price'),
            'stock' => Yii::t('app', 'Stock'),
            'category_id' => Yii::t('app', 'Category ID'),
            'who_created' => Yii::t('app', 'Who Created'),
            'created_at' => Yii::t('app', 'Created At'),
            'who_updated' => Yii::t('app', 'Who Updated'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductsSales]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductsSalesQuery
     */
    public function getProductsSales()
    {
        return $this->hasMany(ProductsSales::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[WhoCreated]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getWhoCreated()
    {
        return $this->hasOne(User::class, ['id' => 'who_created']);
    }

    /**
     * Gets query for [[WhoUpdated]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getWhoUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'who_updated']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductsPoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductsPoolQuery(get_called_class());
    }
}
