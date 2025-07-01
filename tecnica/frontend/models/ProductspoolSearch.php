<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProductsPool;

use yii\helpers\ArrayHelper;

/**
 * ProductspoolSearch represents the model behind the search form of `frontend\models\ProductsPool`.
 */
class ProductspoolSearch extends ProductsPool
{
    public $list_status, $list_produc, $lista_quien_creo;
    public $product_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'stock', 'category_id', 'who_created', 'who_updated','product_id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'updated_at', 'product_id','who_created'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }



    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductsPool::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $ppool = new ProductsPool();
        $this->list_status = $ppool->getStatus();

        $this->list_produc = ArrayHelper::map(ProductsPool::find()->all(), 'id', 'name');
        $this->lista_quien_creo = ArrayHelper::map(ProductsPool::find()->distinct()->all(), 'who_created', 'whoCreated.username');
        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'status' => $this->status,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id, 
            'who_created' => $this->who_created,
            'created_at' => $this->created_at,
            'who_updated' => $this->who_updated,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['=', 'id', $this->product_id])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['like', 'name', $this->name])
            ;
        return $dataProvider;
    }
}
