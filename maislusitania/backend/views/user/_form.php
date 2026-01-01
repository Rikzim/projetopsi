<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use backend\models\SignupForm;
use backend\models\UpdateForm;

/** @var yii\web\View $this */
/** @var backend\models\SignupForm|backend\models\UpdateForm $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/user/form.css');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Personal Info -->
            <div class="form-card">
                <div class="form-card-title">Dados Pessoais</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true, 'placeholder' => 'Primeiro Nome']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true, 'placeholder' => 'Último Nome']) ?>
                    </div>
                </div>
                
                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Username']) ?>
                
                <?= $form->field($model, 'email')->input('email', ['placeholder' => 'email@exemplo.com']) ?>
            </div>

            <!-- Card: Security -->
            <div class="form-card">
                <div class="form-card-title">Segurança e Permissões</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nova password...']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => 'Confirmar password']) ?>
                    </div>
                </div>
                
                <?= $form->field($model, 'role')->dropDownList(
                    $model instanceof SignupForm ? SignupForm::getRoles() : UpdateForm::getRoles(), 
                    ['prompt' => 'Selecione o tipo de utilizador...']
                ) ?>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Profile Picture -->
                <div class="form-card">
                    <div class="form-card-title">Foto de Perfil</div>
                    
                    <div class="image-preview-container" id="image-preview-zone">
                        <img id="preview-image" style="display:none;" alt="Preview">
                        <?php if ($model->imagem_perfil): ?>
                            <?= Html::img($model->getImage(), [
                                'id' => 'current-image',
                            ]) ?>
                        <?php else: ?>
                            <div id="placeholder-text" class="text-muted text-center" style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                                <div>
                                    <i class="fas fa-user-circle fa-4x mb-3"></i><br>
                                    <span>Sem foto</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?= $form->field($uploadForm, 'imageFile')->fileInput([
                        'class' => 'form-control-file', 
                        'id' => 'upload-input',
                        'accept' => 'image/*'
                    ])->label('Carregar Foto') ?>
                </div>

                <!-- Card: Status -->
                <div class="form-card">
                    <div class="form-card-title">Estado</div>
                    
                    <?= $form->field($model, 'status')->dropDownList([
                        10 => 'Ativo',
                        9 => 'Inativo',
                        0 => 'Eliminado'
                    ]) ?>

                    <hr>

                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Utilizador', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
                        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary btn-block']) ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
(function() {
    var uploadInput = document.getElementById('upload-input');
    var previewImage = document.getElementById('preview-image');
    var currentImage = document.getElementById('current-image');
    var placeholder = document.getElementById('placeholder-text');

    if (uploadInput) {
        uploadInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    if (currentImage) currentImage.style.display = 'none';
                    if (placeholder) placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    }
})();
", \yii\web\View::POS_READY);
?>