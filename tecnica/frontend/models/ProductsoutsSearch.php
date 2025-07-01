<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProductsOuts;

use yii\helpers\ArrayHelper;
/**
 * ProductsoutsSearch represents the model behind the search form of `frontend\models\ProductsOuts`.
 */
class ProductsoutsSearch extends ProductsOuts
{
    public $lista_quien_creo,$lista_quien_actualiza;
    public $start_date, $end_date ;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'who_created', 'who_updated'], 'integer'],
            [['created_at', 'updated_at', 'who_created', 'start_date', 'end_date'], 'safe'],
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
        $query = ProductsOuts::find();

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

        $this->lista_quien_creo = ArrayHelper::map(ProductsOuts::find()->distinct()->all(), 'who_created', 'whoCreated.username');
        $this->lista_quien_actualiza = ArrayHelper::map(ProductsOuts::find()->distinct()->all(), 'who_updated', 'whoUpdated.username');

        if ($this->start_date && $this->end_date) {
            $query->andFilterWhere(['between', 'updated_at', $this->start_date, $this->end_date]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'who_created' => $this->who_created,
            // 'created_at' => $this->created_at,
            'who_updated' => $this->who_updated,
            // 'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
