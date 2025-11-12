<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\HeroSection;

// Remove o container para esta página
$this->params['no-container'] = true;

// Add class to body for page-specific CSS
$this->registerJs("document.body.classList.add('sobre-page');", \yii\web\View::POS_READY);

// Add smooth scroll for anchors
$this->registerJs("
    document.querySelectorAll('a[href^=\"#\"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
", \yii\web\View::POS_READY);
?>
<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => '@web/images/hero-background.jpg',
            'title' => 'Sobre o Projeto +Lusitânia',
            'subtitle' => 'Preservar e divulgar o património histórico e cultural de Portugal.',
            'buttons' => [
                    ['text' => 'Quem somos?', 'url' => '#site-about'],
                    ['text' => 'Nossa missão', 'url' => '#nossa-historia'],
            ]
    ]) ?>

    <!-- Nossa História Section -->
    <div class="site-about" id="site-about" style="background: white; padding: 60px 0 80px 0; margin: 0;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 50px; max-width: 1200px; margin: 0 auto; padding: 0 15px;">
            <div style="flex: 1; display: flex; flex-direction: column; gap: 30px;">
                <h1 style="font-size: 48px; color: #2E5AAC; font-weight: bold; margin: 0;">Nossa História</h1>
                <div>
                    <p style="font-size: 18px; line-height: 1.8; color: #333; margin: 0; text-align: justify;">
                        O <strong style="color: #2E5AAC; font-weight: 600;">+Lusitânia</strong> surgiu da iniciativa de três estudantes do
                        CTeSP de Programação de Sistemas de Informação do Politécnico de Leiria,
                        motivados pela valorização do património cultural português. Durante o desenvolvimento do projeto final,
                        identificou-se a necessidade de uma plataforma que facilitasse o acesso a museus,
                        monumentos e eventos culturais em Portugal.
                    </p>
                </div>
            </div>
            <img src="<?= Url::to('@web/images/markers/torre-belem.jpg') ?>" alt="Torre de Belém"
                 style="width: 450px; height: auto; border-radius: 20px; flex-shrink: 0;">
        </div>
    </div>
</div>

<!-- Valores Section -->
<div id="nossa-historia" style="background: #2E5AAC; padding: 100px 0; margin: 0; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
    <div style="display: flex; justify-content: center; gap: 40px; max-width: 1200px; margin: 0 auto; padding: 0 20px; flex-wrap: wrap;">
        <div style="background: white; border-radius: 20px; padding: 50px 35px; text-align: center; width: 320px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 25px;">
                <img src="<?= Url::to('@web/images/icons/visao.png') ?>" alt="Visão" style="width: 80px; height: 80px;">
            </div>
            <h3 style="font-size: 26px; color: #2E5AAC; font-weight: bold; margin-bottom: 20px;">Visão</h3>
            <p style="font-size: 16px; color: #333; line-height: 1.6; margin: 0;">
                Ser a principal referência digital de museus e monumentos portugueses.
            </p>
        </div>

        <div style="background: white; border-radius: 20px; padding: 50px 35px; text-align: center; width: 320px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 25px;">
                <img src="<?= Url::to('@web/images/icons/valores.png') ?>" alt="Valores" style="width: 80px; height: 80px;">
            </div>
            <h3 style="font-size: 26px; color: #2E5AAC; font-weight: bold; margin-bottom: 20px;">Valores</h3>
            <p style="font-size: 16px; color: #333; line-height: 1.6; margin: 0;">
                Preservação, educação, inovação e acessibilidade cultural.
            </p>
        </div>

        <div style="background: white; border-radius: 20px; padding: 50px 35px; text-align: center; width: 320px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 25px;">
                <img src="<?= Url::to('@web/images/icons/missao.png') ?>" alt="Missão" style="width: 80px; height: 80px;">
            </div>
            <h3 style="font-size: 26px; color: #2E5AAC; font-weight: bold; margin-bottom: 20px;">Missão</h3>
            <p style="font-size: 16px; color: #333; line-height: 1.6; margin: 0;">
                Tornar o património acessível a todos, promovendo a cultura e o turismo educativo.
            </p>
        </div>
    </div>
</div>

