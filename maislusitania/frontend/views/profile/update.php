<?php

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */
/** @var common\models\UploadForm $uploadForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Editar Perfil';
// Nota: Carregamos o CSS específico que é baseado no profile.css
$this->registerCssFile('@web/css/profile/update-profile.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="profile-page">
    <div class="profile-header">
        <div class="profile-header-content">
            <h1 class="profile-title">Editar Perfil</h1>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            
            <?php $form = ActiveForm::begin([
                'id' => 'update-profile-form',
                'options' => ['enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "{input}\n{error}", // Removemos label padrão do Yii para usar o nosso layout
                    'options' => ['tag' => false], // Remove wrapper extra do form-group para não quebrar o grid
                ],
            ]); ?>

            <div class="profile-avatar-section">
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <?php if ($model->imagem_perfil): ?>
                            <?= Html::img($model->getImage(), ['class' => 'avatar-image']) ?>
                        <?php else: ?>
                            <div class="avatar-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#2E5AAC" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <label for="upload-input" class="avatar-overlay">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" viewBox="0 0 16 16">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                            </svg>
                        </label>
                    </div>
                </div>

                <div style="display:none">
                    <?= $form->field($uploadForm, 'imageFile')->fileInput(['id' => 'upload-input']) ?>
                </div>

                <div class="profile-name-section">
                    <h2 class="profile-name">
                        <?= Html::encode($model->primeiro_nome . ' ' . $model->ultimo_nome) ?>
                    </h2>
                    <p class="profile-username">@<?= Html::encode($model->username) ?></p>
                </div>
            </div>

            <div class="profile-divider"></div>

            <div class="profile-info-section">
                <h3 class="info-section-title">Informações Pessoais</h3>
                
                <div class="info-grid">
                    <div class="info-item form-mode">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-profile36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Primeiro Nome</span>
                            <?= $form->field($model, 'primeiro_nome')->textInput([
                                'class' => 'profile-input',
                                'placeholder' => 'Digite seu nome'
                            ]) ?>
                        </div>
                    </div>

                    <div class="info-item form-mode">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-profile36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Último Nome</span>
                            <?= $form->field($model, 'ultimo_nome')->textInput([
                                'class' => 'profile-input',
                                'placeholder' => 'Digite seu sobrenome'
                            ]) ?>
                        </div>
                    </div>

                    <div class="info-item form-mode">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-email36.svg') ?>" alt=""> </div>
                        <div class="info-content">
                            <span class="info-label">Nome de Usuário</span>
                            <?= $form->field($model, 'username')->textInput([
                                'class' => 'profile-input',
                                'placeholder' => 'Seu username'
                            ]) ?>
                        </div>
                    </div>

                    <div class="info-item form-mode disabled">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-email36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email (Não editável)</span>
                             <div class="profile-input-static"><?= Html::encode($model->user->email ?? '') ?></div>
                        </div>
                    </div>
                </div>

                <div class="form-actions-container">
                    <?= Html::submitButton('Guardar Alterações', ['class' => 'btn-action-primary']) ?>
                    <?= Html::a('Cancelar', ['profile/me'], ['class' => 'btn-action-secondary']) ?>
                </div>

            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>