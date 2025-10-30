<?php

/** @var yii\web\View $this */
/** @var array $museusItems */
/** @var array $monumentosItems */

use frontend\widgets\CustomNavBar;
use frontend\widgets\InfiniteCarousel;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Bem-vindo ao +Lusitânia!</h1>
            <p class="fs-5 fw-light">Descubra os melhores museus e monumentos de Portugal.</p>
            <p><a class="btn btn-lg btn-primary" href="<?= Url::to(['/mapa/index']) ?>">Ver Mapa</a></p>
        </div>
    </div>

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