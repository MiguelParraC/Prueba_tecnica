<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Bitacora;
use yii\helpers\ArrayHelper;

/**
 * BitacoraSearch represents the model behind the search form of `frontend\models\Bitacora`.
 */
class BitacoraSearch extends Bitacora
{
    public $lista_quien_creo, $list_action;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'accion'], 'integer'],
            [['created_at', 'descripcion'], 'safe'],
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
        $query = Bitacora::find();

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
        $this->lista_quien_creo = ArrayHelper::map(Bitacora::find()->distinct()->all(), 'user', 'user0.username');

        $bitacora = new Bitacora();
        $this->list_action = $bitacora->getActions();

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'created_at' => $this->created_at,
            'user' => $this->user,
            'accion' => $this->accion,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
