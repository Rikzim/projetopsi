<?php

/** @var yii\web\View $this */
/** @var array $museusItems */
/** @var array $monumentosItems */

use frontend\widgets\HeroSection;
use frontend\widgets\InfiniteCarousel;
use frontend\widgets\CuriosidadesSection;
use yii\helpers\Url;

$this->title = 'My Yii Application';
$this->registerCssFile('@web/css/homepage.css');
?>

<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => 'http://172.22.21.218/projetopsi/maislusitania/frontend/web/images/hero-background.jpg',
            'title' => 'Descubra o Património Histórico de Portugal',
            'subtitle' => 'Explore museus, monumentos e experiências culturais inesquecíveis.',
            'buttons' => [
                    ['text' => 'Ver mapa Interativo', 'url' => ['/mapa/index']]
            ]
    ]) ?>

    <!-- Carrossel de Museus em Destaque -->
    <?php if (!empty($museusItems)): ?>
        <div class="homepage-section">
            <div class="section-header">
                <h2 class="section-title">
                    Museus em Destaque
                </h2>
                <p class="section-subtitle">
                    Conheça os espaços culturais mais visitados do país.
                </p>
            </div>
            <?= InfiniteCarousel::widget([
                    'carouselId' => 'museus-carousel',
                    'cardWidth' => 500,
                    'cardHeight' => 300,
                    'cardGap' => 2,
                    'items' => $museusItems,
            ]) ?>
        </div>
    <?php endif; ?>

    <!-- Secção de Curiosidades -->
    <?= CuriosidadesSection::widget([
            'title' => 'Curiosidades do Nosso Património',
            'backgroundColor' => '#2E5AAC',
            'cards' => [
                    [
                            'image' => '@web/images/locais/mosteiro-jeronimos.jpg',
                            'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/locais/torre-belem.jpg',
                            'title' => 'A Torre de Belém foi construída para defender Lisboa.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/locais/palacio-pena.jpg',
                            'title' => 'O Palácio da Pena é um dos 7 monumentos mais emblemáticos de Portugal.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/locais/convento-cristo.jpg',
                            'title' => 'O Convento de Cristo é Património Mundial da UNESCO.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ]
            ]
    ]) ?>


    <!-- Carrossel de Monumentos -->
    <?php if (!empty($monumentosItems)): ?>
        <div class="homepage-section">
            <div class="section-header">
                <h2 class="section-title">
                    Monumentos Históricos
                </h2>
                <p class="section-subtitle">
                    Descubra os monumentos mais emblemáticos do nosso património.
                </p>
            </div>
            <?= InfiniteCarousel::widget([
                    'carouselId' => 'monumentos-carousel',
                    'cardWidth' => 450,
                    'cardHeight' => 280,
                    'cardGap' => 1.5,
                    'items' => $monumentosItems,
            ]) ?>
        </div>
    <?php endif; ?>
</div>
