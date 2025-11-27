<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\LocalCulturalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="local-cultural-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'tipo_id') ?>

    <?= $form->field($model, 'morada') ?>

    <?= $form->field($model, 'distrito_id') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'horario_funcionamento') ?>

    <?php // echo $form->field($model, 'contacto_telefone') ?>

    <?php // echo $form->field($model, 'contacto_email') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'imagem_principal') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
