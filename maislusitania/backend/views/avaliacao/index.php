<?php

use common\models\Avaliacao;
use common\models\LocalCultural;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\AvalicaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $locaisAtivos */

$this->title = 'Avaliações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star mr-2"></i>
                        Gestão de Avaliações
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Avaliação', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>
                
                <!-- Filtros e Pesquisa -->
                <div class="card-body border-bottom">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => true,
                            'id' => 'avaliacao-filter-form'
                        ],
                    ]); ?>
                    
                    <div class="row w-100">
                        <!-- Campo de Pesquisa Geral -->
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-sm w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <?= Html::activeTextInput($searchModel, 'globalSearch', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pesquisar...'
                                ]) ?>
                            </div>
                        </div>
                        
                        <!-- Filtro por Local -->
                        <div class="col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'local_id', 
                                $locaisAtivos,
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Locais',
                                    'onchange' => '$("#avaliacao-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Filtro por Classificação -->
                        <div class="col-md-2 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'classificacao', 
                                [
                                    1 => '1 Estrela',
                                    2 => '2 Estrelas',
                                    3 => '3 Estrelas',
                                    4 => '4 Estrelas',
                                    5 => '5 Estrelas',
                                ],
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todas Classificações',
                                    'onchange' => '$("#avaliacao-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Filtro por Estado -->
                        <div class="col-md-2 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'ativo', 
                                [
                                    1 => 'Ativo',
                                    0 => 'Inativo',
                                ],
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Estados',
                                    'onchange' => '$("#avaliacao-filter-form").submit()'
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
                    <?php Pjax::begin(['id' => 'avaliacao-pjax']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => false,
                        'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                        'headerRowOptions' => ['class' => 'bg-light'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'local_id',
                                'label' => 'Local',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->local) {
                                        return Html::tag('div', 
                                            Html::tag('strong', Html::encode($model->local->nome), ['class' => 'text-dark']),
                                            ['class' => 'py-1']
                                        );
                                    }
                                    return '<span class="text-muted">-</span>';
                                },
                                'headerOptions' => ['style' => 'width: 200px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            [
                                'attribute' => 'utilizador_id',
                                'label' => 'Utilizador',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->utilizador) {
                                        return Html::tag('div', 
                                            Html::tag('strong', Html::encode($model->utilizador->username), ['class' => 'text-dark']),
                                            ['class' => 'py-1']
                                        );
                                    }
                                    return '<span class="text-muted">-</span>';
                                },
                                'headerOptions' => ['style' => 'width: 180px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            [
                                'attribute' => 'classificacao',
                                'label' => 'Classificação',
                                'format' => 'raw',
                                'value' => function($model) {
                                    $stars = '';
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $model->classificacao) {
                                            $stars .= '<i class="fas fa-star text-warning"></i> ';
                                        } else {
                                            $stars .= '<i class="far fa-star text-muted"></i> ';
                                        }
                                    }
                                    return $stars;
                                },
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'comentario',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->comentario) {
                                        $comentario = Html::encode($model->comentario);
                                        if (strlen($comentario) > 100) {
                                            $comentario = substr($comentario, 0, 100) . '...';
                                        }
                                        return Html::tag('div', $comentario, ['class' => 'text-muted small']);
                                    }
                                    return '<span class="text-muted">-</span>';
                                },
                                'headerOptions' => ['style' => 'width: 300px;'],
                                'contentOptions' => ['class' => 'align-middle'],
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
                                                    'confirm' => 'Tem a certeza que deseja eliminar esta avaliação?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        );
                                    },
                                ],
                                'urlCreator' => function ($action, Avaliacao $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
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