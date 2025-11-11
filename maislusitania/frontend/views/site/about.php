<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

// Remove o container para esta página
$this->params['no-container'] = true;
?>

<style>
/* Remove padding do main apenas para a página sobre */
body.sobre-page main {
    padding: 0 !important;
}

body.sobre-page main > .container {
    padding: 0 !important;
    max-width: 100% !important;
}

.site-about {
    padding: 0 !important;
    margin: 0 !important;
}

.sobre-section {
    padding: 60px 0;
    background: white;
}

.nossa-historia {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 50px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.historia-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.nossa-historia h1 {
    font-size: 48px;
    color: #2E5AAC;
    font-weight: bold;
    margin: 0;
}

.nossa-historia img {
    width: 450px;
    height: auto;
    border-radius: 20px;
    flex-shrink: 0;
}

.historia-text p {
    font-size: 18px;
    line-height: 1.8;
    color: #333;
    margin-bottom: 20px;
    text-align: justify;
}

.historia-text p:last-child {
    margin-bottom: 0;
}

.historia-text strong {
    color: #2E5AAC;
    font-weight: 600;
}

.valores-section {
    background: #2E5AAC;
    padding: 100px 0;
    margin: 0;
}

.valores-container {
    display: flex;
    justify-content: center;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.valor-card {
    background: white;
    border-radius: 20px;
    padding: 50px 35px;
    text-align: center;
    width: 320px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.valor-icon {
    margin-bottom: 25px;
}

.valor-icon img {
    width: 80px;
    height: 80px;
}

.valor-card h3 {
    font-size: 26px;
    color: #2E5AAC;
    font-weight: bold;
    margin-bottom: 20px;
}

.valor-card p {
    font-size: 16px;
    color: #333;
    line-height: 1.6;
    margin: 0;
}

/* Remove o margin-top do footer nesta página */
.custom-footer {
    margin-top: 0 !important;
}

@media (max-width: 768px) {
    .nossa-historia {
        flex-direction: column;
    }
    
    .nossa-historia img {
        width: 100%;
        order: -1;
    }
    
    .valores-container {
        flex-direction: column;
        align-items: center;
    }
    
    .historia-text p {
        font-size: 16px;
        text-align: left;
    }
    
    .nossa-historia h1 {
        font-size: 36px;
    }
}
</style>

<?php
// Adiciona classe ao body para CSS específico
$this->registerJs("document.body.classList.add('sobre-page');", \yii\web\View::POS_READY);
?>

<div class="site-about">
    <div class="sobre-section">
        <div class="nossa-historia">
            <div class="historia-content">
                <h1>Nossa História</h1>
                <div class="historia-text">
                    <p>
                    O <strong>+Lusitânia</strong> surgiu da iniciativa de três estudantes do 
                    CTeSP de Programação de Sistemas de Informação do Politécnico de Leiria, 
                    motivados pela valorização do património cultural português. Durante o desenvolvimento do projeto final, 
                    identificou-se a necessidade de uma plataforma que facilitasse o acesso a museus, 
                    monumentos e eventos culturais em Portugal
                    </p>
                </div>
            </div>
            <img src="<?= Url::to('@web/images/markers/torre-belem.jpg') ?>" alt="Torre de Belém">
        </div>
    </div>

    <div class="valores-section">
        <div class="valores-container">
            <div class="valor-card">
                <div class="valor-icon">
                    <img src="<?= Url::to('@web/images/icons/visao.png') ?>" alt="Visão">
                </div>
                <h3>Visão</h3>
                <p>Ser a principal referência digital de museus e monumentos portugueses.</p>
            </div>
            
            <div class="valor-card">
                <div class="valor-icon">
                    <img src="<?= Url::to('@web/images/icons/valores.png') ?>" alt="Valores">
                </div>
                <h3>Valores</h3>
                <p>Preservação, educação, inovação e acessibilidade cultural.</p>
            </div>
            
            <div class="valor-card">
                <div class="valor-icon">
                    <img src="<?= Url::to('@web/images/icons/missao.png') ?>" alt="Missão">
                </div>
                <h3>Missão</h3>
                <p>Tornar o património acessível a todos, promovendo a cultura e o turismo educativo.</p>
            </div>
        </div>
    </div>
</div>