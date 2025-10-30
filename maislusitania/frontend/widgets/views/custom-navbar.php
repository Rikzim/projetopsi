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
                            <!-- ... existing dropdown content ... -->
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
