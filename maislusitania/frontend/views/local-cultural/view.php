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
        padding-bottom: 40px;
    }

    .hero-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 0 0 20px 20px;
        margin-bottom: -80px;
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
            margin-bottom: -50px;
        }

        .info-cards-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="local-cultural-view">

    <img src="<?= Url::to('@web/images/locais/arte-antiga.jpg') ?>" class="hero-image" alt="<?= Html::encode($model->nome) ?>">

    <!-- Widget: Header do Local Cultural -->
    <?= LocalCulturalHeaderWidget::widget([
        'model' => $model,
        'showBadge' => true,
        'showRating' => true,
    ]) ?>

    <!-- Cards de Informação -->
    <div class="info-cards-container">
        
        <!-- Widget: Horário de Funcionamento -->
        <?= HorarioFuncionamentoWidget::widget([
            'model' => $model,
        ]) ?>

        <!-- Widget: Informações Úteis -->
        <?= InformacoesUteisWidget::widget([
            'model' => $model,
            'showPreco' => true,
            'precoText' => 'Consultar Bilhetes',
        ]) ?>

    </div>

    <!-- Widget: Bilhetes -->
    <?= BilhetesWidget::widget([
        'model' => $model,
    ]) ?>

    <!-- Widget: Eventos Relacionados -->
    <?= EventosRelacionadosWidget::widget([
        'localCulturalId' => $model->id,
        'limit' => 3,
    ]) ?>

    <!-- Widget: Notícias Relacionadas -->
    <?= NoticiasRelacionadasWidget::widget([
        'localCulturalId' => $model->id,
        'limit' => 3,
    ]) ?>

</div>