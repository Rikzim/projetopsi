<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Noticia;

class NoticiaSearch extends Noticia
{
    public $tipoLocalNome;

    public function rules()
    {
        return [
            [['id', 'local_id', 'ativo', 'destaque'], 'integer'],
            [['titulo', 'conteudo', 'resumo', 'data_publicacao', 'tipoLocalNome'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Noticia::find()
            ->joinWith(['localCultural.tipoLocal'])
            ->where(['noticia.ativo' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'data_publicacao' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filtro por título ou resumo (pesquisa)
        $query->andFilterWhere(['or',
            ['like', 'noticia.titulo', $this->titulo],
            ['like', 'noticia.resumo', $this->titulo],
            ['like', 'noticia.conteudo', $this->titulo],
        ]);

        // Filtro por tipo de local (categoria)
        $query->andFilterWhere(['tipo_local.id' => $this->tipoLocalNome]);

        // Filtro por local
        $query->andFilterWhere(['noticia.local_id' => $this->local_id]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Pesquisar',
            'tipoLocalNome' => 'Categoria',
        ];
    }
}