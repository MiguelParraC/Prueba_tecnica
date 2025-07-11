<?php

namespace frontend\models;
use common\models\User;

use Yii;

/**
 * This is the model class for table "products_outs".
 *
 * @property int $id
 * @property int|null $who_created Quien Creó
 * @property string|null $created_at Fecha de creado
 * @property int|null $who_updated Quien Actualiza
 * @property string|null $updated_at Fecha de actualizado
 *
 * @property ProductsSales[] $productsSales
 * @property User $whoCreated
 * @property User $whoUpdated
 */
class ProductsOuts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_outs';
    }

    public $list_products, $sales_products, $count_products, $list_action, $list_categories;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['who_created', 'who_updated'], 'integer'],
            [['sales_products'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
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
            'who_created' => Yii::t('app', 'Who Created'),
            'created_at' => Yii::t('app', 'Created At'),
            'who_updated' => Yii::t('app', 'Who Updated'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ProductsSales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsSales()
    {
        return $this->hasMany(ProductsSales::class, ['poduct_out_id' => 'id']);
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
}
