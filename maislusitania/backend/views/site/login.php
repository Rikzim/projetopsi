<?php

/** @var yii\web\View $this */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login - Back Office';
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <?= Html::img('@web/../../frontend/web/images/logo/Logo.svg', [
                    'alt' => 'Mais Lusitânia',
                    'class' => 'img-fluid',
                    'style' => 'max-width: 200px;'
                ]) ?>
            </div>

            <div class="card shadow">
                <div class="card-body p-4">
                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <?= Yii::$app->session->getFlash('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?= Yii::$app->session->getFlash('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                    ]); ?>

                    <?= $form->field($model, 'username', [
                        'template' => '{label}{input}{error}',
                    ])->textInput([
                        'placeholder' => 'Digite seu utilizador',
                        'class' => 'form-control form-control-lg',
                        'autocomplete' => 'username'
                    ])->label('Utilizador', ['class' => 'font-weight-bold']) ?>

                    <?= $form->field($model, 'password', [
                        'template' => '{label}{input}{error}',
                    ])->passwordInput([
                        'placeholder' => 'Digite sua password',
                        'class' => 'form-control form-control-lg',
                        'autocomplete' => 'current-password'
                    ])->label('Password', ['class' => 'font-weight-bold']) ?>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <?= Html::activeCheckbox($model, 'rememberMe', [
                                'class' => 'custom-control-input',
                                'id' => 'rememberMe',
                                'uncheck' => null
                            ]) ?>
                            <label class="custom-control-label" for="rememberMe"></label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <?= Html::submitButton('Entrar', [
                            'class' => 'btn btn-primary btn-lg btn-block',
                            'name' => 'login-button'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">© <?= date('Y') ?> Mais Lusitânia. Todos os direitos reservados.</small>
            </div>
        </div>
    </div>
</div>

<style>
    body.login-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-attachment: fixed;
    }
    
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .btn-primary {
        background-color: #667eea;
        border-color: #667eea;
        font-weight: 600;
    }
    
    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #5568d3;
        border-color: #5568d3;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #667eea;
        border-color: #667eea;
    }
</style>