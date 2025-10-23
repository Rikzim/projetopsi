<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
    
$this->registerCss(<<<CSS
body {
    margin: 0 !important;
    padding: 0 !important;
}

main {
    padding: 0 !important;
    margin: 0 !important;
}

.container {
    max-width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
}

.login-wrapper {
    min-height: 100vh;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
}

.login-container {
    background: #ffffff;
    border-radius: 25px;
    overflow: hidden;
    max-width: 420px;
    width: 100%;
    margin: 1rem;
    padding: 3rem 2.5rem;
    border: 4px solid #2E5AAC;
}

.login-logo {
    text-align: center;
    margin-bottom: 2.5rem;
}

.login-logo img {
    width: 250px;
    height: auto;
    max-width: 100%;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-control {
    border: 2px solid #2E5AAC;
    border-radius: 25px;
    padding: 0.875rem 1.5rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #ffffff;
}

.form-control:focus {
    border-color: #1e4a9c;
    box-shadow: 0 0 0 0.2rem rgba(46, 90, 172, 0.1);
    background-color: #f8f9fa;
}

.form-control::placeholder {
    color: #2E5AAC;
    opacity: 0.6;
}

.form-label {
    display: none;
}

.field-loginform-rememberme {
    margin-top: 1rem;
    margin-bottom: 1.5rem;
}

.form-check {
    padding-left: 1.5rem;
}

.form-check-input {
    border: 2px solid #2E5AAC;
    border-radius: 4px;
}

.form-check-input:checked {
    background-color: #2E5AAC;
    border-color: #2E5AAC;
}

.form-check-label {
    color: #495057;
    font-size: 0.9rem;
    font-weight: 500;
}

.btn-login {
    width: 100%;
    padding: 0.875rem;
    background: #2E5AAC;
    border: none;
    border-radius: 25px;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    margin-top: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-login:hover {
    background: #1e4a9c;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 90, 172, 0.3);
}

.login-footer {
    text-align: center;
    margin-top: 2rem;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 500;
}

.login-footer a {
    color: #2E5AAC;
    text-decoration: none;
    font-weight: 600;
}

.login-footer a:hover {
    text-decoration: underline;
}

.login-links {
    text-align: center;
    margin-top: 1.25rem;
}

.login-links a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.3s ease;
}

.login-links a:hover {
    color: #2E5AAC;
    text-decoration: underline;
}

.help-block {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    padding-left: 1.5rem;
}

@media (max-width: 768px) {
    .login-container {
        margin: 1rem;
        padding: 2.5rem 2rem;
    }
    
    .login-logo img {
        width: 200px;
    }
}
CSS
);
?>

<div class="login-wrapper">
    <div class="login-container">
        <!-- Logo no topo -->
        <div class="login-logo">
            <?= Html::img('@web/images/logo/alt-logo.svg', ['alt' => '+Lusitânia']) ?>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Insira o utilizador',
                'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Insira a palavra-passe',
                'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                'labelOptions' => ['class' => 'form-check-label'],
            ])->label('Lembrar-me') ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="login-footer">
            Não possui conta? <?= Html::a('Registar-se', ['site/signup']) ?>
        </div>

        <div class="login-links">
            <?= Html::a('Esqueceu a palavra-passe?', ['site/request-password-reset']) ?>
            <br>
            <?= Html::a('Reenviar email de verificação', ['site/resend-verification-email']) ?>
        </div>
    </div>
</div>