<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\Reserva;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var array $tiposBilhete */
/** @var array $linhasExistentes */
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/reserva/form.css');
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Dados da Reserva -->
            <div class="form-card">
                <div class="form-card-title">Dados da Reserva</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'utilizador_id')->textInput([
                            'readonly' => true, 
                            'value' => $model->utilizador->username ?? '', 
                            'disabled' => true,
                            'class' => 'form-control readonly-field'
                        ])->label('Utilizador') ?>
                        <?= Html::activeHiddenInput($model, 'utilizador_id') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'local_id')->textInput([
                            'readonly' => true, 
                            'value' => $model->local->nome ?? '', 
                            'disabled' => true,
                            'class' => 'form-control readonly-field'
                        ])->label('Local') ?>
                        <?= Html::activeHiddenInput($model, 'local_id') ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'data_visita')->textInput(['type' => 'date']) ?>
                    </div>
                </div>
            </div>

            <!-- Card: Bilhetes -->
            <div class="form-card">
                <div class="form-card-title">Bilhetes</div>
                
                <div class="row ticket-header mx-0">
                    <div class="col-md-5">Tipo</div>
                    <div class="col-md-2 text-center">Qtd.</div>
                    <div class="col-md-2 text-right">Preço Un.</div>
                    <div class="col-md-3 text-right">Subtotal</div>
                </div>

                <?php if (!empty($tiposBilhete)): ?>
                    <?php foreach ($tiposBilhete as $tipoId => $tipo): ?>
                        <?php
                        $quantidade = isset($linhasExistentes[$tipoId]) ? $linhasExistentes[$tipoId]->quantidade : 0;
                        $subtotal = $quantidade * $tipo->preco;
                        ?>
                        <div class="row ticket-row align-items-center mx-0">
                            <div class="col-md-5">
                                <strong><?= Html::encode($tipo->nome) ?></strong>
                            </div>
                            <div class="col-md-2">
                                <?= Html::textInput("LinhaReserva[{$tipoId}][quantidade]", $quantidade, [
                                    'type' => 'number', 'min' => 0, 'class' => 'form-control form-control-sm text-center'
                                ]) ?>
                                <?= Html::hiddenInput("LinhaReserva[{$tipoId}][tipo_bilhete_id]", $tipoId) ?>
                            </div>
                            <div class="col-md-2 text-right text-muted">
                                <?= Yii::$app->formatter->asCurrency($tipo->preco, 'EUR') ?>
                            </div>
                            <div class="col-md-3 text-right">
                                <strong><?= Yii::$app->formatter->asCurrency($subtotal, 'EUR') ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block"></i>
                        Não existem tipos de bilhete associados a este local.
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Total -->
                <div class="form-card">
                    <div class="form-card-title">Total</div>
                    
                    <div class="total-box">
                        <h5>Preço Total</h5>
                        <h3><?= Yii::$app->formatter->asCurrency($model->preco_total, 'EUR') ?></h3>
                    </div>
                </div>

                <!-- Card: Estado -->
                <div class="form-card">
                    <div class="form-card-title">Estado</div>
                    
                    <?= $form->field($model, 'estado')->dropDownList(Reserva::optsEstado(), ['prompt' => 'Estado...']) ?>
                </div>

                <!-- Card: Actions -->
                <div class="form-card">
                    <div class="form-card-title">Ações</div>
                    
                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Reserva', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
                        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary btn-block']) ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>