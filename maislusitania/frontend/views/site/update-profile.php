<?php

/** @var yii\web\View $this */
/** @var common\models\UserProfile $profile */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Atualizar Perfil';
$this->registerCssFile('@web/css/site/update-profile.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="profile-page">
    <!-- Header Section -->
    <div class="profile-header">
        <div class="profile-header-content">
            <h1 class="profile-title">Editar Perfil</h1>
            <p class="profile-subtitle">Mantenha os seus dados atualizados</p>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            
            <div class="profile-form-section">
                <?php $form = ActiveForm::begin([
                    'id' => 'update-profile-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                ]); ?>

                <!-- Avatar Section -->
                <div class="avatar-section">
                    <div class="avatar-preview-wrapper">
                        <?php if ($model->imagem_perfil): ?>
                            <?= Html::img($model->getImage() , ['class' => 'avatar-img']) ?>
                        <?php else: ?>
                            <div class="avatar-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#2E5AAC" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <div class="avatar-edit-overlay">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 16 16">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="avatar-input-container">
                        <?= $form->field($uploadForm, 'imageFile')->fileInput([
                            'class' => 'form-control-file',
                            'accept' => 'image/*'
                        ])->label(false) ?>
                        <small class="text-muted">Clique para alterar a foto (JPG, PNG)</small>
                    </div>
                </div>

                <div class="form-divider"></div>

                <!-- Fields Section -->
                <div class="fields-container">
                    <h3 class="section-label">Informações da Conta</h3>
                    
                    <div class="form-group full-width">
                        <?= $form->field($model, 'username')->textInput([
                            'class' => 'form-control modern-input',
                            'placeholder' => 'Seu nome de usuário'
                        ]) ?>
                    </div>

                    <h3 class="section-label mt-4">Dados Pessoais</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <?= $form->field($model, 'primeiro_nome')->textInput([
                                'class' => 'form-control modern-input',
                                'placeholder' => 'Seu primeiro nome'
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'ultimo_nome')->textInput([
                                'class' => 'form-control modern-input',
                                'placeholder' => 'Seu último nome'
                            ]) ?>
                        </div>                    
                    </div>
                </div>

                <div class="form-actions">
                    <?= Html::submitButton('Salvar Alterações', ['class' => 'btn btn-primary btn-lg']) ?>
                    <?= Html::a('Cancelar', ['site/profile'], ['class' => 'btn btn-secondary btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>