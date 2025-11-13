<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $items array */
/* @var $cardWidth int */
/* @var $cardHeight int */
/* @var $cardGap int */
/* @var $carouselId string */
/* @var $backgroundColor string */
/* @var $prevArrow string */
/* @var $nextArrow string */

?>
<div id="<?= Html::encode($carouselId) ?>" style="background: <?= Html::encode($backgroundColor) ?>;">
    <div class="carousel-container">
        <div class="carousel-wrapper">
            <div class="carousel-track">
                <?php foreach ($items as $item):
                    $image = isset($item['image']) && is_string($item['image']) ? Url::to($item['image']) : null;
                    $title = isset($item['title']) && is_string($item['title']) ? $item['title'] : '';
                    $distrito = isset($item['distrito']) && is_string($item['distrito']) ? $item['distrito'] : (isset($item['subtitle']) && is_string($item['subtitle']) ? $item['subtitle'] : '');

                    // Handle both array and string URLs
                    $url = isset($item['url']) ? (is_array($item['url']) ? Url::to($item['url']) : $item['url']) : 'javascript:void(0);';
                    ?>
                    <div class="carousel-card">
                        <a class="card" href="<?= Html::encode($url) ?>">
                            <?php if ($image): ?>
                                <img class="card-img" src="<?= Html::encode($image) ?>" alt="<?= Html::encode($title) ?>">
                            <?php else: ?>
                                <div style="width:100%;height:100%;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#999;">
                                    <?= Html::encode($title) ?>
                                </div>
                            <?php endif; ?>

                            <div class="card-caption">
                                <p class="title"><?= Html::encode($title) ?></p>
                                <?php if ($distrito): ?>
                                    <p class="sub"><?= Html::encode($distrito) ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button class="carousel-nav prev" aria-label="previous">
            <img src="<?= Html::encode($prevArrow) ?>" alt="prev">
        </button>
        <button class="carousel-nav next" aria-label="next">
            <img src="<?= Html::encode($nextArrow) ?>" alt="next">
        </button>
    </div>
</div>
