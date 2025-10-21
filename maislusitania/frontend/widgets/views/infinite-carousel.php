<?php
use yii\helpers\Html;
?>

<div id="<?= Html::encode($carouselId) ?>">
    <div class="carousel-wrapper">
        <div class="carousel-track">
            <?php foreach ($items as $item): ?>
                <div class="carousel-card">
                    <div class="card text-white">
                        <?= Html::img($item['image'], ['class' => 'card-img', 'alt' => Html::encode($item['title'])]) ?>
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                            <h5 class="card-title"><?= Html::encode($item['title']) ?></h5>
                            <p class="card-text"><?= Html::encode($item['subtitle']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>