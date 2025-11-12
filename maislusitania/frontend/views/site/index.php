<?php

/** @var yii\web\View $this */
/** @var array $museusItems */
/** @var array $monumentosItems */

use frontend\widgets\HeroSection;
use frontend\widgets\InfiniteCarousel;
use frontend\widgets\CuriosidadesSection;
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
        <div style="background: white; padding: 60px 0 80px 0;">
            <div style="text-align: center; margin-bottom: 60px; padding: 0 20px;">
                <h2 style="color: #2E5AAC; font-size: 2.8rem; font-weight: bold; margin: 0 0 15px 0; font-family: Georgia, serif;">
                    Museus em Destaque
                </h2>
                <p style="color: #2E5AAC; font-size: 1.2rem; margin: 0; font-weight: normal;">
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
                            'image' => '@web/images/hero-background.jpg',
                            'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/hero-background.jpg',
                            'title' => 'A Torre de Belém foi construída para defender Lisboa.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/hero-background.jpg',
                            'title' => 'O Palácio da Pena é um dos 7 monumentos mais emblemáticos de Portugal.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ],
                    [
                            'image' => '@web/images/hero-background.jpg',
                            'title' => 'O Convento de Cristo é Património Mundial da UNESCO.',
                            'buttonText' => 'Ver mais',
                            'url' => '#'
                    ]
            ]
    ]) ?>


    <!-- Carrossel de Monumentos -->
    <?php if (!empty($monumentosItems)): ?>
        <div style="background: white; padding: 60px 0 80px 0;">
            <div style="text-align: center; margin-bottom: 60px; padding: 0 20px;">
                <h2 style="color: #2E5AAC; font-size: 2.8rem; font-weight: bold; margin: 0 0 15px 0; font-family: Georgia, serif;">
                    Monumentos Históricos
                </h2>
                <p style="color: #2E5AAC; font-size: 1.2rem; margin: 0; font-weight: normal;">
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
