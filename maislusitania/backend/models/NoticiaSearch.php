<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Noticia;

/**
 * NoticiaSearch represents the model behind the search form of `common\models\Noticia`.
 */
class NoticiaSearch extends Noticia
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ativo', 'local_id', 'destaque'], 'integer'],
            [['titulo', 'conteudo', 'resumo', 'imagem', 'data_publicacao', 'globalSearch'], 'safe'],
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
        $query = Noticia::find();

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
            $query->orFilterWhere(['like', 'titulo', $this->globalSearch])
                ->orFilterWhere(['like', 'conteudo', $this->globalSearch])
                ->orFilterWhere(['like', 'resumo', $this->globalSearch])
                ->orFilterWhere(['like', 'imagem', $this->globalSearch]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'data_publicacao' => $this->data_publicacao,
            'ativo' => $this->ativo,
            'local_id' => $this->local_id,
            'destaque' => $this->destaque,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'conteudo', $this->conteudo])
            ->andFilterWhere(['like', 'resumo', $this->resumo])
            ->andFilterWhere(['like', 'imagem', $this->imagem]);

        return $dataProvider;
    }
}
