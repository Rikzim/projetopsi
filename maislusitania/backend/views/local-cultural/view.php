<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $horarios common\models\Horario */

$this->title = $model->nome;

\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-landmark mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-ticket-alt mr-2"></i>Gerir Bilhetes', ['tipo-bilhete/index', 'local_id' => $model->id], ['class' => 'btn btn-primary btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar este local cultural?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna da Imagem -->
                        <div class="col-md-4 mb-4">
                            <div class="text-center">
                                <?php if ($model->imagem_principal): ?>
                                    <?= Html::img(
                                        '/uploads/' . $model->imagem_principal,
                                        [
                                            'class' => 'img-fluid rounded shadow-sm',
                                            'style' => 'width: 100%; max-height: 400px; object-fit: cover;',
                                            'alt' => Html::encode($model->nome)
                                        ]
                                    ) ?>
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                                        <i class="fas fa-image fa-5x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Coluna dos Detalhes -->
                        <div class="col-md-8">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => ['class' => 'table table-hover table-striped detail-view'],
                                'attributes' => [
                                    [
                                        'attribute' => 'nome',
                                        'format' => 'raw',
                                        'value' => Html::tag('strong', Html::encode($model->nome), ['class' => 'text-dark h5']),
                                    ],
                                    [
                                        'attribute' => 'tipo_id',
                                        'label' => 'Tipo',
                                        'format' => 'raw',
                                        'value' => $model->tipo ? Html::tag('span', 
                                            '<i class="fas fa-tag mr-2"></i>' . Html::encode($model->tipo->nome),
                                            ['class' => 'badge badge-info', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']
                                        ) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'morada',
                                        'format' => 'raw',
                                        'value' => '<i class="fas fa-map-marker-alt mr-2 text-muted"></i>' . Html::encode($model->morada),
                                    ],
                                    [
                                        'attribute' => 'distrito_id',
                                        'label' => 'Distrito',
                                        'format' => 'raw',
                                        'value' => $model->distrito ? Html::tag('span',
                                            '<i class="fas fa-map-marker-alt mr-2"></i>' . Html::encode($model->distrito->nome),
                                            ['class' => 'badge badge-secondary', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']
                                        ) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'descricao',
                                        'format' => 'raw',
                                        'value' => $model->descricao ? Html::tag('p', Html::encode($model->descricao), ['class' => 'text-justify mb-0']) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'contacto_telefone',
                                        'format' => 'raw',
                                        'value' => $model->contacto_telefone ? '<i class="fas fa-phone mr-2 text-muted"></i>' . Html::encode($model->contacto_telefone) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'contacto_email',
                                        'format' => 'raw',
                                        'value' => $model->contacto_email ? '<i class="fas fa-envelope mr-2 text-muted"></i>' . Html::a(Html::encode($model->contacto_email), 'mailto:' . $model->contacto_email) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'website',
                                        'format' => 'raw',
                                        'value' => $model->website ? '<i class="fas fa-globe mr-2 text-muted"></i>' . Html::a(Html::encode($model->website), $model->website, ['target' => '_blank', 'rel' => 'noopener']) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'ativo',
                                        'label' => 'Estado',
                                        'format' => 'raw',
                                        'value' => $model->ativo 
                                            ? Html::tag('span', '<i class="fas fa-check-circle mr-2"></i>Ativo', ['class' => 'badge badge-success', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'])
                                            : Html::tag('span', '<i class="fas fa-times-circle mr-2"></i>Inativo', ['class' => 'badge badge-danger', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']),
                                    ],
                                    [
                                        'label' => 'Horários',
                                        'format' => 'raw',
                                        'value' => $horario ? Html::a(
                                            '<i class="fas fa-clock mr-2"></i>Ver Horários de Funcionamento <i class="fas fa-chevron-down ml-2"></i>',
                                            '#collapseHorarios',
                                            [
                                                'class' => 'btn btn-info btn-sm',
                                                'data-toggle' => 'collapse',
                                                'aria-expanded' => 'false',
                                                'aria-controls' => 'collapseHorarios'
                                            ]
                                        ) . Html::tag('div', 
                                            Html::tag('table',
                                                Html::tag('tbody',
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Segunda-feira'), ['style' => 'width: 150px;']) .
                                                        Html::tag('td', Html::encode($horario[0]->segunda))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Terça-feira')) .
                                                        Html::tag('td', Html::encode($horario[0]->terca))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Quarta-feira')) .
                                                        Html::tag('td', Html::encode($horario[0]->quarta))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Quinta-feira')) .
                                                        Html::tag('td', Html::encode($horario[0]->quinta))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Sexta-feira')) .
                                                        Html::tag('td', Html::encode($horario[0]->sexta))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Sábado')) .
                                                        Html::tag('td', Html::encode($horario[0]->sabado))
                                                    ) .
                                                    Html::tag('tr',
                                                        Html::tag('td', Html::tag('strong', 'Domingo')) .
                                                        Html::tag('td', Html::encode($horario[0]->domingo))
                                                    )
                                                ),
                                                ['class' => 'table table-sm table-striped mb-0']
                                            ),
                                            [
                                                'class' => 'collapse mt-3',
                                                'id' => 'collapseHorarios'
                                            ]
                                        ) : '<span class="text-muted">-</span>',
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-arrow-left mr-2"></i>Voltar à Lista', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>