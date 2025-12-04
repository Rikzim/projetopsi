<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reserva;

/**
 * ReservaSearch represents the model behind the search form of `common\models\Reserva`.
 */
class ReservaSearch extends Reserva
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'utilizador_id', 'local_id'], 'integer'],
            [['data_visita', 'estado', 'data_criacao', 'globalSearch'], 'safe'],
            [['preco_total'], 'number'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Reserva::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->globalSearch){
            $query->orFilterWhere(['like', 'estado', $this->globalSearch])
                  ->orFilterWhere(['like', 'data_visita', $this->globalSearch])
                  ->orFilterWhere(['like', 'data_criacao', $this->globalSearch]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'utilizador_id' => $this->utilizador_id,
            'local_id' => $this->local_id,
            'data_visita' => $this->data_visita,
            'preco_total' => $this->preco_total,
            'data_criacao' => $this->data_criacao,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
