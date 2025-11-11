<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="hero-section-widget position-relative text-white text-center d-flex align-items-center justify-content-center" style="
    min-height: <?= $minHeight ?>;
    background: linear-gradient(rgba(46, 90, 172, 0.7), rgba(46, 90, 172, 0.7)), url('<?= $backgroundImage ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    padding: 60px 0;
    width: 100%;
    ">
    <div class="hero-section-content">
        <?php if ($title): ?>
            <h1><?= Html::encode($title) ?></h1>
        <?php endif; ?>

        <?php if ($subtitle): ?>
            <p><?= Html::encode($subtitle) ?></p>
        <?php endif; ?>

        <?php if (!empty($buttons)): ?>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?php foreach ($buttons as $button): ?>
                    <a class="btn btn-light btn-lg px-5 py-3 rounded-pill"
                       href="<?= Url::to($button['url']) ?>"
                       style="font-weight: 500; font-size: 1.1rem;">
                        <?= Html::encode($button['text']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
