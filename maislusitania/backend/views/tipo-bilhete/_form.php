<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TipoBilhete $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="tipo-bilhete-form">

    <?php $form = ActiveForm::begin(); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-ticket-alt"></i> Informações do Bilhete</h5>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do tipo de bilhete']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'preco', [
                'inputTemplate' => '
                    <div class="input-group">
                        {input}
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                        </div>
                    </div>'
            ])->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0', 'placeholder' => '0.00']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'descricao')->textarea(['rows' => 3, 'placeholder' => 'Descrição do tipo de bilhete (opcional)...']) ?>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-cog"></i> Configurações</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle"></i> Se desativado, o bilhete não estará disponível para compra.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'local_id')->hiddenInput()->label(false) ?>

    <div class="form-group mt-4 text-right">
        <?= Html::a('Cancelar', ['index', 'local_id' => $model->local_id], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>