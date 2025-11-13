<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\HeroSection;

// Register CSS
$this->registerCssFile('@web/css/about.css');
?>

<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => '@web/images/sobre-hero.jpg',
            'title' => 'Sobre o Projeto +Lusitânia',
            'subtitle' => 'Preservar e divulgar o património histórico e cultural de Portugal.',
            'buttons' => [
                    ['text' => 'Quem somos?', 'url' => '#site-about'],
                    ['text' => 'Nossa missão', 'url' => '#nossa-historia'],
            ]
    ]) ?>

    <!-- Nossa História Section -->
    <div class="site-about" id="site-about">
        <div class="about-content">
            <div class="about-text">
                <h1 class="about-title">Nossa História</h1>
                <div>
                    <p class="about-description">
                        O <strong>+Lusitânia</strong> surgiu da iniciativa de três estudantes do
                        CTeSP de Programação de Sistemas de Informação do Politécnico de Leiria,
                        motivados pela valorização do património cultural português. Durante o desenvolvimento do projeto final,
                        identificou-se a necessidade de uma plataforma que facilitasse o acesso a museus,
                        monumentos e eventos culturais em Portugal.
                    </p>
                </div>
            </div>
            <img src="<?= Url::to('@web/images/locais/torre-belem.jpg') ?>"
                 alt="Torre de Belém"
                 class="about-image">
        </div>
    </div>
</div>

<!-- Valores Section -->
<div id="nossa-historia" class="valores-section">
    <div class="valores-container">
        <div class="valor-card">
            <div class="valor-icon">
                <img src="<?= Url::to('@web/images/icons/visao.png') ?>" alt="Visão">
            </div>
            <h3 class="valor-title">Visão</h3>
            <p class="valor-description">
                Ser a principal referência digital de museus e monumentos portugueses.
            </p>
        </div>

        <div class="valor-card">
            <div class="valor-icon">
                <img src="<?= Url::to('@web/images/icons/valores.png') ?>" alt="Valores">
            </div>
            <h3 class="valor-title">Valores</h3>
            <p class="valor-description">
                Preservação, educação, inovação e acessibilidade cultural.
            </p>
        </div>

        <div class="valor-card">
            <div class="valor-icon">
                <img src="<?= Url::to('@web/images/icons/missao.png') ?>" alt="Missão">
            </div>
            <h3 class="valor-title">Missão</h3>
            <p class="valor-description">
                Tornar o património acessível a todos, promovendo a cultura e o turismo educativo.
            </p>
        </div>
    </div>
</div>
