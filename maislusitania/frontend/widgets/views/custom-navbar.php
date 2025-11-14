<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<nav class="custom-navbar">
    <div class="navbar-container">
        <!-- Logo/Brand -->
        <?= Html::a(
                Html::img($logoUrl, ['alt' => 'Logo']),
                ['/site/index'],
                ['class' => 'navbar-brand']
        ) ?>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" id="mobile-toggle-btn">☰</button>

        <!-- Menu Items -->
        <ul class="navbar-menu" id="navbar-menu">
            <?php foreach ($menuItems as $item): ?>
                <li>
                    <?= Html::a($item['label'], $item['url']) ?>
                </li>
            <?php endforeach; ?>

            <!-- Auth buttons in mobile menu -->
            <?php if ($showAuthButtons): ?>
                <li class="mobile-auth">
                    <?php if ($isGuest): ?>
                        <?= Html::a($signupLabel, ['/site/signup'], ['class' => 'btn-signup']) ?>
                        <?= Html::a($loginLabel, ['/site/login'], ['class' => 'btn-login']) ?>
                    <?php else: ?>
                        <!-- User info in hamburger menu -->
                        <div class="mobile-user-section">
                            <div class="mobile-user-header">
                                <div class="mobile-user-avatar"><?= $userInitial ?></div>
                                <div class="mobile-user-name"><?= Html::encode($username) ?></div>
                            </div>
                            <a href="<?= Url::to(['/site/profile']) ?>" class="mobile-menu-link">Perfil</a>
                            <a href="<?= Url::to(['/site/favorites']) ?>" class="mobile-menu-link">Favoritos</a>
                            <a href="<?= Url::to(['/site/settings']) ?>" class="mobile-menu-link">Configurações</a>
                            <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'margin: 0']) ?>
                            <button type="submit" class="mobile-menu-link logout">Logout</button>
                            <?= Html::endForm() ?>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

        </ul>

        <!-- Auth Buttons / User Info (Desktop) -->
        <?php if ($showAuthButtons): ?>
            <div class="navbar-auth">
                <?php if ($isGuest): ?>
                    <?= Html::a($signupLabel, ['/site/signup'], ['class' => 'btn-signup']) ?>
                    <?= Html::a($loginLabel, ['/site/login'], ['class' => 'btn-login']) ?>
                <?php else: ?>
                    <div class="user-info" id="user-dropdown-toggle" onclick="toggleUserDropdown(event)">
                        <div class="user-avatar" title="<?= Html::encode($username) ?>">
                            <?= strtoupper(substr($username, 0, 1)) ?>
                        </div>

                        <!-- Dropdown Menu (unchanged) -->
                        <div class="user-dropdown" id="user-dropdown-menu" onclick="event.stopPropagation()">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-avatar">
                                    <?= strtoupper(substr($username, 0, 1)) ?>
                                </div>
                                <div class="user-dropdown-info">
                                    <strong><?= Html::encode($username) ?></strong>
                                    <small>Utilizador</small>
                                </div>
                            </div>
                            
                            <div class="user-dropdown-divider"></div>
                            
                            <ul class="user-dropdown-menu">
                                <li>
                                    <a href="<?= Url::to(['/site/settings']) ?>" class="user-dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/><path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319z"/></svg>
                                        Configurações
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/profile']) ?>" class="user-dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                                        Perfil
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/favorites']) ?>" class="user-dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                                        Favoritos
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="user-dropdown-divider"></div>
                            
                            <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'margin: 0']) ?>
                                <button type="submit" class="user-dropdown-item logout-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>
                                    Logout
                                </button>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-toggle-btn');
        const menu = document.getElementById('navbar-menu');

        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('active');
                toggleBtn.textContent = menu.classList.contains('active') ? '✕' : '☰';
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    menu.classList.remove('active');
                    toggleBtn.textContent = '☰';
                }
            });

            // Close menu when clicking a link
            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function() {
                    menu.classList.remove('active');
                    toggleBtn.textContent = '☰';
                });
            });
        }
    });

    // User dropdown toggle
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('user-dropdown-menu');
        dropdown.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('user-dropdown-menu');
        const toggle = document.getElementById('user-dropdown-toggle');

        if (dropdown && toggle && !toggle.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>
