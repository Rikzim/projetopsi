<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaReserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reserva_id')->textInput() ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'tipo_bilhete_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
