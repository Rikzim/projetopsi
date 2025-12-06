<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\Reserva;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var array $tiposBilhete Todos os tipos de bilhete do local (objetos TipoBilhete indexados por id) */
/** @var array $linhasExistentes Linhas de reserva já existentes, indexadas por tipo_bilhete_id */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Dados da Reserva</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'utilizador_id')->textInput([
                'readonly' => true, 
                'value' => $model->utilizador->username ?? '', 
                'disabled' => true
            ]) ?>
            <?= Html::activeHiddenInput($model, 'utilizador_id') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'local_id')->textInput([
                'readonly' => true, 
                'value' => $model->local->nome ?? '', 
                'disabled' => true
            ]) ?>
            <?= Html::activeHiddenInput($model, 'local_id') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'data_visita')->textInput([
                'placeholder' => 'AAAA-MM-DD', 
                'type' => 'date'
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->dropDownList(
                Reserva::optsEstado(),
                ['prompt' => 'Selecione o estado...']
            ) ?>
        </div>
    </div>

    <hr class="mt-4">
    <h5 class="text-primary mb-3"><i class="fas fa-ticket-alt"></i> Bilhetes</h5>

    <!-- Cabeçalho -->
    <div class="row font-weight-bold pb-2 mb-2 border-bottom small text-muted text-uppercase">
        <div class="col-md-6">Tipo de Bilhete</div>
        <div class="col-md-2 text-center">Quantidade</div>
        <div class="col-md-2 text-right">Preço Unitário</div>
        <div class="col-md-2 text-right">Subtotal(recalculado ao guardar)</div>
    </div>

    <?php if (!empty($tiposBilhete)): ?>
        <?php foreach ($tiposBilhete as $tipoId => $tipo): ?>
            <?php
            $quantidade = isset($linhasExistentes[$tipoId]) ? $linhasExistentes[$tipoId]->quantidade : 0;
            $subtotal = $quantidade * $tipo->preco;
            ?>
            <div class="row mb-2 align-items-center">
                <div class="col-md-6">
                    <strong><?= Html::encode($tipo->nome) ?></strong>
                </div>
                <div class="col-md-2">
                    <?= Html::textInput(
                        "LinhaReserva[{$tipoId}][quantidade]",
                        $quantidade,
                        ['type' => 'number', 'min' => 0, 'class' => 'form-control text-center']
                    ) ?>
                    <?= Html::hiddenInput("LinhaReserva[{$tipoId}][tipo_bilhete_id]", $tipoId) ?>
                </div>
                <div class="col-md-2 text-right">
                    <?= Yii::$app->formatter->asCurrency($tipo->preco, 'EUR') ?>
                </div>
                <div class="col-md-2 text-right">
                    <strong><?= Yii::$app->formatter->asCurrency($subtotal, 'EUR') ?></strong>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Não existem tipos de bilhete associados a este local.
        </div>
    <?php endif; ?>

    <hr>

    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body text-right">
                    <h5 class="mb-0">Preço Total</h5>
                    <h3 class="text-primary mb-0"><?= Yii::$app->formatter->asCurrency($model->preco_total, 'EUR') ?></h3>
                    <small class="text-muted">(recalculado ao guardar)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-4 text-right">
        <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>