<?php

/** @var yii\web\View $this */
/** @var array $museusItems */
/** @var array $monumentosItems */

use frontend\widgets\HeroSection;
use frontend\widgets\InfiniteCarousel;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => '@web/images/hero-background.jpg',
            'title' => 'Descubra o Património Histórico de Portugal',
            'subtitle' => 'Explore museus, monumentos e experiências culturais inesquecíveis.',
            'buttons' => [
                    ['text' => 'Ver mapa Interativo', 'url' => ['/mapa/index']]
            ]
    ]) ?>
    
    <!-- Carrossel de Museus em Destaque -->
    <?php if (!empty($museusItems)): ?>
        <div class="mb-5">
            <h2 class="text-center mb-4" style="color: #2E5AAC;">Museus em Destaque</h2>
            <?= InfiniteCarousel::widget([
                    'carouselId' => 'museus-carousel',
                    'cardWidth' => 500,
                    'cardHeight' => 300,
                    'cardGap' => 2,
                    'backgroundColor' => '#2E5AAC',
                    'items' => $museusItems,
            ]) ?>
        </div>
    <?php endif; ?>

    <!-- Carrossel de Monumentos -->
    <?php if (!empty($monumentosItems)): ?>
        <div class="mb-5">
            <h2 class="text-center mb-4" style="color: #2E5AAC;">Monumentos Históricos</h2>
            <?= InfiniteCarousel::widget([
                    'carouselId' => 'monumentos-carousel',
                    'cardWidth' => 450,
                    'cardHeight' => 280,
                    'cardGap' => 1.5,
                    'backgroundColor' => '#3498db',
                    'items' => $monumentosItems,
            ]) ?>
        </div>
    <?php endif; ?>

    <!-- Conteúdo Original -->
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Museus</h2>
                <p>Explore a rica história e cultura de Portugal através dos nossos museus.</p>
                <p><a class="btn btn-outline-secondary" href="<?= Url::to(['/local-cultural/index', 'tipo' => 'museu']) ?>">Ver Museus &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Monumentos</h2>
                <p>Descubra os monumentos mais emblemáticos do nosso património.</p>
                <p><a class="btn btn-outline-secondary" href="<?= Url::to(['/local-cultural/index', 'tipo' => 'monumento']) ?>">Ver Monumentos &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Eventos</h2>
                <p>Fique a par dos próximos eventos culturais e exposições.</p>
                <p><a class="btn btn-outline-secondary" href="<?= Url::to(['/evento/index']) ?>">Ver Eventos &raquo;</a></p>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss("
    body {
        margin: 0 !important;
        padding: 0 !important;
    }
");
?>




