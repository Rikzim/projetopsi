<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\BilhetesWidget;
use frontend\widgets\EventosRelacionadosWidget;
use frontend\widgets\NoticiasRelacionadasWidget;
use frontend\widgets\HeroSection;
use frontend\widgets\AvaliacoesWidget;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */

$this->registerCssFile('@web/css/local-cultural/view.css', ['depends' => [\yii\web\JqueryAsset::class]]);

\yii\web\YiiAsset::register($this);
?>


<div class="local-cultural-view">
    

    <div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => Url::to($model->getImage()),
            'title' => $model->nome,
            'showOverlay' => false,
    ]) ?>

    <div class="content-wrapper">
        <div class="lc-header-card">
            
            <?php if ($model->tipoLocal): ?>
                <span class="lc-type-badge">
                    <?= Html::encode($model->tipoLocal->nome ?? 'Local Cultural') ?>
                </span>
            <?php endif; ?>
         
            
            <div class="lc-location-info">
                <svg class="lc-location-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
                <span>
                    <?= Html::encode($model->distrito ? $model->distrito->nome : 'Portugal') ?>, Portugal
                </span>
            </div>

            <div class="lc-rating-container">
                <div class="lc-stars">
                    <?php
                    $fullStars = floor($averageRating);
                    $hasHalfStar = ($averageRating - $fullStars) >= 0.5;

                    // Estrelas cheias
                    for ($i = 0; $i < $fullStars; $i++) {
                        echo '★';
                    }

                    // Meia estrela
                    if ($hasHalfStar) {
                        echo '☆';
                    }

                    // Estrelas vazias
                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '<span class="lc-stars-empty">☆</span>';
                    }
                    ?>
                </div>
                <span class="lc-rating-text">
                <?php if ($ratingCount > 0): ?>
                    <?= number_format($averageRating, 1) ?> (<?= number_format($ratingCount) ?> Avaliações)
                <?php else: ?>
                    Sem avaliações
                <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Seção de Descrição -->
        <div class="description-section">
            <div class="description-card">
                <div class="description-card-title">
                    <span class="description-card-icon">
                        <img src="<?= Url::to('@web/images/icons/icon-local.svg') ?>" alt="Descrição">
                    </span>
                    Descrição do Local
                </div>
                <div class="description-content">
                    <p>
                        <?= nl2br(Html::encode($model->descricao)) ?>
                    </p>
                </div>
            </div>
        </div>
    
        <div class="info-cards-container">
            
            <!-- Horário de Funcionamento Card -->
            <div class="info-card">
                <div class="info-card-title">
                    <span class="info-card-icon">
                        <img src="<?= Url::to('@web/images/icons/icon-horario.svg') ?>" alt="Horário">
                    </span>
                    Horário de Funcionamento
                </div>
                <div class="info-card-content">
                        <ul class="info-list horario-list">
                            <?php if($model->horario): ?>
                                <li><span>Segunda-feira</span> <span><?= Html::encode($model->horario->segunda ?: 'Fechado') ?></span></li>
                                <li><span>Terça-feira</span> <span><?= Html::encode($model->horario->terca ?: 'Fechado') ?></span></li>
                                <li><span>Quarta-feira</span> <span><?= Html::encode($model->horario->quarta ?: 'Fechado') ?></span></li>
                                <li><span>Quinta-feira</span> <span><?= Html::encode($model->horario->quinta ?: 'Fechado') ?></span></li>
                                <li><span>Sexta-feira</span> <span><?= Html::encode($model->horario->sexta ?: 'Fechado') ?></span></li>
                                <li><span>Sábado</span> <span><?= Html::encode($model->horario->sabado ?: 'Fechado') ?></span></li>
                                <li><span>Domingo</span> <span><?= Html::encode($model->horario->domingo ?: 'Fechado') ?></span></li>
                            <?php else: ?>
                                <div class="no-info">
                                    <img src="<?= Url::to('@web/images/icons/blue/icon-horario36.svg') ?>" alt="Nenhum horário disponível" class="no-info-icon">
                                    <p class="no-info-text">Nenhum horário disponível no momento.</p>
                                </div>
                            <?php endif; ?>
                        </ul>
                </div>
            </div>
            <!-- Informações Uteis Card -->
            <div class="info-card">
                <div class="info-card-title">
                    <span class="info-card-icon">
                        <img src="<?= Url::to('@web/images/icons/icon-info.svg') ?>" alt="Informações">
                    </span>
                    Informações Úteis
                </div>
                <div class="info-card-content">
                    <ul class="info-list uteis-list">
                        <?php if (!empty($model->morada)): ?>
                            <li>
                                <strong>Morada</strong>
                                <span><?= Html::encode($model->morada) ?></span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <strong>Preço de Ingresso</strong>
                            <span>Consultar Bilhetes</span>
                        </li>
                        <?php if (!empty($model->contacto_telefone)): ?>
                            <li>
                                <strong>Telefone</strong>
                                <span><?= Html::encode($model->contacto_telefone) ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($model->contacto_email)): ?>
                            <li>
                                <strong>Email</strong>
                                <span><?= Html::encode($model->contacto_email) ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($model->website)): ?>
                             <li>
                                <strong>Website</strong>
                                <span><?= Html::a($model->website, $model->website, ['target' => '_blank']) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    
        <?= BilhetesWidget::widget([
            'model' => $model,
            'bilhetes' => $bilhetes,
            'showComprar' => true,
            'maxQuantidade' => 10,
        ]) ?>

        <?= EventosRelacionadosWidget::widget([
            'localCulturalId' => $model->id,
            'eventos' => $model->eventos,
            'limit' => 3,
        ]) ?>

        
        <?= NoticiasRelacionadasWidget::widget([
            'localCulturalId' => $model->id,
            'noticias' => $model->noticias,
            'limit' => 3,
        ]) ?>

        <div class="avaliacoes-container">
            <?php Pjax::begin(['id' => 'avaliacoes-pjax', 'enablePushState' => false]); ?>
                <?= AvaliacoesWidget::widget([
                    'localCulturalId' => $model->id,
                ]) ?>
            <?php Pjax::end(); ?>
        </div>

    </div>

</div>