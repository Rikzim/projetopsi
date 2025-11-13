<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $showPreco boolean */
/* @var $precoText string */
?>

<style>
    .info-uteis-card {
        background: white;
        border: 2px solid #4169E1;
        border-radius: 20px;
        padding: 25px;
    }

    .info-uteis-card-title {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .info-uteis-card-icon {
        width: 32px;
        height: 32px;
        background: #4169E1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
        font-size: 18px;
    }

    .info-item {
        margin-bottom: 15px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-weight: bold;
        color: #1a1a1a;
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .info-value {
        color: #666;
        font-size: 14px;
        word-break: break-word;
    }

    .info-value a {
        color: #4169E1;
        text-decoration: none;
    }

    .info-value a:hover {
        text-decoration: underline;
    }
</style>

<div class="info-uteis-card">
    <div class="info-uteis-card-title">
        <span class="info-uteis-card-icon"><img src="<?= \yii\helpers\Url::to('@web/images/icons/icon-info.svg') ?>"></span>
        Informações Úteis
    </div>

    <?php if ($model->morada): ?>
        <div class="info-item">
            <span class="info-label">Morada</span>
            <span class="info-value"><?= Html::encode($model->morada) ?></span>
        </div>
    <?php endif; ?>

    <?php if ($showPreco): ?>
        <div class="info-item">
            <span class="info-label">Preço de Ingresso</span>
            <span class="info-value"><?= Html::encode($precoText) ?></span>
        </div>
    <?php endif; ?>

    <?php if ($model->contacto_telefone): ?>
        <div class="info-item">
            <span class="info-label">Telefone</span>
            <span class="info-value">
                <a href="tel:<?= Html::encode($model->contacto_telefone) ?>">
                    <?= Html::encode($model->contacto_telefone) ?>
                </a>
            </span>
        </div>
    <?php endif; ?>

    <?php if ($model->contacto_email): ?>
        <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value">
                <a href="mailto:<?= Html::encode($model->contacto_email) ?>">
                    <?= Html::encode($model->contacto_email) ?>
                </a>
            </span>
        </div>
    <?php endif; ?>

    <?php if ($model->website): ?>
        <div class="info-item">
            <span class="info-label">Website</span>
            <span class="info-value">
                <a href="<?= Html::encode($model->website) ?>" target="_blank" rel="noopener noreferrer">
                    <?= Html::encode($model->website) ?>
                </a>
            </span>
        </div>
    <?php endif; ?>
</div>