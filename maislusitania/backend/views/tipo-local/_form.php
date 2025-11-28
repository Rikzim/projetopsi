<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;

/* @var $this yii\web\View */
/* @var $model common\models\TipoLocal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-local-form">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tag mr-2"></i>
                    <?= $model->isNewRecord ? 'Novo Tipo de Local' : 'Editar: ' . Html::encode($model->nome) ?>
                </h3>
            </div>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'nome')->textInput([
                            'maxlength' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Ex: Museu, Teatro, Galeria...'
                        ]) ?>
                    </div>

                    <div class="col-md-12">
                        <?= $form->field($model, 'descricao')->textarea([
                            'rows' => 3,
                            'class' => 'form-control',
                            'placeholder' => 'Breve descrição sobre este tipo de local'
                        ]) ?>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($model->icone): ?>
                                    <div class="card mb-3">
                                        <div class="card-header p-2">Imagem Atual</div>
                                        <div class="card-body text-center p-2">
                                            <?= Html::img(Yii::getAlias('@uploadsUrl') . '/' . $model->icone, [
                                                'style' => 'max-height: 150px; width: auto;',
                                                'class' => 'img-fluid rounded'
                                            ]) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?= $form->field($uploadForm, 'imageFile')->fileInput(['class' => 'form-control-file']) ?>
                                <small class="text-muted">Formatos aceites: JPG, PNG. Máx: 2MB.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-arrow-left mr-2"></i>Voltar', ['index'], ['class' => 'btn btn-secondary']) ?>

                        <?= Html::submitButton(
                            $model->isNewRecord ? '<i class="fas fa-save mr-2"></i>Guardar' : '<i class="fas fa-save mr-2"></i>Atualizar',
                            ['class' => 'btn btn-success']
                        ) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>