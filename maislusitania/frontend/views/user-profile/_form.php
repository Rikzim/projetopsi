<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagem_perfil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
