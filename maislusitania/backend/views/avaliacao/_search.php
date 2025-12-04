<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AvalicaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'local_id') ?>

    <?= $form->field($model, 'utilizador_id') ?>

    <?= $form->field($model, 'classificacao') ?>

    <?= $form->field($model, 'comentario') ?>

    <?php // echo $form->field($model, 'data_avaliacao') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
