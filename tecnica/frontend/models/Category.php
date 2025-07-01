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
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'who_created' => Yii::t('app', 'Who Created'),
            'created_at' => Yii::t('app', 'Created At'),
            'who_updated' => Yii::t('app', 'Who Updated'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
