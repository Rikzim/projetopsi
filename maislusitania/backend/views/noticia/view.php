<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Noticia */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Gestão de Notícias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-newspaper mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar esta notícia?',
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
                                <?php if ($model->imagem): ?>
                                    <?= Html::img(
                                        $model->getImage(),
                                        [
                                            'class' => 'img-fluid rounded shadow-sm',
                                            'style' => 'width: 100%; max-height: 400px; object-fit: cover;',
                                            'alt' => Html::encode($model->titulo)
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
                                        'attribute' => 'titulo',
                                        'format' => 'raw',
                                        'value' => Html::tag('strong', Html::encode($model->titulo), ['class' => 'text-dark h5']),
                                    ],
                                    [
                                        'attribute' => 'resumo',
                                        'format' => 'raw',
                                        'value' => $model->resumo ? Html::tag('p', Html::encode($model->resumo), ['class' => 'mb-0']) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'conteudo',
                                        'format' => 'ntext',
                                        'value' => $model->conteudo ? Html::tag('div', nl2br(Html::encode($model->conteudo)), ['class' => 'mb-0']) : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'data_publicacao',
                                        'label' => 'Data de Publicação',
                                        'format' => ['date', 'php:d/m/Y'],
                                        'value' => $model->data_publicacao ? $model->data_publicacao : '<span class="text-muted">-</span>',
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
                                        'attribute' => 'destaque',
                                        'label' => 'Destaque',
                                        'format' => 'raw',
                                        'value' => $model->destaque
                                            ? Html::tag('span', '<i class="fas fa-star mr-2"></i>Destaque', ['class' => 'badge badge-warning', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'])
                                            : Html::tag('span', '<i class="far fa-star mr-2"></i>Normal', ['class' => 'badge badge-secondary', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']),
                                    ],
                                    [
                                        'attribute' => 'local_id',
                                        'label' => 'Local Cultural',
                                        'format' => 'raw',
                                        'value' => $model->local ? Html::tag('span',
                                            '<i class="fas fa-landmark mr-2"></i>' . Html::encode($model->local->nome),
                                            ['class' => 'badge badge-info', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']
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