<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $eventos array */
?>

<style>
    .section-title-eventos {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        color: #1a1a1a;
        max-width: 900px;
        margin: 40px auto 20px;
    }

    .section-icon-eventos {
        width: 32px;
        height: 32px;
        background: #2E5AAC;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
        font-size: 18px;
    }

    .eventos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        max-width: 900px;
        margin: 0 auto 40px;
    }

    .evento-card {
        background: white;
        border: 2px solid #2E5AAC;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .evento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(65, 105, 225, 0.2);
    }

    .evento-card-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, #2E5AAC 0%, #6B8EF5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
    }

    .evento-card-content {
        padding: 20px;
    }

    .evento-card-content h3 {
        font-size: 16px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .evento-card-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
        font-size: 12px;
        color: #666;
        flex-wrap: wrap;
    }

    .evento-card-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .evento-card-description {
        font-size: 13px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-ver-mais-evento {
        background: #2E5AAC;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        border: none;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s;
    }

    .btn-ver-mais-evento:hover {
        background: #2952cc;
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .eventos-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .eventos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="section-title-eventos">
    <span class="section-icon-eventos"><img src="<?= Url::to('@web/images/icons/icon-event.svg') ?>"></span>
    Eventos Relacionados
</div>

    

<div class="eventos-grid">
    <?php if (empty($eventos)): ?>
        <p style="text-align: center; color: #666; padding: 30px 15px; font-size: 15px; grid-column: 1 / -1;">
            Nenhum evento relacionado disponível no momento.
        </p>
    <?php else: ?>

    <?php foreach ($eventos as $evento): ?>
        <div class="evento-card">
            <?php if (isset($evento['imagem']) && $evento['imagem']): ?>
                <img src="<?= Url::to($evento->getImage()) ?>"
                     alt="<?= Html::encode($evento['titulo']) ?>" 
                     class="evento-card-image">
            <?php else: ?>
                <div class="evento-card-image"><img src="<?= Url::to('@web/images/icons/icon-event.svg') ?>"></div>
            <?php endif; ?>
            
            <div class="evento-card-content">
                <h3><?= Html::encode($evento['titulo']) ?></h3>
                
                <div class="evento-card-meta">
                    <span><img src="<?= Url::to('@web/images/icons/icon-calender.svg') ?>"> <?= Yii::$app->formatter->asDatetime($evento['data_inicio'], 'php:d/m/Y H:i') ?></span>
                    <span><img src="<?= Url::to('@web/images/icons/icon-calender.svg') ?>"> <?= Yii::$app->formatter->asDatetime($evento['data_fim'], 'php:d/m/Y H:i') ?></span>
                </div>
                
                <p class="evento-card-description">
                    <?= Html::encode($evento['descricao']) ?>
                </p>
                
                <?= Html::a('Ver Mais', ['evento/view', 'id' => $evento['id']], ['class' => 'btn-ver-mais-evento']) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php endif; ?>
</div>