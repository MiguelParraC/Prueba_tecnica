<?php

namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "bitacora".
 *
 * @property int $id
 * @property string|null $created_at
 * @property int|null $user
 * @property int|null $accion
 * @property string|null $descripcion
 *
 * @property User $user0
 */
class Bitacora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bitacora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['user', 'accion'], 'integer'],
            [['descripcion'], 'string'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'user' => Yii::t('app', 'User'),
            'accion' => Yii::t('app', 'Accion'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    public function getActions(){
        return [0=> 'Creado', 1 => 'Entrada', 2 => 'Salida', 3 => 'Actualiza información'];
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
}
