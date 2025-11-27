<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestão de Notícias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-newspaper mr-2"></i>
                        Gestão de Notícias
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Notícia', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
                                'attribute' => 'imagem',
                                'label' => 'Imagem',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->imagem) {
                                        return Html::img(
                                            Yii::getAlias('@uploadsUrl') . '/' . $model->imagem,
                                            [
                                                'style' => 'width: 80px; height: 60px; object-fit: cover; border-radius: 4px;',
                                                'class' => 'img-thumbnail'
                                            ]
                                        );
                                    }
                                    return Html::tag('div', 
                                        '<i class="fas fa-image fa-2x text-muted"></i>', 
                                        [
                                            'style' => 'width: 80px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px; margin: 0 auto;',
                                            'class' => 'img-thumbnail'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 100px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'titulo',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('div', 
                                        Html::tag('strong', Html::encode($model->titulo), ['class' => 'text-dark']) .
                                        Html::tag('small', Html::encode($model->resumo), ['class' => 'd-block text-muted']),
                                        ['class' => 'py-1']
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 250px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            [
                                'attribute' => 'data_publicacao',
                                'label' => 'Data',
                                'format' => ['date', 'php:d/m/Y'],
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'ativo',
                                'label' => 'Estado',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->ativo) {
                                        return Html::tag('span',
                                            '<i class="fas fa-check-circle mr-2"></i>Ativo',
                                            [
                                                'class' => 'badge badge-success',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                            ]
                                        );
                                    }
                                    return Html::tag('span',
                                        '<i class="fas fa-times-circle mr-2"></i>Inativo',
                                        [
                                            'class' => 'badge badge-danger',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'destaque',
                                'label' => 'Destaque',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->destaque) {
                                        return Html::tag('span',
                                            '<i class="fas fa-star mr-2"></i>Destaque',
                                            [
                                                'class' => 'badge badge-warning',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                            ]
                                        );
                                    }
                                    return Html::tag('span',
                                        '<i class="far fa-star mr-2"></i>Normal',
                                        [
                                            'class' => 'badge badge-secondary',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
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
                                                    'confirm' => 'Tem a certeza que deseja eliminar esta notícia?',
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
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>