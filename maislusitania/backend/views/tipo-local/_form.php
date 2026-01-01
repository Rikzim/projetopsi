<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TipoLocal */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/tipo-local/form.css');
?>

<div class="tipo-local-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Info -->
            <div class="form-card">
                <div class="form-card-title">Informações</div>
                
                <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Museu, Teatro...']) ?>
                
                <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Breve descrição...']) ?>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Icon/Image -->
                <div class="form-card">
                    <div class="form-card-title">Ícone / Imagem</div>
                    
                    <div class="image-preview-container" id="image-preview-zone">
                        <img id="preview-image" style="display:none;" alt="Preview">
                        <?= Html::img($model->getImage(), ['id' => 'current-image']) ?>
                    </div>

                    <?= $form->field($uploadForm, 'imageFile')->fileInput([
                        'class' => 'form-control-file', 
                        'id' => 'upload-input',
                        'accept' => 'image/*'
                    ])->label('Carregar Ícone') ?>
                </div>

                <!-- Card: Actions -->
                <div class="form-card">
                    <div class="form-card-title">Ações</div>
                    
                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Tipo', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
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

    if (uploadInput) {
        uploadInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    if (currentImage) currentImage.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    }
})();
", \yii\web\View::POS_READY);
?>
