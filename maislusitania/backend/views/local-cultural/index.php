<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LocalCulturalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locais Culturais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-landmark mr-2"></i>
                        Gestão de Locais Culturais
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Local Cultural', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>
                <!-- Filtros e Pesquisa -->
                <div class="card-body border-bottom">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => true,
                            'id' => 'local-filter-form'
                        ],
                    ]); ?>
                    
                    <div class="row align-items-center">
                        <!-- Campo de Pesquisa Geral -->
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <?= Html::activeTextInput($searchModel, 'globalSearch', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pesquisar por nome ou morada...'
                                ]) ?>
                            </div>
                        </div>
                        
                        <!-- Filtro por Tipo -->
                        <div class="col-lg-2 col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'tipo_id', 
                                $tipoLocais,
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Tipos',
                                    'onchange' => '$("#local-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Filtro por Distrito -->
                        <div class="col-lg-2 col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'distrito_id', 
                                $distritos,
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Distritos',
                                    'onchange' => '$("#local-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Filtro por Estado -->
                        <div class="col-lg-2 col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'ativo', 
                                [
                                    1 => 'Ativo',
                                    0 => 'Inativo',
                                ],
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Estados',
                                    'onchange' => '$("#local-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Botões -->
                        <div class="col-lg-2 col-md-3 mb-2">
                            <div class="btn-group w-100">
                                <?= Html::submitButton('<i class="fas fa-search"></i>', [
                                    'class' => 'btn btn-primary btn-sm',
                                    'title' => 'Pesquisar'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-redo"></i>', ['index'], [
                                    'class' => 'btn btn-secondary btn-sm',
                                    'title' => 'Limpar Filtros'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>

                <div class="card-body p-0">
                    <?php Pjax::begin(['id' => 'local-pjax']); ?>
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
                                    if ($model->imagem_principal) {
                                        return Html::img(
                                            $model->getImage(),
                                            [
                                                'style' => 'width: 80px; height: 60px; object-fit: cover; border-radius: 4px;',
                                                'class' => 'img-thumbnail'
                                            ]
                                        );
                                    }
                                    return Html::tag('div', 
                                        '<i class="fas fa-image fa-2x text-muted"></i>', 
                                        [
                                            'style' => 'width: 80px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px; margin: 0 auto;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 100px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'nome',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('div', 
                                        Html::tag('strong', Html::encode($model->nome), ['class' => 'text-dark']) .
                                        Html::tag('small', Html::encode($model->morada), ['class' => 'd-block text-muted']),
                                        ['class' => 'py-1']
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 250px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            [
                                'attribute' => 'tipo_id',
                                'label' => 'Tipo',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->tipoLocal) {
                                        return Html::tag('span', 
                                            '<i class="fas fa-tag mr-2"></i>' . Html::encode($model->tipoLocal->nome),
                                            [
                                                'class' => 'badge badge-info',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                            ]
                                        );
                                    }
                                    return '<span class="text-muted">-</span>';
                                },
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'distrito_id',
                                'label' => 'Distrito',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->distrito) {
                                        return Html::tag('span',
                                            '<i class="fas fa-map-marker-alt mr-2"></i>' . Html::encode($model->distrito->nome),
                                            [
                                                'class' => 'badge badge-secondary',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                            ]
                                        );
                                    }
                                    return '<span class="text-muted">-</span>';
                                },
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
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
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Ações',
                                'template' => '{view} {update} {bilhetes} {delete}',
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
                                    'bilhetes' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-ticket-alt"></i>',
                                            ['tipo-bilhete/index', 'local_id' => $model->id],
                                            [
                                                'title' => 'Gerir Bilhetes',
                                                'class' => 'btn btn-sm btn-primary mr-1',
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
                                                    'confirm' => 'Tem a certeza que deseja eliminar este local cultural?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        );
                                    },
                                ],
                                'headerOptions' => ['style' => 'width: 220px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'text-muted small px-3 py-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                            'options' => ['class' => 'pagination pagination-sm justify-content-center mb-0'],
                        ]
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>