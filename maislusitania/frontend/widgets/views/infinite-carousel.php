<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
                        <?php 
                        $cardContent = '';
                        
                        if (isset($item['image'])) {
                            $cardContent .= Html::img($item['image'], [
                                'class' => 'card-img',
                            ]);
                            
                            $cardContent .= '<div class="card-overlay">';
                            if (isset($item['title'])) {
                                $cardContent .= '<h3 class="card-title">' . Html::encode($item['title']) . '</h3>';
                            }
                            if (isset($item['subtitle'])) {
                                $cardContent .= '<p class="card-subtitle">' . Html::encode($item['subtitle']) . '</p>';
                            }
                            $cardContent .= '</div>';
                        } else {
                            $cardContent = isset($item['content']) ? Html::encode($item['content']) : '';
                        }
                        
                        if (isset($item['url'])) {
                            echo Html::a($cardContent, $item['url'], ['class' => 'card']);
                        } else {
                            echo '<div class="card">' . $cardContent . '</div>';
                        }
                        ?>
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