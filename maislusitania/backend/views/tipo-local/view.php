<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TipoLocal */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Locais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar este tipo de local?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna da Imagem/Ícone -->
                        <div class="col-md-4 mb-4">
                            <div class="text-center">
                                <?php if ($model->icone): ?>
                                    <!-- Assume-se que é um upload de imagem, ajustando o path -->
                                    <?= Html::img(
                                        '@web/uploads/' . $model->icone,
                                        [
                                            'class' => 'img-fluid rounded shadow-sm',
                                            'style' => 'width: 100%; max-height: 300px; object-fit: contain;',
                                            'alt' => Html::encode($model->nome)
                                        ]
                                    ) ?>
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <i class="fas fa-tags fa-5x text-muted"></i>
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
                                        'attribute' => 'id',
                                        'captionOptions' => ['class' => 'text-muted', 'style' => 'width: 150px;'],
                                    ],
                                    [
                                        'attribute' => 'nome',
                                        'format' => 'raw',
                                        'value' => Html::tag('strong', Html::encode($model->nome), ['class' => 'text-dark h5']),
                                    ],
                                    [
                                        'attribute' => 'descricao',
                                        'format' => 'ntext',
                                        'value' => $model->descricao ? $model->descricao : '<span class="text-muted text-italic">Sem descrição</span>',
                                        'captionOptions' => ['style' => 'vertical-align: top;'],
                                    ],
                                    // O ícone/imagem já é mostrado na coluna da esquerda, mas podemos manter o nome do ficheiro aqui se desejado
                                    [
                                        'attribute' => 'icone',
                                        'label' => 'Nome do Ficheiro',
                                        'value' => $model->icone ? $model->icone : 'N/A',
                                        'contentOptions' => ['class' => 'text-monospace small text-muted'],
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