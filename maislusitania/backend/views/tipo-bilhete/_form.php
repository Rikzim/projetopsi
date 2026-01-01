<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TipoBilhete $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/tipo-bilhete/form.css');
?>

<div class="tipo-bilhete-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Informações -->
            <div class="form-card">
                <div class="form-card-title">Informações do Bilhete</div>
                
                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do tipo de bilhete']) ?>
                    </div>
                    <div class="col-md-4 price-input">
                        <?= $form->field($model, 'preco', [
                            'inputTemplate' => '<div class="input-group">{input}<div class="input-group-append"><span class="input-group-text">€</span></div></div>'
                        ])->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0', 'placeholder' => '0.00']) ?>
                    </div>
                </div>
                
                <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descrição (opcional)...']) ?>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Estado -->
                <div class="form-card">
                    <div class="form-card-title">Estado</div>
                    
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>{error}",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>
                    <small class="text-muted d-block mt-2">Se desativado, este bilhete não aparecerá para compra.</small>
                </div>

                <!-- Card: Actions -->
                <div class="form-card">
                    <div class="form-card-title">Ações</div>
                    
                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Bilhete', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
                        <?= Html::a('Cancelar', ['index', 'local_id' => $localCultural->id], ['class' => 'btn btn-outline-secondary btn-block']) ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?= $form->field($model, 'local_id')->hiddenInput()->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>