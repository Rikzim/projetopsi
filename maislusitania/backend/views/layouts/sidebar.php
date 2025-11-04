<?php
use yii\helpers\Html;

$identity = Yii::$app->user->identity;
$profile = $identity ? $identity->userProfile : null;

$name = 'Guest';
if ($profile) {
    $name = trim(($profile->primeiro_nome ?? '') . ' ' . ($profile->ultimo_nome ?? ''));
    if (empty($name) && $identity) {
        $name = $identity->username ?? 'User';
    }
} elseif ($identity) {
    $name = $identity->username ?? 'User';
}

$image = Yii::getAlias('@web') . '/img/user2-160x160.jpg'; // default
if ($profile && !empty($profile->imagem_perfil)) {
    $image = Yii::getAlias('@web') . '/' . ltrim($profile->imagem_perfil, '/');
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/images/logo/Logo-white.svg" alt="maislusitania Logo" style="opacity: .8">
        <span class="brand-text font-weight-light">+Lusitânia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= Html::encode($image) ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="site/profile" class="d-block"><?= Html::encode($name) ?></a>
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
                                            ['label' => 'Locais Culturais', 'icon' => 'landmark', 'iconStyle' => 'fas', 'url' => ['local-cultural/index']],
                                            ['label' => 'Eventos', 'icon' => 'calendar-alt', 'iconStyle' => 'fas', 'url' => ['evento/index']],
                                            ['label' => 'Notícias', 'icon' => 'newspaper', 'iconStyle' => 'far', 'url' => ['noticia/index']],
                                    ]
                            ],
                            [
                                    'label' => 'Reservas e Bilhetes',
                                    'icon' => 'ticket-alt',
                                    'items' => [
                                            ['label' => 'Reservas', 'icon' => 'calendar-check', 'iconStyle' => 'far', 'url' => ['reserva/index']],
                                            ['label' => 'Tipos de Bilhetes', 'icon' => 'tags', 'iconStyle' => 'fas', 'url' => ['tipo-bilhete/index']],
                                    ]
                            ],
                            [
                                    'label' => 'Utilizadores',
                                    'icon' => 'users',
                                    'items' => [
                                            ['label' => 'Utilizadores', 'icon' => 'user', 'iconStyle' => 'far', 'url' => ['user/index']],
                                            ['label' => 'Avaliações', 'icon' => 'star', 'iconStyle' => 'far', 'url' => ['avaliacao/index']],
                                    ]
                            ],
                            ['label' => 'MEU PERFIL', 'header' => true],
                            ['label' => 'Gerir Perfil', 'icon' => 'user-cog', 'iconStyle' => 'fas', 'url' => ['site/profile']],
                            ['label' => 'Sair', 'icon' => 'sign-out-alt', 'url' => ['site/logout'], 'template' => '<a class="nav-link" href="{url}" data-method="post">{icon} {label}</a>'],
                    ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
