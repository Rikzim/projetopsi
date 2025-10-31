<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registar';
    
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

.signup-wrapper {
    min-height: 100vh;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
}

.signup-container {
    background: #ffffff;
    border-radius: 25px;
    overflow: hidden;
    max-width: 420px;
    width: 100%;
    margin: 1rem;
    padding: 3rem 2.5rem;
    border: 4px solid #2E5AAC;
}

.signup-logo {
    text-align: center;
    margin-bottom: 2.5rem;
}

.signup-logo img {
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

.btn-signup {
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

.btn-signup:hover {
    background: #1e4a9c;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 90, 172, 0.3);
}

.signup-footer {
    text-align: center;
    margin-top: 2rem;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 500;
}

.signup-footer a {
    color: #2E5AAC;
    text-decoration: none;
    font-weight: 600;
}

.signup-footer a:hover {
    text-decoration: underline;
}

.help-block {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    padding-left: 1.5rem;
}

@media (max-width: 768px) {
    .signup-container {
        margin: 1rem;
        padding: 2.5rem 2rem;
    }
    
    .signup-logo img {
        width: 200px;
    }
}
CSS
);
?>

<div class="signup-wrapper">
    <div class="signup-container">
        <!-- Logo no topo -->
        <div class="signup-logo">
            <?= Html::img('@web/images/logo/alt-logo.svg', ['alt' => '+Lusitânia']) ?>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>
            <?= $form->field($model, 'primeiro_nome')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Insira o seu primeiro nome',
                    'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'ultimo_nome')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Insira o seu apelido',
                    'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Insira o nome de utilizador',
                'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'placeholder' => 'Insira o seu email',
                'class' => 'form-control',
                'type' => 'email'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Insira a palavra-passe',
                'class' => 'form-control'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Registar', ['class' => 'btn btn-signup', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="signup-footer">
            Já possui conta? <?= Html::a('Iniciar sessão', ['site/login']) ?>
        </div>
    </div>
</div>