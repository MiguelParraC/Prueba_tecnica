<?php

namespace common\models;
use common\models\User;
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

    // variables auxiliares
    public $name_user_create, $name_user_updated;
    public $list_status, $list_names, $model_action, $list_action, $list_categories;
    public $aux_stock;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['status', 'stock', 'category_id', 'who_created', 'who_updated'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name','price','status','stock', 'aux_stock'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['who_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['who_created' => 'id']],
            [['who_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['who_updated' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'NOMBRE DEL PRODUCTO'),
            'description' => Yii::t('app', 'DESCRIPCIÓN DEL PRODUCTO'),
            'status' => Yii::t('app', 'ESTADO'),
            'price' => Yii::t('app', 'PRECIO'),
            'stock' => Yii::t('app', 'Stock'),
            'category_id' => Yii::t('app', 'Category ID'),
            'who_created' => Yii::t('app', 'Quien Creó'),
            'created_at' => Yii::t('app', 'Fecha Creado'),
            'who_updated' => Yii::t('app', 'Quien Actualizó'),
            'updated_at' => Yii::t('app', 'Fecha de actualizado'),
        ];
    }

	/** 
    * Gets query for [[Category]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getCategory() 
    { 
        return $this->hasOne(Category::class, ['id' => 'category_id']); 
    }

    /**
     * Gets query for [[ProductsSales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsSales()
    {
        return $this->hasMany(ProductsSales::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[WhoCreated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWhoCreated()
    {
        return $this->hasOne(User::class, ['id' => 'who_created']);
    }

    /**
     * Gets query for [[WhoUpdated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWhoUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'who_updated']);
    }

    public function getStatus() {
        return [0 => 'Inactivo', 1 => 'Activo', 2 => 'Agotado'];
    }
}
