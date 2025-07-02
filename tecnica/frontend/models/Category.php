<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status 0 => inactivo, 1 => activo
 * @property int|null $who_created Quien Creó
 * @property string|null $created_at Fecha de creado
 * @property int|null $who_updated Quien Actualiza
 * @property string|null $updated_at Fecha de actualizado
 *
 * @property ProductsPool[] $productsPools
 * @property User $whoCreated
 * @property User $whoUpdated
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }


    public $list_categories, $list_status, $view;
    public $name_who_created, $name_who_updated;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'who_created', 'who_updated'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Nombre'),
            'status' => Yii::t('app', 'Estado'),
            'who_created' => Yii::t('app', 'Creado Por'),
            'created_at' => Yii::t('app', 'Fecha de Creación'),
            'who_updated' => Yii::t('app', 'Actualizado Por'),
            'updated_at' => Yii::t('app', 'Fecha de Actualización'),
        ];
    }

    public function getListCategories()
    {
        return \yii\helpers\ArrayHelper::map(Category::find()->where(['status' => 1])->all(), 'id', 'name');
    }

    /**
     * Gets query for [[ProductsPools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPools()
    {
        return $this->hasMany(ProductsPool::class, ['category_id' => 'id']);
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
