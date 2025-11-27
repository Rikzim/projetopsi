<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocalCultural;

/**
 * LocalCulturalSearch represents the model behind the search form of `common\models\LocalCultural`.
 */
class LocalCulturalSearch extends LocalCultural
{
    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_id', 'distrito_id', 'ativo'], 'integer'],
            [['nome', 'morada', 'descricao', 'horario_funcionamento', 'contacto_telefone', 'contacto_email', 'website', 'imagem_principal', 'globalSearch'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
        $query = LocalCultural::find();

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
                ['like', 'nome', $this->globalSearch],
                ['like', 'morada', $this->globalSearch],
                ['like', 'descricao', $this->globalSearch],
            ]);
        }

        // Filtros específicos
        $query->andFilterWhere([
            'id' => $this->id,
            'tipo_id' => $this->tipo_id,
            'distrito_id' => $this->distrito_id,
            'ativo' => $this->ativo,
        ]);

        return $dataProvider;
    }
}