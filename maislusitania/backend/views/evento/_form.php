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

<div class="evento-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- Seção: Informações Principais -->
    <h5 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Informações do Evento</h5>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Título do evento']) ?>
        </div>
        <?= $form->field($model, 'local_id')->widget(Select2::class, [
                'data' => $locais,
                'options' => ['placeholder' => 'Selecione o local...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        <div class="col-md-12">
            <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descrição detalhada do evento...']) ?>
        </div>
    </div>

    <hr>

    <!-- Seção: Datas -->
    <h5 class="text-primary mb-3 mt-4"><i class="far fa-calendar-alt"></i> Datas</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'data_inicio')->input('datetime-local') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'data_fim')->input('datetime-local') ?>
        </div>
    </div>

    <hr>

    <!-- Seção: Mídia e Status -->
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-image"></i> Mídia e Status</h5>
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header p-2">Imagem Atual</div>
                <div class="card-body text-center p-2">
                    <img id="preview-image" style="display:none; max-height: 150px; width: auto;" class="img-fluid rounded" alt="Preview">
                    <?php if ($model->imagem): ?>
                        <?= Html::img($model->getImage(), [
                            'style' => 'max-height: 150px; width: auto;', 
                            'class' => 'img-fluid rounded'
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <?= $form->field($uploadForm, 'imageFile')->fileInput(['class' => 'form-control-file', 'data-image-preview' => 'preview-image']) ?>
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
                        <i class="fas fa-info-circle"></i> Se desativado, o evento não aparecerá no frontend.
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