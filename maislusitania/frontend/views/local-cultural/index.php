<?php

use common\models\LocalCultural;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Local Culturals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-cultural-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Local Cultural', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'tipo_id',
            'morada',
            'distrito_id',
            //'descricao:ntext',
            //'horario_funcionamento',
            //'contacto_telefone',
            //'contacto_email:email',
            //'website',
            //'imagem_principal',
            //'ativo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LocalCultural $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
