<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TipoBilhete;

/**
 * TipoBilheteSearch represents the model behind the search form of `common\models\TipoBilhete`.
 */
class TipoBilheteSearch extends TipoBilhete
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ativo', 'local_id'], 'integer'],
            [['nome', 'descricao', 'globalSearch'], 'safe'],
            [['preco'], 'number'],
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
        $query = TipoBilhete::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filtrar por local_id sempre
        $query->andFilterWhere([
            'local_id' => $this->local_id,
        ]);

        // Pesquisa global
        if (!empty($this->globalSearch)) {
            $query->andWhere([
                'or',
                ['like', 'nome', $this->globalSearch],
                ['like', 'descricao', $this->globalSearch]
            ]);
        }

        // Filtros específicos
        $query->andFilterWhere([
            'id' => $this->id,
            'preco' => $this->preco,
            'ativo' => $this->ativo,
        ]);
        
        return $dataProvider;
    }
}