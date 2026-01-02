<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TipoLocal;
use common\models\Distrito;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

$this->registerJs("
window.applyToAll = function() {
    var value = $('#quick-fill-input').val();
    $('.schedule-field').val(value);
};

window.applyToWeekdays = function() {
    var value = $('#quick-fill-input').val();
    $('#horario-segunda, #horario-terca, #horario-quarta, #horario-quinta, #horario-sexta').val(value);
};

window.applyToWeekend = function() {
    var value = $('#quick-fill-input').val();
    $('#horario-sabado, #horario-domingo').val(value);
};

window.clearAll = function() {
    $('#quick-fill-input').val('');
    $('.schedule-field').val('');
};
");
?>

<div class="local-cultural-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <h5 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Informações Principais</h5>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do local cultural']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tipo_id')->widget(Select2::class, [
                'data' => $tipoLocais,    
                'options' => ['placeholder' => 'Selecione o tipo de local...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descrição detalhada do local...']) ?>
        </div>
    </div>

    <hr>

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-map-marker-alt"></i> Localização</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'morada')->textInput(['maxlength' => true, 'placeholder' => 'Rua, Número, Andar...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'distrito_id')->widget(Select2::class, [
                'data' => $distritos,    
                'options' => ['placeholder' => 'Selecione o distrito...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        
        <div class="col-md-6">
            <?= $form->field($model, 'latitude', [
                'inputTemplate' => '
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        {input}
                    </div>'
            ])->textInput(['placeholder' => 'Ex: 38.736946']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'longitude', [
                'inputTemplate' => '
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        {input}
                    </div>'
            ])->textInput(['placeholder' => 'Ex: -9.142685']) ?>
        </div>
    </div>

    <hr>

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

    <h5 class="text-primary mb-3 mt-4"><i class="far fa-clock"></i> Horário de Funcionamento Semanal</h5>
    <div class="card">
        <div class="card-body">
            <!-- Quick Fill Section -->
            <div class="alert alert-light border mb-4 p-3 shadow-sm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="quick-fill-input" class="form-label fw-bold text-secondary">
                            <i class="fas fa-magic me-1"></i> Preenchimento Rápido:
                        </label>
                        <input type="text" id="quick-fill-input" class="form-control" placeholder="Ex: 09:00 - 18:00">
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2">
                            <?= Html::button('<i class="fas fa-copy"></i> Aplicar a Todos', [
                                'class' => 'btn btn-success',
                                'onclick' => 'applyToAll()'
                            ]) ?>
                            <?= Html::button('<i class="fas fa-briefcase"></i> Dias Úteis', [
                                'class' => 'btn btn-outline-primary',
                                'onclick' => 'applyToWeekdays()'
                            ]) ?>
                            <?= Html::button('<i class="fas fa-calendar-day"></i> Fim de Semana', [
                                'class' => 'btn btn-outline-primary',
                                'onclick' => 'applyToWeekend()'
                            ]) ?>
                            <?= Html::button('<i class="fas fa-eraser"></i> Limpar', [
                                'class' => 'btn btn-secondary mb-2',
                                'onclick' => 'clearAll()'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($horario, 'segunda')->textInput(['id' => 'horario-segunda', 'maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00', 'class' => 'form-control schedule-field']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'terca')->textInput(['id' => 'horario-terca', 'maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00', 'class' => 'form-control schedule-field']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'quarta')->textInput(['id' => 'horario-quarta', 'maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00', 'class' => 'form-control schedule-field']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'quinta')->textInput(['id' => 'horario-quinta', 'maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00', 'class' => 'form-control schedule-field']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($horario, 'sexta')->textInput(['id' => 'horario-sexta', 'maxlength' => true, 'placeholder' => 'Ex: 09:00 - 18:00', 'class' => 'form-control schedule-field']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'sabado')->textInput(['id' => 'horario-sabado', 'maxlength' => true, 'placeholder' => 'Ex: 10:00 - 13:00', 'class' => 'form-control schedule-field']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($horario, 'domingo')->textInput(['id' => 'horario-domingo', 'maxlength' => true, 'placeholder' => 'Ex: Encerrado', 'class' => 'form-control schedule-field']) ?>
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

    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-image"></i> Mídia e Status</h5>
    <div class="row align-items-center">
        <div class="col-md-6">
            <?php if ($model->imagem_principal): ?>
                <div class="card mb-3">
                    <div class="card-header p-2">Imagem Atual</div>
                    <div class="card-body text-center p-2">
                        <?= Html::img($model->getImage(), [
                            'style' => 'max-height: 150px; width: auto;', 
                            'class' => 'img-fluid rounded'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?= $form->field($uploadForm, 'imageFile')->fileInput(['class' => 'form-control-file']) ?>
            <small class="text-muted">Formatos aceites: JPG, PNG, JPEG, WEBP, SVG. Máx: 2MB.</small>
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