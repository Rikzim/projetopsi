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

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */

$this->registerCssFile('@web/css/localview.css', ['depends' => [\yii\web\JqueryAsset::class]]);

\yii\web\YiiAsset::register($this);
?>


<div class="local-cultural-view">
    

    <div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => $model->imagem_principal,
            'title' => $model->nome,
            'subtitle' => $model->descricao,
         
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