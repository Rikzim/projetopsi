<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $title string */
/* @var $backgroundColor string */
/* @var $cards array */
$this->registerCss("
.curiosidades-section {
    background: {$backgroundColor};
    padding: 60px 20px 80px 20px;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    position: relative;
}

.curiosidades-title {
    color: white;
    font-size: 2.8rem;
    font-weight: bold;
    text-align: center;
    margin: 0 0 60px 0;
    font-family: Georgia, serif;
}

.curiosidades-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.curiosidade-card {
    background: white;
    border-radius: 25px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 3px solid #2E5AAC;
}

.curiosidade-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.curiosidade-image-wrapper {
    background: white;
    border-radius: 20px;
    padding: 0;
    margin-bottom: 25px;
    overflow: hidden;
}

.curiosidade-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
}

.curiosidade-text {
    color: #2E5AAC;
    font-size: 1.15rem;
    font-weight: 600;
    line-height: 1.5;
    margin: 0 0 25px 0;
    min-height: 70px;
    padding: 0 10px;
}

.curiosidade-btn {
    background: #2E5AAC;
    color: white;
    padding: 12px 35px;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.3s ease;
    margin-bottom: 10px;
}

.curiosidade-btn:hover {
    background: #1e3a7c;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .curiosidades-grid {
        grid-template-columns: 1fr;
    }

    .curiosidades-title {
        font-size: 2rem;
    }

    .curiosidade-image {
        height: 180px;
    }
}
");

?>

<div class="curiosidades-section">
    <h2 class="curiosidades-title"><?= Html::encode($title) ?></h2>

    <div class="curiosidades-grid">
        <?php foreach ($cards as $card):
            $image = isset($card['image']) && is_string($card['image']) ? Url::to($card['image']) : '';
            $cardTitle = isset($card['title']) && is_string($card['title']) ? $card['title'] : '';
            $buttonText = isset($card['buttonText']) && is_string($card['buttonText']) ? $card['buttonText'] : 'Ver mais';
            $url = isset($card['url']) ? Url::to($card['url']) : '#';
            ?>
            <div class="curiosidade-card">
                <div class="curiosidade-image-wrapper">
                    <img class="curiosidade-image" src="<?= Html::encode($image) ?>" alt="<?= Html::encode($cardTitle) ?>">
                </div>
                <p class="curiosidade-text"><?= Html::encode($cardTitle) ?></p>
                <a href="<?= $url ?>" class="curiosidade-btn">
                    <?= Html::encode($buttonText) ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
