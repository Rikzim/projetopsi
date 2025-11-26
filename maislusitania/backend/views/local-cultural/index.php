<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Local Culturals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Create Local Cultural', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'nome',
                            [
                                'attribute' => 'tipo_id',
                                'value' => function($model) {
                                    return $model->tipo ? $model->tipo->nome : '-';
                                }
                            ],
                            'morada',
                            [
                                'attribute' => 'distrito_id',
                                'value' => function($model) {
                                    return $model->distrito ? $model->distrito->nome : '-';
                                }
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete} {bilhetes}',
                                'buttons' => [
                                    'bilhetes' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-ticket-alt"></i>',
                                            ['tipo-bilhete/index', 'local_id' => $model->id],
                                            [
                                                'title' => 'Gerir Bilhetes',
                                                'class' => 'btn btn-sm btn-info',
                                                'data-pjax' => '0',
                                            ]
                                        );
                                    },
                                ],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>