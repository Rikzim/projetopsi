<?php

use common\Models\TipoBilhete;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tipo Bilhetes';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/local-cultural/index.css');
?>
<div class="tipo-bilhete-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Bilhete', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'descricao',
            'preco',
            'ativo',
            //'local_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoBilhete $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
