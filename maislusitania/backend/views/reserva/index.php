<?php

use common\models\Reserva;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Gestão de Reservas
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Reserva', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                        'headerRowOptions' => ['class' => 'bg-light'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width: 60px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'utilizador_id',
                                'label' => 'Utilizador',
                                'value' => function($model) {
                                    return $model->utilizador ? Html::encode($model->utilizador->username) : '-';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'local_id',
                                'label' => 'Local',
                                'value' => function($model) {
                                    return $model->local ? Html::encode($model->local->nome) : '-';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'width: 200px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'data_visita',
                                'label' => 'Data da Visita',
                                'format' => ['date', 'php:d/m/Y'],
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'preco_total',
                                'label' => 'Preço Total',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return number_format($model->preco_total, 2, ',', ' ') . ' €';
                                },
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'estado',
                                'label' => 'Estado',
                                'value' => function($model) {
                                    if ($model->estado === Reserva::ESTADO_CONFIRMADA) {
                                        return Html::tag('span', '<i class="fas fa-check-circle mr-1"></i>Confirmada', [
                                            'class' => 'badge badge-success',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                        ]);
                                    }
                                    if ($model->estado === Reserva::ESTADO_EXPIRADO) {
                                        return Html::tag('span', '<i class="fas fa-clock mr-1"></i>Pendente', [
                                            'class' => 'badge badge-warning',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                        ]);
                                    }
                                    if ($model->estado === Reserva::ESTADO_CANCELADA) {
                                        return Html::tag('span', '<i class="fas fa-times-circle mr-1"></i>Cancelada', [
                                            'class' => 'badge badge-danger',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                        ]);
                                    }
                                    return Html::tag('span', Html::encode($model->estado), [
                                        'class' => 'badge badge-secondary',
                                        'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                    ]);
                                },
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-eye"></i>',
                                            ['view', 'id' => $model->id],
                                            [
                                                'title' => 'Ver Detalhes',
                                                'class' => 'btn btn-sm btn-info mr-1',
                                                'data-pjax' => '0',
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-edit"></i>',
                                            ['update', 'id' => $model->id],
                                            [
                                                'title' => 'Editar',
                                                'class' => 'btn btn-sm btn-warning mr-1',
                                                'data-pjax' => '0',
                                            ]
                                        );
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-trash"></i>',
                                            ['delete', 'id' => $model->id],
                                            [
                                                'title' => 'Eliminar',
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Tem a certeza que deseja eliminar esta reserva?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        );
                                    },
                                ],
                                'headerOptions' => ['style' => 'width: 180px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'text-muted small px-3 py-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                            'options' => ['class' => 'pagination pagination-sm justify-content-center mb-0'],
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>