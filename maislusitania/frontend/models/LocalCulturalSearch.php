<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocalCultural;

/**
 * LocalCulturalSearch represents the model behind the search form of `common\models\LocalCultural`.
 */
class LocalCulturalSearch extends LocalCultural
{
    public $search;  // Campo de pesquisa geral
    public $tipo;    // Filtro por tipo (alias para tipo_id)
    public $distrito; // Filtro por distrito (alias para distrito_id)
    public $order;   // Campo para ordenação

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_id', 'distrito_id', 'ativo'], 'integer'],
            [['nome', 'morada', 'descricao', 'horario_funcionamento', 'contacto_telefone', 'contacto_email', 'website', 'imagem_principal'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['search', 'tipo', 'distrito', 'order'], 'safe'], // Adicionar campos customizados
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
        $query = LocalCultural::find()
            ->joinWith(['tipoLocal', 'distrito'])
            ->where(['local_cultural.ativo' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => [
                    'nome' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // ===== FILTROS CUSTOMIZADOS =====
        
        // Filtro de pesquisa geral (nome, descrição, morada)
        if (!empty($this->search)) {
            $query->andFilterWhere(['or',
                ['like', 'local_cultural.nome', $this->search],
                ['like', 'local_cultural.descricao', $this->search],
                ['like', 'local_cultural.morada', $this->search],
            ]);
        }

        // Filtro por tipo (categoria)
        if (!empty($this->tipo)) {
            $query->andFilterWhere(['local_cultural.tipo_id' => $this->tipo]);
        }

        // Filtro por distrito (região)
        if (!empty($this->distrito)) {
            $query->andFilterWhere(['local_cultural.distrito_id' => $this->distrito]);
        }

        // Ordenação customizada
        if (!empty($this->order)) {
            switch ($this->order) {
                case 'nome':
                    $query->orderBy(['local_cultural.nome' => SORT_ASC]);
                    break;
                case 'nome-desc':
                    $query->orderBy(['local_cultural.nome' => SORT_DESC]);
                    break;
                case 'rating':
                    // Se tiver campo de rating/avaliação, use aqui
                    // $query->orderBy(['rating' => SORT_DESC]);
                    $query->orderBy(['local_cultural.nome' => SORT_ASC]); // Fallback
                    break;
                default:
                    $query->orderBy(['local_cultural.nome' => SORT_ASC]);
                    break;
            }
        }

        // ===== FILTROS GERADOS PELO GII (mantidos como backup) =====
        
        // grid filtering conditions
        $query->andFilterWhere([
            'local_cultural.id' => $this->id,
            'local_cultural.tipo_id' => $this->tipo_id,
            'local_cultural.distrito_id' => $this->distrito_id,
            'local_cultural.latitude' => $this->latitude,
            'local_cultural.longitude' => $this->longitude,
        ]);

        $query->andFilterWhere(['like', 'local_cultural.horario_funcionamento', $this->horario_funcionamento])
            ->andFilterWhere(['like', 'local_cultural.contacto_telefone', $this->contacto_telefone])
            ->andFilterWhere(['like', 'local_cultural.contacto_email', $this->contacto_email])
            ->andFilterWhere(['like', 'local_cultural.website', $this->website])
            ->andFilterWhere(['like', 'local_cultural.imagem_principal', $this->imagem_principal]);

        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'search' => 'Pesquisar',
            'tipo' => 'Categoria',
            'distrito' => 'Região',
            'order' => 'Ordenar Por',
        ]);
    }
}