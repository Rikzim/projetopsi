<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\LocalCultural;

/* @var $this yii\web\View */
/* @var $model backend\models\EventoForm */
/* @var $form yii\bootstrap4\ActiveForm */

?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'local_id')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'data_inicio')->input('date') ?>

    <?php if ($model->getCurrentImage()): ?>
        <div class="form-group">
            <label>Imagem Atual:</label>
            <div>
                <?= Html::img('@web/uploads/' . $model->getCurrentImage(), ['style' => 'max-width: 200px;', 'class' => 'img-thumbnail']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imagem')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'ativo')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>