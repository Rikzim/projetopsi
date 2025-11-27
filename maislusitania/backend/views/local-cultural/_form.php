<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TipoLocal;
use common\models\Distrito;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

$tipos = \common\models\TipoLocal::find()->select(['nome', 'id'])->indexBy('id')->column();
$distritos = \common\models\Distrito::find()->select(['nome', 'id'])->indexBy('id')->column();
?>

<div class="local-cultural-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- Seção: Informações Principais -->
    <h5 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Informações Principais</h5>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do local cultural']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tipo_id')->dropDownList(
                $tipos,
                ['prompt' => 'Selecione o Tipo...']
            ) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descrição detalhada do local...']) ?>
        </div>
    </div>

    <hr>

    <!-- Seção: Localização -->
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-map-marker-alt"></i> Localização</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'morada')->textInput(['maxlength' => true, 'placeholder' => 'Rua, Número, Andar...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'distrito_id')->dropDownList(
                $distritos,
                ['prompt' => 'Selecione o Distrito...']
            ) ?>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                </div>
                <?= $form->field($model, 'latitude', ['options' => ['class' => 'form-group flex-grow-1 mb-0']])->textInput(['placeholder' => 'Ex: 38.736946']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                </div>
                <?= $form->field($model, 'longitude', ['options' => ['class' => 'form-group flex-grow-1 mb-0']])->textInput(['placeholder' => 'Ex: -9.142685']) ?>
            </div>
        </div>
    </div>

    <hr>

    <!-- Seção: Contatos -->
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-address-book"></i> Contatos</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'contacto_telefone')->textInput(['maxlength' => true, 'placeholder' => '+351 ...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contacto_email')->input('email', ['maxlength' => true, 'placeholder' => 'exemplo@email.com']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'https://...']) ?>
        </div>
    </div>

    <hr>

    <!-- Seção: Horário Semanal -->
    <h5 class="text-primary mb-3 mt-4"><i class="far fa-clock"></i> Horário de Funcionamento Semanal</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($horario, 'segunda')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'terca')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'quarta')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'quinta')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($horario, 'sexta')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'sabado')->textInput(['maxlength' => true, 'placeholder' => 'Ex: 10:00 - 13:00']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'domingo')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Encerrado']) ?>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block mt-4">
                        <i class="fas fa-info-circle"></i> Pode deixar em branco os dias encerrados ou escrever "Encerrado"
                    </small>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Seção: Mídia e Status -->
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-image"></i> Mídia e Status</h5>
    <div class="row align-items-center">
        <div class="col-md-6">
            <?php if ($model->imagem_principal): ?>
                <div class="card mb-3">
                    <div class="card-header p-2">Imagem Atual</div>
                    <div class="card-body text-center p-2">
                        <?= Html::img(Yii::getAlias('@uploadsUrl') . '/' . $model->imagem_principal, [
                            'style' => 'max-height: 150px; width: auto;', 
                            'class' => 'img-fluid rounded'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?= $form->field($uploadForm, 'imageFile')->fileInput(['class' => 'form-control-file']) ?>
            <small class="text-muted">Formatos aceites: JPG, PNG. Máx: 2MB.</small>
        </div>
        
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle"></i> Se desativado, o local não aparecerá no frontend.
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