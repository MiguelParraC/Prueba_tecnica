<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $verification_token
 * @property int|null $profile 1 => Administrador, 2=> Almacenista
 * @property int|null $see_invet
 * @property int|null $add_new_product
 * @property int|null $add_num_products
 * @property int|null $activate_products
 * @property int|null $see_out_product
 * @property int|null $out_product
 * @property int|null $see_history
 *
 * @property Bitacora[] $bitacoras
 * @property Category[] $categories
 * @property Category[] $categories0
 * @property ProductsOuts[] $productsOuts
 * @property ProductsOuts[] $productsOuts0
 * @property ProductsPool[] $productsPools
 * @property ProductsPool[] $productsPools0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'profile', 'see_invet', 'add_new_product', 'add_num_products', 'activate_products', 'see_out_product', 'out_product', 'see_history'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'profile' => Yii::t('app', 'Profile'),
            'see_invet' => Yii::t('app', 'See Invet'),
            'add_new_product' => Yii::t('app', 'Add New Product'),
            'add_num_products' => Yii::t('app', 'Add Num Products'),
            'activate_products' => Yii::t('app', 'Activate Products'),
            'see_out_product' => Yii::t('app', 'See Out Product'),
            'out_product' => Yii::t('app', 'Out Product'),
            'see_history' => Yii::t('app', 'See History'),
        ];
    }

    /**
     * Gets query for [[Bitacoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBitacoras()
    {
        return $this->hasMany(Bitacora::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['who_created' => 'id']);
    }

    /**
     * Gets query for [[Categories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories0()
    {
        return $this->hasMany(Category::class, ['who_updated' => 'id']);
    }

    /**
     * Gets query for [[ProductsOuts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOuts()
    {
        return $this->hasMany(ProductsOuts::class, ['who_created' => 'id']);
    }

    /**
     * Gets query for [[ProductsOuts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOuts0()
    {
        return $this->hasMany(ProductsOuts::class, ['who_updated' => 'id']);
    }

    /**
     * Gets query for [[ProductsPools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPools()
    {
        return $this->hasMany(ProductsPool::class, ['who_created' => 'id']);
    }

    /**
     * Gets query for [[ProductsPools0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPools0()
    {
        return $this->hasMany(ProductsPool::class, ['who_updated' => 'id']);
    }
}
