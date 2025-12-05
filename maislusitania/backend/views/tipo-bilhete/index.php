<?php

use common\models\TipoBilhete;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\TipoBilheteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\LocalCultural $localCultural */

$this->params['breadcrumbs'][] = ['label' => 'Locais Culturais', 'url' => ['local-cultural/index']];
$this->params['breadcrumbs'][] = ['label' => $localCultural->nome, 'url' => ['local-cultural/view', 'id' => $localCultural->id]];
$this->params['breadcrumbs'][] = 'Tipos de Bilhete';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Gestão de Tipos de Bilhete - <?= Html::encode($localCultural->nome) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['local-cultural/index'], ['class' => 'btn btn-secondary btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Tipo de Bilhete', ['create', 'local_id' => $localCultural->id], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>
                
                <!-- Filtros e Pesquisa -->
                <div class="card-body border-bottom">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action' => ['index', 'local_id' => $localCultural->id],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => true,
                            'id' => 'tipo-bilhete-filter-form'
                        ],
                    ]); ?>
                    
                    <div class="row align-items-center">
                        <!-- Campo de Pesquisa Geral -->
                        <div class="col-lg-6 col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <?= Html::activeTextInput($searchModel, 'globalSearch', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pesquisar por nome ou descrição...'
                                ]) ?>
                            </div>
                        </div>
                        
                        <!-- Filtro por Estado -->
                        <div class="col-lg-3 col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'ativo', 
                                [
                                    1 => 'Ativo',
                                    0 => 'Inativo',
                                ],
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Estados',
                                    'onchange' => '$("#tipo-bilhete-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Botões -->
                        <div class="col-lg-3 col-md-3 mb-2">
                            <div class="btn-group w-100">
                                <?= Html::submitButton('<i class="fas fa-search"></i>', [
                                    'class' => 'btn btn-primary btn-sm',
                                    'title' => 'Pesquisar'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-redo"></i>', ['index', 'local_id' => $localCultural->id], [
                                    'class' => 'btn btn-secondary btn-sm',
                                    'title' => 'Limpar Filtros'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>

                <div class="card-body p-0">
                    <?php Pjax::begin(['id' => 'tipo-bilhete-pjax']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{summary}\n{pager}",
                        'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                        'headerRowOptions' => ['class' => 'bg-light'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'attribute' => 'nome',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('div', 
                                        Html::tag('strong', Html::encode($model->nome), ['class' => 'text-dark']) .
                                        Html::tag('small', Html::encode($model->descricao), ['class' => 'd-block text-muted']),
                                        ['class' => 'py-1']
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 300px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            [
                                'attribute' => 'preco',
                                'label' => 'Preço',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('span',
                                        '<i class="fas fa-euro-sign mr-1"></i>' . number_format($model->preco, 2, ',', ' '),
                                        [
                                            'class' => 'badge badge-info',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                        ]
                                    );
                                },
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
                                            '<i class="fas fa-check-circle mr-1"></i>Ativo',
                                            [
                                                'class' => 'badge badge-success',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                            ]
                                        );
                                    }
                                    return Html::tag('span',
                                        '<i class="fas fa-times-circle mr-1"></i>Inativo',
                                        [
                                            'class' => 'badge badge-danger',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            [
                                'class' => ActionColumn::class,
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
                                    'delete' => function ($url, $model, $key) use ($localCultural) {
                                        return Html::a(
                                            '<i class="fas fa-trash"></i>',
                                            ['delete', 'id' => $model->id, 'local_id' => $localCultural->id],
                                            [
                                                'title' => 'Eliminar',
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Tem a certeza que deseja eliminar este tipo de bilhete?',
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
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>