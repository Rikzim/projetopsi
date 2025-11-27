<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TipoLocal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-local-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?php if ($model->getCurrentImage()): ?>
        <div class="form-group">
            <label>Imagem Atual:</label>
            <div>
                <?= Html::img('@web/uploads/' . $model->getCurrentImage(), ['style' => 'max-width: 200px;', 'class' => 'img-thumbnail']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'icone')->fileInput(['accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>