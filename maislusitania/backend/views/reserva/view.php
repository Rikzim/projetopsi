<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */

$this->title = 'Reserva #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-ticket-alt mr-2"></i>Ver Bilhetes do local', ['tipo-bilhete/index', 'local_id' => $model->local_id], ['class' => 'btn btn-info btn-sm mr-2', 'title' => 'Ver todos os tipos de bilhete do local']) ?>
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar esta reserva?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Detalhes da Reserva -->
                        <div class="col-md-8">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => ['class' => 'table table-hover table-striped detail-view'],
                                'attributes' => [
                                    [
                                        'attribute' => 'id',
                                        'label' => 'ID',
                                    ],
                                    [
                                        'attribute' => 'utilizador_id',
                                        'label' => 'Utilizador',
                                        'format' => 'raw',
                                        'value' => $model->utilizador
                                            ? Html::tag('span', '<i class="fas fa-user mr-2"></i>' . Html::encode($model->utilizador->username), [
                                                'class' => 'badge badge-info',
                                                'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                            ])
                                            : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'local_id',
                                        'label' => 'Local Cultural',
                                        'format' => 'raw',
                                        'value' => $model->local
                                            ? Html::tag('span', '<i class="fas fa-landmark mr-2"></i>' . Html::encode($model->local->nome), [
                                                'class' => 'badge badge-primary',
                                                'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                            ])
                                            : '<span class="text-muted">-</span>',
                                    ],
                                    [
                                        'attribute' => 'data_visita',
                                        'label' => 'Data da Visita',
                                        'format' => ['date', 'php:d/m/Y'],
                                    ],
                                    [
                                        'attribute' => 'preco_total',
                                        'label' => 'Preço Total',
                                        'format' => 'raw',
                                        'value' => number_format($model->preco_total, 2, ',', ' ') . ' €',
                                    ],
                                    [
                                        'attribute' => 'estado',
                                        'label' => 'Estado',
                                        'format' => 'raw',
                                        'value' => function($model) {
                                            if ($model->estado === \common\models\Reserva::ESTADO_CONFIRMADA) {
                                                return Html::tag('span', '<i class="fas fa-check-circle mr-2"></i>Confirmada', [
                                                    'class' => 'badge badge-success',
                                                    'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                                ]);
                                            }
                                            if ($model->estado === \common\models\Reserva::ESTADO_EXPIRADO) {
                                                return Html::tag('span', '<i class="fas fa-clock mr-2"></i>Expirado', [
                                                    'class' => 'badge badge-warning',
                                                    'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                                ]);
                                            }
                                            if ($model->estado === \common\models\Reserva::ESTADO_CANCELADA) {
                                                return Html::tag('span', '<i class="fas fa-times-circle mr-2"></i>Cancelada', [
                                                    'class' => 'badge badge-danger',
                                                    'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                                ]);
                                            }
                                            return Html::tag('span', Html::encode($model->estado), [
                                                'class' => 'badge badge-secondary',
                                                'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'
                                            ]);
                                        },
                                    ],
                                    [
                                        'attribute' => 'data_criacao',
                                        'label' => 'Data de Criação',
                                        'format' => ['datetime', 'php:d/m/Y H:i'],
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <!-- Bilhetes da Reserva -->
                        <div class="col-md-4">
                            <div class="card card-outline card-info mb-3">
                                <div class="card-header py-2">
                                    <strong><i class="fas fa-ticket-alt mr-2"></i>Bilhetes</strong>
                                </div>
                                <div class="card-body p-2">
                                    <?php if ($model->linhaReservas): ?>
                                        <table class="table table-sm table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th class="text-center">Qtd</th>
                                                    <th class="text-right">Preço Unit.</th>
                                                    <th class="text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($model->linhaReservas as $linha): ?>
                                                    <tr>
                                                        <td><?= Html::encode($linha->tipoBilhete ? $linha->tipoBilhete->nome : '-') ?></td>
                                                        <td class="text-center"><?= Html::encode($linha->quantidade) ?></td>
                                                        <td class="text-right"><?= number_format($linha->tipoBilhete ? $linha->tipoBilhete->preco : 0, 2, ',', ' ') ?> €</td>
                                                        <td class="text-right font-weight-bold"><?= number_format(($linha->tipoBilhete ? $linha->tipoBilhete->preco : 0) * $linha->quantidade, 2, ',', ' ') ?> €</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <span class="text-muted">Sem bilhetes associados.</span>
                                    <?php endif; ?>
                                </div>
                            </div>
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