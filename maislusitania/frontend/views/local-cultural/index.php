<?php
// filepath: c:\wamp64\www\PlatSI\ProjetoPSI\ProjetoPSI\maislusitania\frontend\views\local-cultural\index.php

use common\models\LocalCultural;
use common\models\TipoLocal;
use common\models\Distrito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Explore o Património de Portugal';

$this->registerCssFile('@web/css/local-cultural/index.css', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerCss("
.hero-section {
    background: linear-gradient(rgba(46, 90, 172, 0.75), rgba(46, 90, 172, 0.75)), url('" . Url::to('@web/images/components/locals-foreground.jpg') . "');
}
");
?>


<!-- Hero Section - 100% Width -->
<div class="hero-section">
    <div style="max-width: 900px; width: 90%;">
        <h1>Explore o Património de Portugal</h1>
        <p>Descubra monumentos, museus e locais históricos por todo o país</p>
    </div>
</div>

<!-- Search Container - Metade sobrepõe o hero -->
<div class="search-wrapper">
    <div class="search-container">
        <div class="search-box">
            <?= Html::textInput('search', Yii::$app->request->get('search'), [
                'placeholder' => 'Pesquisa por local, cidade ou monumento.....',
                'id' => 'search-input'
            ]) ?>
            <button onclick="searchLocais()">Pesquisar</button>
        </div>
        
        <div class="filter-buttons">
            <!-- Dropdown Categorias -->
            <div class="custom-dropdown" id="dropdown-categorias">
                <button class="dropdown-btn" onclick="toggleDropdown('dropdown-categorias')">
                    <span id="selected-categoria">Todas as Categorias</span>
                    <span class="arrow">▾</span>
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-item <?= !Yii::$app->request->get('tipo') ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index']) ?>">Todas as Categorias</a>
                    </div>
                    <?php foreach ($tiposLocal as $id => $nome): ?>
                    <div class="dropdown-item <?= Yii::$app->request->get('tipo') == $id ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index', 'tipo' => $id]) ?>"><?= Html::encode($nome) ?></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Dropdown Regiões -->
            <div class="custom-dropdown" id="dropdown-regioes">
                <button class="dropdown-btn" onclick="toggleDropdown('dropdown-regioes')">
                    <span id="selected-regiao">Todas as Regiões</span>
                    <span class="arrow">▾</span>
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-item <?= !Yii::$app->request->get('distrito') ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index']) ?>">Todas as Regiões</a>
                    </div>
                    <?php foreach ($distritos as $id => $nome): ?>
                    <div class="dropdown-item <?= Yii::$app->request->get('distrito') == $id ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index', 'distrito' => $id]) ?>"><?= Html::encode($nome) ?></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Dropdown Ordenar -->
            <div class="custom-dropdown" id="dropdown-ordenar">
                <button class="dropdown-btn" onclick="toggleDropdown('dropdown-ordenar')">
                    <span id="selected-ordem">Ordenar Por</span>
                    <span class="arrow">▾</span>
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-item <?= !Yii::$app->request->get('order') ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index']) ?>">Relevância</a>
                    </div>
                    <div class="dropdown-item <?= Yii::$app->request->get('order') == 'nome' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index', 'order' => 'nome']) ?>">Nome A-Z</a>
                    </div>
                    <div class="dropdown-item <?= Yii::$app->request->get('order') == 'nome-desc' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index', 'order' => 'nome-desc']) ?>">Nome Z-A</a>
                    </div>
                    <div class="dropdown-item <?= Yii::$app->request->get('order') == 'rating' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['index', 'order' => 'rating']) ?>">Melhor Avaliação</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="content-section">
    <!-- Results Count -->
    <div class="results-count">
        <strong><?= $dataProvider->totalCount ?></strong> locais encontrados
    </div>

    <!-- Locais Grid -->
    <div class="locais-grid">
        <?php foreach ($dataProvider->models as $local): ?>
        <div class="local-card">
            
            <img src="<?= 'https://picsum.photos/140/140?random=' . $local->id ?>" alt="<?= Html::encode($local->nome) ?>" class="local-image">
            
            <div class="local-content">
                <h3 class="local-title"><?= Html::encode($local->nome) ?></h3>
                
                <div class="local-location">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a5.5 5.5 0 0 0-5.5 5.5c0 3.5 5.5 10.5 5.5 10.5s5.5-7 5.5-10.5A5.5 5.5 0 0 0 8 0zm0 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                    </svg>
                    <?= Html::encode($local->distrito->nome ?? 'Portugal') ?>
                </div>
                
                <p class="local-description">
                    <?= Html::encode(mb_substr($local->descricao, 0, 255)) ?>...
                </p>
                
                <div class="local-footer">
                    <div class="local-rating">
                        ★★★★★ 4.5
                    </div>
                    <a href="<?= Url::to(['view', 'id' => $local->id]) ?>" class="view-details">
                        Ver Detalhes →
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

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

<script>
// Toggle dropdown
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('.custom-dropdown');
    
    // Fechar outros dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) d.classList.remove('active');
    });
    
    dropdown.classList.toggle('active');
}

// Fechar dropdown ao clicar fora
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-dropdown')) {
        document.querySelectorAll('.custom-dropdown').forEach(d => {
            d.classList.remove('active');
        });
    }
});

// Prevenir fechar ao clicar no botão
document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

// Pesquisar
function searchLocais() {
    const search = document.getElementById('search-input').value;
    window.location.href = '<?= Url::to(['index']) ?>?search=' + encodeURIComponent(search);
}

// Enter key para pesquisa
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.which == 13 || e.keyCode == 13) {
        searchLocais();
    }
});
</script>