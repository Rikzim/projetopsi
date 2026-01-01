<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use backend\models\SignupForm;
use backend\models\UpdateForm;

/** @var yii\web\View $this */
/** @var backend\models\SignupForm|backend\models\UpdateForm $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-user-circle"></i> Informações Pessoais</h5>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header p-2">Imagem de Perfil</div>
                <div class="card-body text-center p-2">
                    <img id="preview-image" style="display:none; max-height: 150px; width: auto;" class="img-fluid rounded mb-2" alt="Preview">
                    <?php if ($model->imagem_perfil): ?>
                        <?= Html::img($model->getImage(), [
                            'style' => 'max-height: 150px; width: auto;', 
                            'class' => 'img-fluid rounded mb-2'
                        ]) ?>
                    <?php else: ?>
                        <div class="text-muted py-4"><i class="fas fa-image fa-3x"></i><br>Sem imagem</div>
                    <?php endif; ?>
                    
                    <?= $form->field($uploadForm, 'imageFile', ['options' => ['class' => 'mb-0']])->fileInput(['class' => 'form-control-file mt-2', 'accept' => 'image/*', 'data-image-preview' => 'preview-image'])->label(false) ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true, 'placeholder' => 'Primeiro Nome']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true, 'placeholder' => 'Último Nome']) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'username', [
                        'inputTemplate' => '
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                {input}
                            </div>'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Nome de utilizador']) ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-id-card"></i> Dados de Acesso</h5>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email', [
                'inputTemplate' => '
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        {input}
                    </div>'
            ])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email@exemplo.com']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'role')->dropDownList(
                $model instanceof SignupForm ? SignupForm::getRoles() : UpdateForm::getRoles(), 
                ['prompt' => 'Selecione o tipo de utilizador']
            ) ?>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-lock"></i> Segurança</h5>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' =>'Deixe em branco para não alterar']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true, 'placeholder' => 'Confirmar Password']) ?>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-toggle-on"></i> Estado da Conta</h5>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <?= $form->field($model, 'status', ['options' => ['class' => 'mb-0']])->dropDownList([
                                10 => 'Ativo',
                                9 => 'Inativo',
                                0 => 'Apagado/Inativo'
                            ]) ?>
                        </div>
                        <div class="col-md-8">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> "Inativo" impede o login. "Deletado" remove o acesso permanentemente (soft delete).
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-4 text-right">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Criar/Atualizar Utilizador',
                ['class' => 'btn btn-success px-4']
            ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
document.addEventListener('DOMContentLoaded', function () {
  var inputs = document.querySelectorAll(
    'input[type=file][data-image-preview]'
  );
  inputs.forEach(function (input) {
    var previewId = input.getAttribute('data-image-preview');
    var preview = document.getElementById(previewId);
    if (preview) {
      input.addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
          var reader = new FileReader();
          reader.onload = function (ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
            var cardBody = preview.closest('.card-body');
            if (cardBody) {
              var existingImages = cardBody.querySelectorAll('img:not(#' + previewId + ')');
              existingImages.forEach(function (img) {
                img.style.display = 'none';
              });
            }
          };
          reader.readAsDataURL(e.target.files[0]);
        }
      });
    }
  });
});
", \yii\web\View::POS_END); ?>