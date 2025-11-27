<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Avaliacao;

/**
 * AvalicaoSearch represents the model behind the search form of `common\models\Avaliacao`.
 */
class AvalicaoSearch extends Avaliacao
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'local_id', 'utilizador_id', 'classificacao', 'ativo'], 'integer'],
            [['comentario', 'data_avaliacao', 'globalSearch'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Avaliacao::find();
        
        $query->joinWith(['local', 'utilizador']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Pesquisa global
        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['or',
                ['like', 'avaliacao.comentario', $this->globalSearch],
                ['like', 'local_cultural.nome', $this->globalSearch],
                ['like', 'user.username', $this->globalSearch],
            ]);
        }

        // Filtros específicos
        $query->andFilterWhere([
            'avaliacao.local_id' => $this->local_id,
            'avaliacao.utilizador_id' => $this->utilizador_id,
            'avaliacao.classificacao' => $this->classificacao,
            'avaliacao.ativo' => $this->ativo,
        ]);

        return $dataProvider;
    }
}