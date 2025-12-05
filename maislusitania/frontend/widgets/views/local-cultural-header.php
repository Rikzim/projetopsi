<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $showBadge boolean */
/* @var $showRating boolean */
/* @var $averageRating float */
/* @var $ratingCount int */
?>

<style>
    .lc-header-card {
        background: white;
        border-radius: 20px;
        padding: 30px 30px 30px 30px;
        margin: 0 auto 30px;
        max-width: 900px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 10;
        border: 2px solid #2E5AAC;
        margin-top: 40px;
    }

    .lc-header-card h1 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #1a1a1a;
    }

    .lc-location-info {
        display: flex;
        align-items: center;
        color: #666;
        margin-bottom: 15px;
        gap: 8px;
    }

    .lc-location-icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .lc-rating-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        gap: 10px;
    }

    .lc-stars {
        color: #2E5AAC;
        font-size: 20px;
    }

    .lc-stars-empty {
        color: #d0d0d0;
    }

    .lc-rating-text {
        color: #666;
        font-size: 14px;
    }

    .lc-type-badge {
        position: absolute;
        top: 30px;
        right: 30px;
        background: #2E5AAC;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .lc-header-card {
            padding: 20px;
        }

        .lc-header-card h1 {
            font-size: 22px;
            padding-right: 100px;
        }

        .lc-type-badge {
            top: 20px;
            right: 20px;
            padding: 6px 15px;
            font-size: 12px;
        }
    }
</style>

<div class="lc-header-card">
    
    <?php if ($showBadge && $model->tipo): ?>
        <span class="lc-type-badge">
            <?= Html::encode($model->tipo->nome ?? 'Local Cultural') ?>
        </span>
    <?php endif; ?>
 
    
    <div class="lc-location-info">
        <svg class="lc-location-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
        </svg>
        <span>
            <?= Html::encode($model->distrito ? $model->distrito->nome : 'Portugal') ?>, Portugal
        </span>
    </div>

    <?php if ($showRating): ?>
        <div class="lc-rating-container">
            <div class="lc-stars">
                <?php
                $fullStars = floor($averageRating);
                $hasHalfStar = ($averageRating - $fullStars) >= 0.5;

                // Estrelas cheias
                for ($i = 0; $i < $fullStars; $i++) {
                    echo '★';
                }

                // Meia estrela
                if ($hasHalfStar) {
                    echo '☆';
                }

                // Estrelas vazias
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<span class="lc-stars-empty">☆</span>';
                }
                ?>
            </div>
            <span class="lc-rating-text">
            <?php if ($ratingCount > 0): ?>
                <?= number_format($averageRating, 1) ?> (<?= number_format($ratingCount) ?> Avaliações)
            <?php else: ?>
                Sem avaliações
            <?php endif; ?>
        </span>
        </div>
    <?php endif; ?>


</div>