<?php

use common\models\Noticia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Notícias';

// Registrar CSS externo
$this->registerCssFile('@web/css/noticia/index.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<!-- Hero Section -->
<div class="noticias-hero">
    <div class="hero-content">
        <h1>Notícias</h1>
        <p>Fique a par das últimas novidades sobre museus, monumentos<br>e património cultural de Portugal.</p>
    </div>
</div>

<!-- Featured News Card -->
<?php if ($destaqueNoticia): ?>
<div class="featured-wrapper">
    <a href="<?= Url::to(['view', 'id' => $destaqueNoticia->id]) ?>" class="featured-card">
        <div class="featured-image" style="background-image: url('<?= $destaqueNoticia->imagem ?: 'https://picsum.photos/800/500?random=1' ?>');">
            <div class="featured-overlay">
                <span class="featured-category">
                    <?= Html::encode($destaqueNoticia->localCultural->tipoLocal->nome ?? 'Monumentos') ?>
                </span>
                
                <h2 class="featured-title">
                    <?= Html::encode($destaqueNoticia->titulo) ?>
                </h2>
                
                <p class="featured-description">
                    <?= Html::encode($destaqueNoticia->resumo) ?>
                </p>
                
                <div class="featured-meta">
                    <span class="meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <?= Yii::$app->formatter->asDate($destaqueNoticia->data_publicacao, 'dd \'Out de\' yyyy') ?>
                    </span>
                    
                    <span class="meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <?= Html::encode($destaqueNoticia->localCultural->distrito->nome ?? 'Lisboa') ?>
                    </span>
                    
                    <span class="meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                        8min
                    </span>
                </div>
            </div>
        </div>
    </a>
</div>
<?php endif; ?>

<!-- News Grid with Sidebar -->
<div class="noticias-section">
    <div class="noticias-container">
        <!-- Sidebar -->
        <aside class="noticias-sidebar">
            <!-- Pesquisar -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Pesquisar</h3>
                <div class="search-box">
                    <input type="text" placeholder="Pesquisar notícias..." class="search-input">
                </div>
            </div>
            
            <!-- Categorias -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Categorias</h3>
                <div class="category-list">
                    <a href="#" class="category-item">
                        <span>Todos</span>
                        <span class="category-badge">8</span>
                    </a>
                    <a href="#" class="category-item">
                        <span>Museus</span>
                        <span class="category-badge">3</span>
                    </a>
                    <a href="#" class="category-item active">
                        <span>Monumentos</span>
                        <span class="category-badge">5</span>
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- News List -->
        <div class="noticias-content">
            <?php 
            foreach ($dataProvider->models as $noticia): 
            ?>
            <a href="<?= Url::to(['view', 'id' => $noticia->id]) ?>" class="noticia-list-card">
                <div class="noticia-list-image" style="background-image: url('<?= $noticia->imagem ?: 'https://picsum.photos/300/200?random=' . $noticia->id ?>');">
                    <span class="noticia-list-category">
                        <?= Html::encode($noticia->localCultural->tipoLocal->nome ?? 'Monumentos') ?>
                    </span>
                </div>
                
                <div class="noticia-list-content">
                    <h3 class="noticia-list-title">
                        <?= Html::encode($noticia->titulo) ?>
                    </h3>
                    
                    <p class="noticia-list-description">
                        <?= Html::encode($noticia->resumo) ?>
                    </p>
                    
                    <div class="noticia-list-meta">
                        <span class="meta-item">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            <?= Yii::$app->formatter->asDate($noticia->data_publicacao, 'dd \'Out de\' yyyy') ?>
                        </span>
                        
                        <span class="meta-item">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94z"/>
                            </svg>
                            <?= Html::encode($noticia->localCultural->distrito->nome ?? 'Portugal') ?>
                        </span>
                        
                        <span class="meta-item">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            8min
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
            
            <!-- Pagination -->
            <div class="pagination-container">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination'],
                    'prevPageLabel' => '‹',
                    'nextPageLabel' => '›',
                    'maxButtonCount' => 5,
                ]) ?>
            </div>
        </div>
    </div>
</div>