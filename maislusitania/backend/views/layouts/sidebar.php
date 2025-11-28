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

$hasImage = $profile && !empty($profile->imagem_perfil);
$image = $hasImage ? Yii::getAlias('@web') . '/uploads/' . $profile->imagem_perfil : null;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/images/logo/logo-white.svg" alt="maislusitania Logo" style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size: 1.5rem;">+Lusitânia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if ($hasImage): ?>
                    <img src="<?= Html::encode($image) ?>" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; height: 2.1rem; object-fit: cover;">
                <?php else: ?>
                    <div class="img-circle elevation-2" style="width: 2.1rem; height: 2.1rem; border-radius: 50%; background-color: #2E5AAC; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                        <?= strtoupper(substr($name, 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="info">
                <a href="<?= \yii\helpers\Url::to(['user/update', 'id' => $identity->id]) ?>" class="d-block"><?= Html::encode($name) ?></a>
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
                            ['label' => 'Tipos de Locais', 'icon' => 'tags', 'iconStyle' => 'fas', 'url' => ['tipo-local/index']],
                            ['label' => 'Eventos', 'icon' => 'calendar-alt', 'iconStyle' => 'fas', 'url' => ['evento/index']],
                            ['label' => 'Notícias', 'icon' => 'newspaper', 'iconStyle' => 'far', 'url' => ['noticia/index']],
                        ]
                    ],
                    [
                        'label' => 'Reservas',
                        'icon' => 'ticket-alt',
                        'items' => [
                            ['label' => 'Reservas', 'icon' => 'calendar-check', 'iconStyle' => 'far', 'url' => ['reserva/index']],
                        ]
                    ],
                    [
                        'label' => 'Utilizadores',
                        'icon' => 'users',
                        'items' => array_filter([
                            Yii::$app->user->can('viewUser') ? ['label' => 'Utilizadores', 'icon' => 'user', 'iconStyle' => 'far', 'url' => ['user/index']] : null,
                            ['label' => 'Avaliações', 'icon' => 'star', 'iconStyle' => 'far', 'url' => ['avaliacao/index']],
                        ])
                    ],
                    ['label' => 'MEU PERFIL', 'header' => true],
                    ['label' => 'Gerir Perfil', 'icon' => 'user-cog', 'iconStyle' => 'fas', 'url' => ['user/update', 'id' => $identity->id]],
                    ['label' => 'Sair', 'icon' => 'sign-out-alt', 'url' => ['site/logout'], 'template' => '<a class="nav-link" href="{url}" data-method="post">{icon} {label}</a>'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>