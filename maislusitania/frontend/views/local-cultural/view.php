<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\LocalCulturalHeaderWidget;
use frontend\widgets\HorarioFuncionamentoWidget;
use frontend\widgets\InformacoesUteisWidget;
use frontend\widgets\BilhetesWidget;
use frontend\widgets\EventosRelacionadosWidget;
use frontend\widgets\NoticiasRelacionadasWidget;
use frontend\widgets\HeroSection;
use frontend\widgets\AvaliacoesWidget;


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
            'subtitle' => $model->descricao,
            'showOverlay' => false,
    ]) ?>

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
            'showComprar' => true,
            'maxQuantidade' => 10,
        ]) ?>

        <?= EventosRelacionadosWidget::widget([
            'localCulturalId' => $model->id,
            'limit' => 3,
        ]) ?>

        <?= NoticiasRelacionadasWidget::widget([
            'localCulturalId' => $model->id,
            'limit' => 3,
        ]) ?>

        <?= AvaliacoesWidget::widget([
                'localCulturalId' => $model->id,
        ]) ?>

    </div>

</div>