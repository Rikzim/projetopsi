<?php
use yii\helpers\Html;
?>

<div id="<?= $carouselId ?>" class="infinite-carousel">
    <div class="carousel-container">
        <!-- Botão Anterior -->
        <div class="carousel-nav prev">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
        </div>
        
        <!-- Carrossel -->
        <div class="carousel-wrapper">
            <div class="carousel-track">
                <?php foreach ($items as $item): ?>
                    <div class="carousel-card">
                        <div class="card">
                            <?= isset($item['content']) ? Html::encode($item['content']) : '' ?>
                            <?php if (isset($item['image'])): ?>
                                <?= Html::img($item['image'], ['class' => 'card-img']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Botão Próximo -->
        <div class="carousel-nav next">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
        </div>
    </div>
</div>