<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/images/logo/Logo-white.svg" alt="maislusitania Logo" style="opacity: .8">
        <span class="brand-text font-weight-light">+Lusitânia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'tachometer-alt', 'url' => ['site/index']],
                    [
                        'label' => 'Gestão de Conteúdo',
                        'icon' => 'folder',
                        'items' => [
                            ['label' => 'Locais Culturais', 'icon' => 'user', 'iconStyle' => 'far'],
                            ['label' => 'Eventos', 'icon' => 'user', 'iconStyle' => 'far'],
                            ['label' => 'Notícias', 'icon' => 'user', 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Reservas e Bilhetes',
                        'icon' => 'ticket-alt',
                        'items' => [
                            ['label' => 'Reservas', 'icon' => 'user', 'iconStyle' => 'far'],
                            ['label' => 'Tipos de Bilhetes', 'icon' => 'user', 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Utilizadores',
                        'icon' => 'users',
                        'items' => [
                            ['label' => 'Utilizadores', 'icon' => 'user', 'iconStyle' => 'far'],
                            ['label' => 'Avaliações', 'icon' => 'user', 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'MEU PERFIL', 'header' => true],
                    ['label' => 'Gerir Perfil', 'icon' => 'user', 'iconStyle' => 'far', 'url' => ['site/profile']],
                    ['label' => 'Sair', 'icon' => 'sign-out-alt', 'url' => ['site/logout'], 'template' => '<a class="nav-link" href="{url}" data-method="post">{icon} {label}</a>'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>