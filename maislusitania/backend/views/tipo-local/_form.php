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
                                <?= $form->field($uploadForm, 'imageFile')->fileInput([
                                    (['class' => 'form-control-file'])
                                ])->label('Ícone / Imagem') ?>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i> Formatos aceites: JPG, PNG, JPEG, WEBP, SVG. Máx: 2MB.
                                </small>
                            </div>

                                <div class="col-md-6">
                                    <div class="card bg-light mb-0">
                                        <div class="card-body text-center p-2">
                                            <label class="d-block text-muted small mb-2">Imagem Atual</label>
                                            <?= Html::img($model->getImage(), [
                                                'style' => 'max-height: 100px; max-width: 100%; object-fit: contain;', 
                                                'class' => 'img-thumbnail shadow-sm'
                                            ]) ?>
                                        </div>
                                    </div>
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
</div>
