<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Locais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tags mr-2"></i>
                        Gestão de Tipos de Locais
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Tipo de Local', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                        'headerRowOptions' => ['class' => 'bg-light'],
                        'summaryOptions' => ['class' => 'text-muted small px-3 py-2'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            // Coluna de Ícone (Visualização gráfica)
                            [
                                'attribute' => 'icone',
                                'label' => 'Ícone',
                                'format' => 'raw',
                                'value' => function($model) {
                                    // Assume que o campo 'icone' guarda uma classe do FontAwesome (ex: 'fas fa-landmark')
                                    // Se estiver vazio, mostra um ícone genérico
                                    $iconClass = $model->icone ? $model->icone : 'fas fa-tag';
                                    return Html::tag('div', 
                                        Html::tag('i', '', ['class' => $iconClass . ' fa-lg']), 
                                        [
                                            'class' => 'text-center text-primary',
                                            'title' => $iconClass
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            // Coluna de Nome
                            [
                                'attribute' => 'nome',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('strong', Html::encode($model->nome), ['class' => 'text-dark']);
                                },
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            // Coluna de Descrição
                            [
                                'attribute' => 'descricao',
                                'format' => 'ntext',
                                'contentOptions' => ['class' => 'align-middle text-muted'],
                            ],

                            // Coluna de Ações
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
                                                    'confirm' => 'Tem a certeza que deseja eliminar este tipo de local?',
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