<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\UserProfile $userProfile */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Meu Perfil';
$this->registerCssFile('@web/css/site/profile.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="profile-page">
    <!-- Header Section -->
    <div class="profile-header">
        <div class="profile-header-content">
            <h1 class="profile-title">Meu Perfil</h1>
        </div>
    </div>

    <div class="profile-container">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar-section">
                <div class="profile-avatar">
                    <?php if ($user->userProfile && $user->userProfile->imagem_perfil): ?>
                        <?= Html::img('/uploads/' . $user->userProfile->imagem_perfil, [
                            'alt' => 'Imagem de Perfil',
                            'class' => 'avatar-image'
                        ]) ?>
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#2E5AAC" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="profile-name-section">
                    <h2 class="profile-name">
                        <?= $user->userProfile ? Html::encode($user->userProfile->primeiro_nome . ' ' . $user->userProfile->ultimo_nome) : Html::encode($user->username) ?>
                    </h2>
                    <p class="profile-username">@<?= Html::encode($user->username) ?></p>
                </div>
                <?= Html::a('Editar Perfil', ['/profile/update'], ['class' => 'btn-edit-profile']) ?>
            </div>

            <div class="profile-divider"></div>

            <!-- Profile Information -->
            <div class="profile-info-section">
                <h3 class="info-section-title">Informações Pessoais</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-profile36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Primeiro Nome</span>
                            <span class="info-value"><?= $user->userProfile ? Html::encode($user->userProfile->primeiro_nome) : '-' ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-profile36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Último Nome</span>
                            <span class="info-value"><?= $user->userProfile ? Html::encode($user->userProfile->ultimo_nome) : '-' ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-email36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email</span>
                            <span class="info-value"><?= Html::encode($user->email) ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-calendar36.svg') ?>" alt="">
                        </div>
                        <div class="info-content">
                            <span class="info-label">Membro desde</span>
                            <span class="info-value"><?= Yii::$app->formatter->asDate($user->created_at, 'php:d/m/Y') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-divider"></div>

            <!-- Quick Actions -->
            <div class="profile-actions-section">
                <h3 class="info-section-title">Ações Rápidas</h3>
                
                <div class="quick-actions">
                    <a href="<?= Url::to(['/site/favorites']) ?>" class="action-card">
                        <div class="action-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-favorite.svg') ?>" alt="">
                        </div>
                        <div class="action-content">
                            <h4 class="action-title">Favoritos</h4>
                            <p class="action-description">Veja os seus locais favoritos</p>
                        </div>
                    </a>

                    <a href="<?= Url::to(['/site/bilhetes']) ?>" class="action-card">
                        <div class="action-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-ticket.svg') ?>" alt="">
                        </div>
                        <div class="action-content">
                            <h4 class="action-title">Meus Bilhetes</h4>
                            <p class="action-description">Gerencie as suas reservas</p>
                        </div>
                    </a>

                    <a href="<?= Url::to(['site/request-password-reset']) ?>" class="action-card">
                        <div class="action-icon">
                            <img src="<?= Url::to('@web/images/icons/blue/icon-reset.svg') ?>" alt="">
                        </div>
                        <div class="action-content">
                            <h4 class="action-title">Alterar Palavra-Passe</h4>
                            <p class="action-description">Atualize a sua palavra-passe</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>