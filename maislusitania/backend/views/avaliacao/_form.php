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

<?php
$this->registerCssFile('@web/css/form-layout.css');
$this->registerCssFile('@web/css/avaliacao/form.css');
?>

<div class="avaliacao-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="split-screen-container">
        
        <!-- Left Column -->
        <div class="form-main-content">
            
            <!-- Card: Details -->
            <div class="form-card">
                <div class="form-card-title">Detalhes da Avaliação</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'local_id')->widget(Select2::class, [
                            'data' => $locaisAtivos,    
                            'options' => ['placeholder' => 'Selecione o local...'],
                            'pluginOptions' => ['allowClear' => true],
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'utilizador_id')->widget(Select2::class, [
                            'data' => $utilizadoresAtivos,
                            'options' => ['placeholder' => 'Selecione o Utilizador...'],
                            'pluginOptions' => ['allowClear' => true],
                        ]) ?>
                    </div>
                </div>

                <?= $form->field($model, 'classificacao')->dropDownList([
                    1 => '⭐ 1 Estrela',
                    2 => '⭐⭐ 2 Estrelas',
                    3 => '⭐⭐⭐ 3 Estrelas',
                    4 => '⭐⭐⭐⭐ 4 Estrelas',
                    5 => '⭐⭐⭐⭐⭐ 5 Estrelas',
                ], ['prompt' => 'Classificação...']) ?>

                <?= $form->field($model, 'comentario')->textarea(['rows' => 6, 'placeholder' => 'Comentário sobre o local...']) ?>
            </div>

        </div>

        <!-- Right Column -->
        <div class="form-sidebar">
            <div class="sticky-sidebar">
                
                <!-- Card: Status -->
                <div class="form-card">
                    <div class="form-card-title">Estado</div>
                    
                    <?= $form->field($model, 'ativo')->checkbox([
                        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>{error}",
                        'class' => 'custom-control-input',
                        'labelOptions' => ['class' => 'custom-control-label']
                    ]) ?>

                    <hr>

                    <?= $form->field($model, 'data_avaliacao')->input('datetime-local', ['readonly' => true]) ?>
                </div>

                <!-- Card: Actions -->
                <div class="form-card">
                    <div class="form-card-title">Ações</div>
                    
                    <div class="form-actions">
                        <?= Html::submitButton('Guardar Avaliação', ['class' => 'btn btn-primary btn-block btn-lg-custom']) ?>
                        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary btn-block']) ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>