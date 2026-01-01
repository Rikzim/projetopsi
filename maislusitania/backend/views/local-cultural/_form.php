<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

$this->registerJs("
window.applyToAll = function() { var v = $('#quick-fill-input').val(); $('.schedule-field').val(v); };
window.applyToWeekdays = function() { var v = $('#quick-fill-input').val(); $('#horario-segunda, #horario-terca, #horario-quarta, #horario-quinta, #horario-sexta').val(v); };
window.applyToWeekend = function() { var v = $('#quick-fill-input').val(); $('#horario-sabado, #horario-domingo').val(v); };
window.clearAll = function() { $('#quick-fill-input').val(''); $('.schedule-field').val(''); };
");
?>

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/local-cultural/form.css');
?>

<div class="local-cultural-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Main Info -->
            <div class="form-card">
                <div class="form-card-title">Informações Principais</div>
                
                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do local cultural']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'tipo_id')->widget(Select2::class, [
                            'data' => $tipoLocais,    
                            'options' => ['placeholder' => 'Tipo...'],
                            'pluginOptions' => ['allowClear' => true],
                        ]) ?>
                    </div>
                </div>
                
                <?= $form->field($model, 'descricao')->textarea(['rows' => 3, 'placeholder' => 'Descrição detalhada do local...']) ?>
            </div>

            <!-- Card: Location -->
            <div class="form-card">
                <div class="form-card-title">Localização</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'morada')->textInput(['maxlength' => true, 'placeholder' => 'Rua, Número, Andar...']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'distrito_id')->widget(Select2::class, [
                            'data' => $distritos,    
                            'options' => ['placeholder' => 'Distrito...'],
                            'pluginOptions' => ['allowClear' => true],
                        ]) ?>
                    </div>
                    <div class="col-md-6 coord-input">
                        <?= $form->field($model, 'latitude', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">Lat</span></div>{input}</div>'
                        ])->textInput(['placeholder' => '38.736946']) ?>
                    </div>
                    <div class="col-md-6 coord-input">
                        <?= $form->field($model, 'longitude', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">Lng</span></div>{input}</div>'
                        ])->textInput(['placeholder' => '-9.142685']) ?>
                    </div>
                </div>
            </div>

            <!-- Card: Contacts -->
            <div class="form-card">
                <div class="form-card-title">Contatos</div>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'contacto_telefone')->textInput(['maxlength' => true, 'placeholder' => '+351 ...']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'contacto_email')->input('email', ['maxlength' => true, 'placeholder' => 'email@exemplo.com']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'https://...']) ?>
                    </div>
                </div>
            </div>

            <!-- Card: Schedule -->
            <div class="form-card">
                <div class="form-card-title">Horário Semanal</div>
                
                <div class="quick-fill-bar">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Preenchimento Rápido</label>
                            <input type="text" id="quick-fill-input" class="form-control form-control-sm" placeholder="Ex: 09:00 - 18:00">
                        </div>
                        <div class="col-md-8">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="applyToAll()">Todos</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="applyToWeekdays()">Seg-Sex</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="applyToWeekend()">Fim de Semana</button>
                            <button type="button" class="btn btn-sm btn-outline-danger ml-2" onclick="clearAll()">Limpar</button>
                        </div>
                    </div>
                </div>

                <div class="schedule-grid">
                    <?= $form->field($horario, 'segunda', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-segunda', 'maxlength' => true, 'placeholder' => '09:00-18:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'terca', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-terca', 'maxlength' => true, 'placeholder' => '09:00-18:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'quarta', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-quarta', 'maxlength' => true, 'placeholder' => '09:00-18:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'quinta', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-quinta', 'maxlength' => true, 'placeholder' => '09:00-18:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'sexta', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-sexta', 'maxlength' => true, 'placeholder' => '09:00-18:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'sabado', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-sabado', 'maxlength' => true, 'placeholder' => '10:00-13:00', 'class' => 'form-control form-control-sm schedule-field']) ?>
                    <?= $form->field($horario, 'domingo', ['options' => ['class' => 'mb-0']])->textInput(['id' => 'horario-domingo', 'maxlength' => true, 'placeholder' => 'Encerrado', 'class' => 'form-control form-control-sm schedule-field']) ?>
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
                        <?php if ($model->imagem_principal): ?>
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

                    <hr>

                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Local', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
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