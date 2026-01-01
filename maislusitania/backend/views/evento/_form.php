<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/** @var $this yii\web\View */
/** @var $model backend\models\Evento */
/** @var $form yii\bootstrap4\ActiveForm */
/** @var $uploadForm backend\models\UploadForm */
/** @var array $locais */
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/evento/form.css');
?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Event Info -->
            <div class="form-card">
                <div class="form-card-title">Informações do Evento</div>
                
                <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Título do evento']) ?>
                
                <?= $form->field($model, 'local_id')->widget(Select2::class, [
                    'data' => $locais,
                    'options' => ['placeholder' => 'Selecione o local...'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>
                
                <?= $form->field($model, 'descricao')->textarea(['rows' => 5, 'placeholder' => 'Descrição detalhada...']) ?>
            </div>

            <!-- Card: Date & Time -->
            <div class="form-card">
                <div class="form-card-title">Data e Hora</div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'data_inicio')->input('datetime-local') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'data_fim')->input('datetime-local') ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Media -->
                <div class="form-card">
                    <div class="form-card-title">Imagem de Capa</div>
                    
                    <div class="image-preview-container" id="image-preview-zone">
                        <img id="preview-image" style="display:none;" alt="Preview">
                        <?php if ($model->imagem): ?>
                            <?= Html::img($model->getImage(), ['id' => 'current-image']) ?>
                        <?php else: ?>
                            <div id="placeholder-text" class="text-muted text-center">
                                <i class="fas fa-image fa-3x mb-3"></i><br>
                                <span>Nenhuma imagem selecionada</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?= $form->field($uploadForm, 'imageFile')->fileInput([
                        'class' => 'form-control-file', 
                        'id' => 'upload-input',
                        'accept' => 'image/*'
                    ])->label('Carregar Imagem') ?>
                </div>

                <!-- Card: Publish -->
                <div class="form-card">
                    <div class="form-card-title">Publicação</div>
                    
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>{error}",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>
                    <small class="text-muted d-block mb-3">Se desativado, o evento ficará oculto.</small>

                    <hr>

                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Evento', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
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