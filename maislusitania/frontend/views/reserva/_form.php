<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilizador_id')->textInput() ?>

    <?= $form->field($model, 'local_id')->textInput() ?>

    <?= $form->field($model, 'data_visita')->textInput() ?>

    <?= $form->field($model, 'preco_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'Pendente' => 'Pendente', 'Confirmada' => 'Confirmada', 'Cancelada' => 'Cancelada', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'data_reserva')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
