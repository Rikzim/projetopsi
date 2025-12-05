<?php

/** @var yii\web\View $this */
/** @var common\models\Favorito[] $favorites */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Meus Favoritos';
$this->registerCssFile('@web/css/site/favorites.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="favorites-page">
    <!-- Header Section -->
    <div class="favorites-header">
        <div class="header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
            </svg>
        </div>
        <h1>Meus Favoritos</h1>
        <p>Os seus locais e monumentos preferidos, guardados num só lugar</p>
        <?php if (!empty($favorites)): ?>
            <div class="favorites-count">
                <?= count($favorites) ?> <?= count($favorites) === 1 ? 'Local Favorito' : 'Locais Favoritos' ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="favorites-container">
        <?php if (empty($favorites)): ?>
            <!-- Empty State -->
            <div class="empty-favorites">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 2.748-.717 9.373A5.482 5.482 0 0 0 4.5 14.5a5.482 5.482 0 0 0 5.207-4.887A5.484 5.484 0 0 0 14.5 14.5a5.482 5.482 0 0 0 5.207-5.127L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                </div>
                <h2>Ainda sem favoritos</h2>
                <p>Explore os nossos locais culturais e adicione os que mais gostar aos seus favoritos.</p>
                <?= Html::a('Explorar Locais', ['/local-cultural/index'], ['class' => 'btn-explore']) ?>
            </div>
        <?php else: ?>
            <!-- Grid of favorite cards -->
            <div class="favorites-grid">
                <?php foreach ($favorites as $favorite): ?>
                    <div class="favorite-card">
                        <?= Html::a(Html::img($favorite->local->getImage(),
                            ['alt' => $favorite->local->nome, 'class' => 'card-image']
                        ), ['/local-cultural/view', 'id' => $favorite->local->id], ['class' => 'card-image-link']) ?>
                        
                        <div class="card-content">
                            <h3 class="card-title">
                                <?= Html::a(Html::encode($favorite->local->nome), ['/local-cultural/view', 'id' => $favorite->local->id]) ?>
                            </h3>
                            
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <?= $favorite->local->distrito ? Html::encode($favorite->local->distrito->nome) : 'Portugal' ?>
                            </p>
                            
                            <?php if ($favorite->local->descricao): ?>
                                <p class="card-description">
                                    <?= Html::encode(mb_substr($favorite->local->descricao, 0, 100)) ?>...
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-footer">
                            <?= Html::a('Ver Mais', ['/local-cultural/view', 'id' => $favorite->local->id], ['class' => 'btn-details']) ?>
                            <?= Html::a(
                                '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>',
                                ['local-cultural/toggle-favorite', 'id' => $favorite->local->id],
                                [
                                    'class' => 'btn-unfavorite',
                                    'title' => 'Remover dos Favoritos',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Deseja remover este local dos favoritos?',
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>