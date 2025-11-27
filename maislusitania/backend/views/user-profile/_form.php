<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true]) ?>

    <?php if (!empty($model->imagem_perfil)): ?>
        <div class="form-group">
            <label>Imagem Atual</label><br>
            <?= Html::img('@web/uploads/profiles/' . $model->imagem_perfil, ['width' => '200px', 'class' => 'img-thumbnail']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imagem_perfil')->fileInput() ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>