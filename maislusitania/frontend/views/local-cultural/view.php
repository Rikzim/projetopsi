<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\LocalCulturalHeaderWidget;
use frontend\widgets\HorarioFuncionamentoWidget;
use frontend\widgets\InformacoesUteisWidget;
use frontend\widgets\BilhetesWidget;
use frontend\widgets\EventosRelacionadosWidget;
use frontend\widgets\NoticiasRelacionadasWidget;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */

\yii\web\YiiAsset::register($this);
?>

<style>
    .local-cultural-view {
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .hero-image-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    .hero-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        display: block;
        border-radius: 0 0 20px 20px;
    }

    .content-wrapper {
        margin-top: -80px;
        position: relative;
        z-index: 10;
    }

    .info-cards-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        max-width: 900px;
        margin: 0 auto 30px;
    }

    @media (max-width: 768px) {
        .hero-image {
            height: 250px;
        }

        .content-wrapper {
            margin-top: -50px;
        }

        .info-cards-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="local-cultural-view">
    
    <div class="hero-image-container">
        <img src="<?= Url::to('@web/images/locais/arte-antiga.jpg') ?>" 
             class="hero-image" 
             alt="<?= Html::encode($model->nome) ?>">
    </div>

    <div class="content-wrapper">
        
        <?= LocalCulturalHeaderWidget::widget([
            'model' => $model,
            'showBadge' => true,
            'showRating' => true,
        ]) ?>

        <div class="info-cards-container">
            
            <?= HorarioFuncionamentoWidget::widget([
                'model' => $model,
            ]) ?>

            <?= InformacoesUteisWidget::widget([
                'model' => $model,
                'showPreco' => true,
                'precoText' => 'Consultar Bilhetes',
            ]) ?>

        </div>

        <?= BilhetesWidget::widget([
            'model' => $model,
        ]) ?>

        <?= EventosRelacionadosWidget::widget([
            'localCulturalId' => $model->id,
            'limit' => 3,
        ]) ?>

        <?= NoticiasRelacionadasWidget::widget([
            'localCulturalId' => $model->id,
            'limit' => 3,
        ]) ?>

    </div>

</div>