<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $locaisAtivos */
/** @var array $utilizadoresAtivos */
?>

<div class="avaliacao-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <!-- Seção: Informações Principais -->
    <h5 class="text-primary mb-3"><i class="fas fa-star"></i> Informações da Avaliação</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'local_id')->widget(Select2::class, [
                'data' => $locaisAtivos,
                'options' => ['placeholder' => 'Selecione o local...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'utilizador_id')->widget(Select2::class, [
                'data' => $utilizadoresAtivos,
                'options' => ['placeholder' => 'Selecione o Utilizador...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'classificacao')->dropDownList(
                [
                    1 => '⭐ 1 Estrela',
                    2 => '⭐⭐ 2 Estrelas',
                    3 => '⭐⭐⭐ 3 Estrelas',
                    4 => '⭐⭐⭐⭐ 4 Estrelas',
                    5 => '⭐⭐⭐⭐⭐ 5 Estrelas',
                ],
                ['prompt' => 'Selecione a Classificação...']
            ) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'comentario')->textarea([
                'rows' => 6, 
                'placeholder' => 'Escreva o comentário sobre o local...'
            ]) ?>
        </div>
    </div>

    <hr>

    <!-- Seção: Data e Status -->
    <h5 class="text-primary mb-3 mt-4"><i class="fas fa-calendar-alt"></i> Data e Status</h5>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'data_avaliacao')->input('datetime-local', [
                'value' => $model->isNewRecord ? date('Y-m-d H:i:s') : $model->data_avaliacao,
                'readonly' => true,
            ]) ?>
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
                        <i class="fas fa-info-circle"></i> Se desativado, a avaliação não aparecerá no frontend.
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