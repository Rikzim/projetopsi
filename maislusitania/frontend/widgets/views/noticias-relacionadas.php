<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $noticias array */
?>

<style>
    .section-title-noticias {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        color: #1a1a1a;
        max-width: 900px;
        margin: 40px auto 20px;
    }

    .section-icon-noticias {
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

    .noticias-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        max-width: 900px;
        margin: 0 auto 40px;
    }

    .noticia-card {
        background: white;
        border: 2px solid #2E5AAC;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .noticia-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(65, 105, 225, 0.2);
    }

    .noticia-card-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, #2952cc 0%, #2E5AAC 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
    }

    .noticia-card-content {
        padding: 20px;
    }

    .noticia-card-content h3 {
        font-size: 16px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .noticia-card-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 12px;
        color: #666;
        flex-wrap: wrap;
    }

    .noticia-card-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .noticia-card-description {
        font-size: 13px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-ver-mais-noticia {
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

    .btn-ver-mais-noticia:hover {
        background: #2E5AAC;
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .noticias-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .noticias-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="section-title-noticias">
    <span class="section-icon-noticias"><img src="<?= Url::to('@web/images/icons/icon-noticias.svg') ?>"></span>
    Notícias Relacionadas
</div>

<div class="noticias-grid">

    <?php if (empty($noticias)): ?>
        <p style="text-align: center; color: #666; padding: 30px 15px; font-size: 15px; grid-column: 1 / -1;">
            Nenhuma notícia relacionada disponível no momento.
        </p>
    <?php else: ?>

    <?php foreach ($noticias as $noticia): ?>
        <div class="noticia-card">
            <?php $imageUrl = $noticia->getImage(); ?>
            <?php if ($imageUrl): ?>
                <img src="<?= Url::to($imageUrl) ?>"
                     alt="<?= Html::encode($noticia->titulo) ?>"
                     class="noticia-card-image">
            <?php else: ?>
                <div class="noticia-card-image"><img src="<?=Url::to('@web/images/icons/icon-noticias.svg') ?>"></div>
            <?php endif; ?>
            
            <div class="noticia-card-content">
                <h3><?= Html::encode($noticia->titulo) ?></h3>
                
                <div class="noticia-card-meta">
                    <span><img src="<?= Url::to('@web/images/icons/icon-calender.svg') ?>"> <?= Yii::$app->formatter->asDate($noticia->data_publicacao, 'long') ?></span>
                </div>
                
                <p class="noticia-card-description">
                    <?= Html::encode($noticia->resumo) ?>
                </p>
                
                <?= Html::a('Ver Mais', ['noticia/view', 'id' => $noticia->id], ['class' => 'btn-ver-mais-noticia']) ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>