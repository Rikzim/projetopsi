<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Noticia */

\yii\web\YiiAsset::register($this);

$this->title = $model->titulo;
$this->registerCssFile('@web/css/noticia-view.css');
?>

<div class="noticia-view">

    <!-- Hero Image with Overlay Card -->
    <div class="noticia-hero" style="background-image: url('<?= $model->imagem ? Url::to('@web/images/' . $model->imagem) : Url::to('@web/images/default-news.jpg') ?>')">

        <!-- White Overlay Card -->
        <div class="noticia-overlay-card">
            <h1 class="noticia-title"><?= Html::encode($model->titulo) ?></h1>

            <div class="noticia-meta">
                <span class="meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <?= Yii::$app->formatter->asDate($model->data_publicacao, 'dd \'de\' MMM \'de\' yyyy') ?>
                </span>

                <?php if ($model->local): ?>
                    <span class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= Html::encode($model->local->nome) ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if ($model->local): ?>
                <a href="<?= Url::to(['local-cultural/view', 'id' => $model->local_id]) ?>" class="noticia-badge">
                    Monumentos
                </a>
            <?php endif; ?>

            <?php if ($model->destaque): ?>
                <span class="noticia-badge destaque">
                    <i class="fas fa-star"></i>
                    Destaque
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Content Section -->
    <div class="noticia-container">
        <div class="noticia-content-wrapper">

            <!-- Resumo -->
            <?php if ($model->resumo): ?>
                <div class="noticia-resumo">
                    <?= Html::encode($model->resumo) ?>
                </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="noticia-content">
                <?= $model->conteudo ?>
            </div>

        </div>
    </div>

</div>
