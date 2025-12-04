<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\EventoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'local_id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'data_inicio') ?>

    <?php // echo $form->field($model, 'data_fim') ?>

    <?php // echo $form->field($model, 'imagem') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
