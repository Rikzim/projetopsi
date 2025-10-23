<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<footer class="custom-footer">
    <div class="footer-container">
        <div class="footer-content">
            <!-- Coluna da Marca/Logo -->
            <div class="footer-brand">
                <?= Html::img($logoUrl, ['alt' => $logoText]) ?>
                <p>
                    Descubra o património cultural de Portugal. 
                    Explore museus, monumentos e eventos históricos 
                    que contam a nossa história.
                </p>
                <div class="footer-social">
                    <?php foreach ($socialLinks as $social): ?>
                        <?= Html::a(
                            $this->render('_social-icon', ['icon' => $social['icon']]),
                            $social['url'],
                            ['target' => '_blank', 'rel' => 'noopener noreferrer']
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Coluna 1 -->
            <div class="footer-column">
                <h4><?= Html::encode($column1Links['title']) ?></h4>
                <ul>
                    <?php foreach ($column1Links['links'] as $link): ?>
                        <li><?= Html::a($link['label'], $link['url']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Coluna 2 -->
            <div class="footer-column">
                <h4><?= Html::encode($column2Links['title']) ?></h4>
                <ul>
                    <?php foreach ($column2Links['links'] as $link): ?>
                        <li><?= Html::a($link['label'], $link['url']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Coluna 3 -->
            <div class="footer-column">
                <h4><?= Html::encode($column3Links['title']) ?></h4>
                <ul>
                    <?php foreach ($column3Links['links'] as $link): ?>
                        <li><?= Html::a($link['label'], $link['url']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-copyright">
                &copy; <?= date('Y') ?> <?= Html::encode($logoText) ?>. Todos os direitos reservados.
            </div>
        </div>
    </div>
</footer>