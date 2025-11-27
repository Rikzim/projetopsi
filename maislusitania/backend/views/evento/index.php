<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Gestão de Eventos
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Evento', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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

                            // Coluna de Imagem
                            [
                                'attribute' => 'imagem',
                                'label' => 'Imagem',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->imagem) {
                                        // Ajuste o caminho '@uploadsUrl' conforme a sua configuração real
                                        return Html::img(
                                            Yii::getAlias('@uploadsUrl') . '/' . $model->imagem,
                                            [
                                                'style' => 'width: 80px; height: 60px; object-fit: cover; border-radius: 4px;',
                                                'class' => 'img-thumbnail'
                                            ]
                                        );
                                    }
                                    return Html::tag('div', 
                                        '<i class="fas fa-calendar-day fa-2x text-muted"></i>', 
                                        ['style' => 'width: 80px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px;']
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 100px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            // Coluna de Título e Descrição curta
                            [
                                'attribute' => 'titulo',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('div', 
                                        Html::tag('strong', Html::encode($model->titulo), ['class' => 'text-dark']) .
                                        Html::tag('small', StringHelper::truncate($model->descricao, 50), ['class' => 'd-block text-muted']),
                                        ['class' => 'py-1']
                                    );
                                },
                                'headerOptions' => ['style' => 'min-width: 200px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],

                            // Coluna de Local Cultural (Assumindo relação getLocal())
                            [
                                'attribute' => 'local_id',
                                'label' => 'Local',
                                'format' => 'raw',
                                'value' => function($model) {
                                    // Verifica se a relação existe, senão mostra o ID
                                    $nomeLocal = isset($model->local) ? $model->local->nome : 'Local #' . $model->local_id;
                                    
                                    return Html::tag('span', 
                                        '<i class="fas fa-landmark mr-2"></i>' . Html::encode($nomeLocal),
                                        [
                                            'class' => 'badge badge-info',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 180px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],

                            // Coluna de Data de Início
                            [
                                'attribute' => 'data_inicio',
                                'label' => 'Data',
                                'format' => ['date', 'php:d/m/Y H:i'], // Formato de data
                                'value' => function($model) {
                                     
                                    return $model->data_inicio;
                                },
                                'contentOptions' => function ($model) {
                                    return ['class' => 'text-center align-middle font-weight-bold text-secondary'];
                                },
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                            ],

                            // Coluna de Estado (Ativo)
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
                                                    'confirm' => 'Tem a certeza que deseja eliminar este evento?',
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