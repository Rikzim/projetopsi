<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\LocalCultural;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\NoticiaForm */
/* @var $form yii\bootstrap4\ActiveForm */

$locais = LocalCultural::find()->select(['nome', 'id'])->indexBy('id')->column();
?>

<div class="noticia-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-newspaper"></i> Informações da Notícia</h5>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Título da notícia']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'local_id')->widget(Select2::class, [
            'data' => $locais,
            'options' => ['placeholder' => 'Selecione o local cultural...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'resumo')->textInput(['maxlength' => true, 'placeholder' => 'Resumo da notícia']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'conteudo')->textarea(['rows' => 6, 'placeholder' => 'Conteúdo completo da notícia...']) ?>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-image"></i> Mídia e Publicação</h5>
    <div class="row align-items-center">
        <div class="col-md-6">
            <?php if ($uploadForm->imageFile) : ?>
                <div class="card mb-3">
                    <div class="card-header p-2">Imagem Atual</div>
                    <div class="card-body text-center p-2">
                        <?= Html::img(Yii::getAlias('@uploadsUrl') . '/' . $uploadForm->imageFile, [
                            'style' => 'max-height: 150px; width: auto;',
                            'class' => 'img-fluid rounded'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?= $form->field($uploadForm, 'imageFile')->fileInput(['class' => 'form-control-file']) ?>
            <small class="text-muted">Formatos aceites: JPG, PNG. Máx: 2MB.</small>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'data_publicacao')->input('date') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'destaque')->dropDownList(
                [0 => 'Não', 1 => 'Sim'],
                ['prompt' => 'É destaque?']
            ) ?>
        </div>
    </div>

    <hr>
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-toggle-on"></i> Status</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle"></i> Se desativado, a notícia não aparecerá no frontend.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-4 text-right">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>