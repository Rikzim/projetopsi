<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Dados da Reserva</h5>
    <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'utilizador_id')->widget(Select2::class, [
            'data' => $utilizadores,
            'options' => ['placeholder' => 'Selecione o utilizador...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'local_id')->widget(Select2::class, [
            'data' => $locais,
            'options' => ['placeholder' => 'Selecione o local...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
    </div>
</div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'data_visita')->textInput(['placeholder' => 'AAAA-MM-DD']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'preco_total')->textInput(['maxlength' => true, 'placeholder' => 'Preço total (€)']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->dropDownList(
                \common\models\Reserva::optsEstado(),
                ['prompt' => 'Selecione o estado...']
            ) ?>
        </div>
    </div>

    <div class="form-group mt-4 text-right">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>