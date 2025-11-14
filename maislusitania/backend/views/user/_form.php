<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\SignupForm;
use backend\models\UpdateForm;

/** @var yii\web\View $this */
/** @var backend\models\SignupForm|backend\models\UpdateForm $model */
/** @var yii\widgets\ActiveForm $form */
/** @var bool $isUpdate */

$isUpdate = isset($isUpdate) ? $isUpdate : false;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php if ($isUpdate && $model->current_image): ?>
        <div class="form-group">
            <label>Imagem Atual:</label>
            <div>
                <?= Html::img('@web/uploads/' . $model->current_image, ['style' => 'max-width: 200px;', 'class' => 'img-thumbnail']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imagem_perfil')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true, 'placeholder' => 'Primeiro Nome']) ?>

    <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true, 'placeholder' => 'Último Nome']) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Nome de utilizador']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email@exemplo.com']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $isUpdate ? 'Deixe em branco para não alterar' : 'Password']) ?>

    <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true, 'placeholder' => 'Confirmar Password']) ?>

    <?= $form->field($model, 'role')->dropDownList(
        $model instanceof SignupForm ? SignupForm::getRoles() : UpdateForm::getRoles(), 
        ['prompt' => 'Selecione o tipo de utilizador']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Ativo',
        9 => 'Inativo',
        0 => 'Deletado'
    ]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($isUpdate ? 'Atualizar Utilizador' : 'Criar Utilizador', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>