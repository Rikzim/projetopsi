<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerCss("
.hero-btn {
    background: white;
    color: #2E5AAC;
    padding: 15px 50px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    font-weight: 700;
    font-size: 1.2rem;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.hero-btn:hover {
    background: #f0f0f0;
    color: #2E5AAC;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

.hero-section-widget {
    min-height: 100vh !important;
    height: 100vh !important;
}
");

// Build background style based on showOverlay
$backgroundStyle = $showOverlay
        ? "background: linear-gradient(rgba(46, 90, 172, 0.7), rgba(46, 90, 172, 0.7)), url('{$backgroundImage}');"
        : "background: url('{$backgroundImage}');";
?>

<div class="hero-section-widget position-relative text-white text-center d-flex align-items-center justify-content-center" style="
<?= $backgroundStyle ?>
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0;
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
                    <a class="hero-btn" href="<?= Url::to($button['url']) ?>">
                        <?= Html::encode($button['text']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
