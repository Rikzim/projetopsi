<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\TipoBilhete $model */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Locais Culturais', 'url' => ['local-cultural/index']];
$this->params['breadcrumbs'][] = ['label' => $model->local->nome, 'url' => ['local-cultural/view', 'id' => $model->local_id]];
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Bilhete', 'url' => ['index', 'local_id' => $model->local_id]];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id, 'local_id' => $model->local_id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar este tipo de bilhete?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna do Ícone -->
                        <div class="col-md-4 mb-4">
                            <div class="text-center">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <i class="fas fa-ticket-alt fa-5x text-primary"></i>
                                </div>
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
                                        'attribute' => 'descricao',
                                        'format' => 'raw',
                                        'value' => $model->descricao 
                                            ? Html::tag('p', Html::encode($model->descricao), ['class' => 'text-justify mb-0']) 
                                            : '<span class="text-muted">Sem descrição</span>',
                                    ],
                                    [
                                        'attribute' => 'preco',
                                        'label' => 'Preço',
                                        'format' => 'raw',
                                        'value' => Html::tag('span',
                                            '<i class="fas fa-euro-sign mr-2"></i>' . number_format($model->preco, 2, ',', ' '),
                                            ['class' => 'badge badge-info', 'style' => 'font-size: 1.1rem; padding: 0.6em 1em;']
                                        ),
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
                                        'attribute' => 'local_id',
                                        'label' => 'Local Cultural',
                                        'format' => 'raw',
                                        'value' => $model->local 
                                            ? Html::a(
                                                '<i class="fas fa-landmark mr-2"></i>' . Html::encode($model->local->nome),
                                                ['local-cultural/view', 'id' => $model->local_id],
                                                ['class' => 'badge badge-secondary', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']
                                            )
                                            : '<span class="text-muted">-</span>',
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-arrow-left mr-2"></i>Voltar à Lista', ['index', 'local_id' => $model->local_id], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>