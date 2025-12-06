<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */

$this->params['breadcrumbs'][] = ['label' => 'Avaliações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar esta avaliação?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-hover table-striped detail-view'],
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'local_id',
                                'label' => 'Local Cultural',
                                'format' => 'raw',
                                'value' => $model->local ? Html::a(
                                    '<i class="fas fa-landmark mr-2"></i>' . Html::encode($model->local->nome),
                                    ['local-cultural/view', 'id' => $model->local_id]
                                ) : '<span class="text-muted">-</span>',
                            ],
                            [
                                'attribute' => 'utilizador_id',
                                'label' => 'Utilizador',
                                'format' => 'raw',
                                'value' => $model->utilizador ? Html::a(
                                    '<i class="fas fa-user mr-2"></i>' . Html::encode($model->utilizador->username),
                                    ['user/view', 'id' => $model->utilizador_id]
                                ) : '<span class="text-muted">-</span>',
                            ],
                            [
                                'attribute' => 'classificacao',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $stars = '';
                                    for ($i = 1; $i <= 5; $i++) {
                                        $stars .= '<i class="' . ($i <= $model->classificacao ? 'fas' : 'far') . ' fa-star text-warning"></i> ';
                                    }
                                    return $stars;
                                },
                            ],
                            [
                                'attribute' => 'comentario',
                                'format' => 'raw',
                                'value' => $model->comentario ? '<i class="fas fa-comment-alt mr-2 text-muted"></i>' . nl2br(Html::encode($model->comentario)) : '<span class="text-muted">-</span>',
                            ],
                            [
                                'attribute' => 'data_avaliacao',
                                'format' => 'raw',
                                'value' => '<i class="fas fa-calendar-alt mr-2 text-muted"></i>' . Yii::$app->formatter->asDatetime($model->data_avaliacao, 'long'),
                            ],
                            [
                                'attribute' => 'ativo',
                                'label' => 'Estado',
                                'format' => 'raw',
                                'value' => $model->ativo
                                    ? Html::tag('span', '<i class="fas fa-check-circle mr-2"></i>Ativo', ['class' => 'badge badge-success', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;'])
                                    : Html::tag('span', '<i class="fas fa-times-circle mr-2"></i>Inativo', ['class' => 'badge badge-danger', 'style' => 'font-size: 0.95rem; padding: 0.5em 1em;']),
                            ],
                        ],
                    ]) ?>
                </div>

                <div class="card-footer">
                    <?= Html::a('<i class="fas fa-arrow-left mr-2"></i>Voltar à Lista', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
