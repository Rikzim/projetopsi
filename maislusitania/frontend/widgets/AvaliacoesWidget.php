<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Avaliacao;
use yii\data\ActiveDataProvider;
use Yii;

class AvaliacoesWidget extends Widget
{
    public $localCulturalId;
    public $pageSize = 5;

    public function run()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Avaliacao::find()
                ->where(['local_id' => $this->localCulturalId, 'ativo' => 1])
                ->orderBy(['data_avaliacao' => SORT_DESC]),
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        $userAvaliacao = null;
        if (!Yii::$app->user->isGuest) {
            $userAvaliacao = Avaliacao::findOne([
                'local_id' => $this->localCulturalId,
                'utilizador_id' => Yii::$app->user->id,
                'ativo' => 1
            ]);
        }

        return $this->render('avaliacoes', [
            'dataProvider' => $dataProvider,
            'userAvaliacao' => $userAvaliacao,
            'localCulturalId' => $this->localCulturalId,
            'canAdd' => Yii::$app->user->can('addReview'),
            'canEdit' => Yii::$app->user->can('editOwnReview'),
            'canDelete' => Yii::$app->user->can('deleteOwnReview'),
        ]);
    }
}
