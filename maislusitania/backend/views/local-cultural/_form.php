<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LocalCulturalForm */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="local-cultural-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_id')->textInput() ?>

    <?= $form->field($model, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distrito_id')->textInput() ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'horario_funcionamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacto_telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacto_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?php if ($model->getCurrentImage()): ?>
        <div class="form-group">
            <label>Imagem Atual:</label>
            <div>
                <?= Html::img('@web/uploads/' . $model->getCurrentImage(), ['style' => 'max-width: 200px;', 'class' => 'img-thumbnail']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'ativo')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>