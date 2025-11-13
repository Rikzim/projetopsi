<?php

use frontend\widgets\HeroSection;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Evento $model */

$this->title = $model->titulo;
$this->registerCssFile('@web/css/noticia/noticia-view.css');
?>
<div class="site-index">
    <?= HeroSection::widget([
            'backgroundImage' => $model->imagem,
            'title' => $model->titulo,
            'subtitle' => $model->data_fim
                    ? Yii::$app->formatter->asDatetime($model->data_inicio, "dd MMM 'de' yyyy 'às' HH:mm") . ' - ' . Yii::$app->formatter->asDatetime($model->data_fim, "dd MMM 'de' yyyy 'às' HH:mm")
                    : Yii::$app->formatter->asDatetime($model->data_inicio, "dd MMM 'de' yyyy 'às' HH:mm"),
            'showOverlay' => false,
    ]) ?>

    <div class="news-content-wrapper">
        <div class="news-content-card">
            <div class="news-header">
                <div class="news-meta">
                    <span class="meta-item">
                        <i class="fa fa-calendar"></i>
                        <?= Yii::$app->formatter->asDatetime($model->data_inicio, "dd MMM 'de' yyyy 'às' HH:mm") ?>
                        <?php if ($model->data_fim): ?>
                            - <?= Yii::$app->formatter->asDatetime($model->data_fim, "dd MMM 'de' yyyy 'às' HH:mm") ?>
                        <?php endif; ?>
                    </span>
                    <?php if ($model->local): ?>
                        <span class="meta-item">
                            <i class="fa fa-map-marker"></i>
                            <?= Html::encode($model->local->nome) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="news-body">
                <?= $model->descricao ?>
            </div>
        </div>
    </div>
</div>
