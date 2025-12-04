<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\NoticiaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="noticia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'conteudo') ?>

    <?= $form->field($model, 'resumo') ?>

    <?= $form->field($model, 'imagem') ?>

    <?php // echo $form->field($model, 'data_publicacao') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <?php // echo $form->field($model, 'local_id') ?>

    <?php // echo $form->field($model, 'destaque') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
