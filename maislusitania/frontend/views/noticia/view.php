<?php

/** @var yii\web\View $this */

use frontend\widgets\HeroSection;
use common\models\Noticia;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $model->titulo;
$this->registerCssFile('@web/css/noticia/noticia-view.css');
?>

<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => $model->imagem,
            'title' => $model->titulo,
            'subtitle' => $model->resumo,
            'showOverlay' => false,
    ]) ?>


    <div class="news-content-wrapper">
        <div class="news-content-card">
            <!-- Article Header -->
            <div class="news-header">
                <div class="news-meta">
                    <span class="meta-item">
                        <i class="fa fa-calendar"></i>
                        <?= Yii::$app->formatter->asDate($model->data_publicacao, 'dd MMM \'de\' yyyy') ?>
                    </span>
                                <?php if ($model->local): ?>
                                    <span class="meta-item">
                            <i class="fa fa-map-marker"></i>
                            <?= Html::encode($model->local->nome) ?>
                        </span>
                                <?php endif; ?>
                                <span class="meta-item">
                        <i class="fa fa-clock-o"></i>
                        Publicado à 8min
                    </span>
                </div>
            </div>


            <!-- Article Content -->
            <div class="news-body">
                <?= $model->conteudo ?>
            </div>
        </div>
    </div>
</div>
