<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<nav class="custom-navbar">
    <div class="navbar-container">
        <!-- Logo e Brand -->
        <a href="<?= Url::to(['/site/index']) ?>" class="navbar-brand">
            <img src="<?= $logoUrl ?>" alt="Logo">
        </a>
        
        <!-- Menu Principal -->
        <ul class="navbar-menu">
            <?php foreach ($menuItems as $item): ?>
                <li>
                    <a href="<?= Url::to($item['url']) ?>">
                        <?= Html::encode($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <!-- Área de Autenticação -->
        <div class="navbar-auth">
            <?php if ($showAuthButtons): ?>
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Url::to(['/site/signup']) ?>" class="btn-signup">Signup</a>
                    <a href="<?= Url::to(['/site/login']) ?>" class="btn-login">Login</a>
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(Yii::$app->user->identity->username) ?>&background=2E5AAC&color=fff" 
                         alt="User" 
                         class="user-avatar"
                         onclick="window.location.href='<?= Url::to(['/site/profile']) ?>'">
                <?php endif; ?>
            <?php endif; ?>
            
            <button class="mobile-toggle">☰</button>
        </div>
    </div>
</nav>