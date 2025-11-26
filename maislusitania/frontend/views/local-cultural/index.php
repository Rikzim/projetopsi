<?php

use common\models\LocalCultural;
use common\models\TipoLocal;
use common\models\Distrito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\LocalCulturalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $tiposLocal */
/** @var array $distritos */

$this->title = 'Explore o Património de Portugal';

$this->registerCssFile('@web/css/local-cultural/index.css', ['depends' => [\yii\web\YiiAsset::class]]);

$this->registerCss("
.hero-section {
    background: linear-gradient(rgba(46, 90, 172, 0.75), rgba(46, 90, 172, 0.75)), url('" . Url::to('@web/images/locais/palacio-pena.jpg') . "');
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

<?php Pjax::begin([
    'id' => 'local-pjax',
    'enablePushState' => true,
    'timeout' => 5000,
]); ?>

<!-- Search Container - Metade sobrepõe o hero -->
<div class="search-wrapper">
    <div class="search-container">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => '',
                'id' => 'filter-form',
            ],
        ]); ?>
        
        <div class="search-box">
            <?= $form->field($searchModel, 'search', [
                'template' => '{input}',
            ])->textInput([
                'placeholder' => 'Pesquisa por local, cidade ou monumento.....',
                'id' => 'search-input',
                'class' => 'search-field',
            ]) ?>
            <button type="submit">Pesquisar</button>
        </div>
        
        <div class="filter-buttons">
            <!-- Dropdown Categorias (Yii2) -->
            <?= $form->field($searchModel, 'tipo', [
                'template' => '{input}',
            ])->dropDownList(
                ArrayHelper::merge(['' => 'Todas as Categorias'], $tiposLocal),
                [
                    'class' => 'filter-dropdown',
                    'id' => 'filter-tipo',
                    'onchange' => '$("#filter-form").submit()',
                ]
            ) ?>

            <!-- Dropdown Regiões (Yii2) -->
            <?= $form->field($searchModel, 'distrito', [
                'template' => '{input}',
            ])->dropDownList(
                ArrayHelper::merge(['' => 'Todas as Regiões'], $distritos),
                [
                    'class' => 'filter-dropdown',
                    'id' => 'filter-distrito',
                    'onchange' => '$("#filter-form").submit()',
                ]
            ) ?>

            <!-- Dropdown Ordenar (Yii2) -->
            <?= $form->field($searchModel, 'order', [
                'template' => '{input}',
            ])->dropDownList(
                [
                    '' => 'Relevância',
                    'nome' => 'Nome A-Z',
                    'nome-desc' => 'Nome Z-A',
                    'rating' => 'Melhor Avaliação',
                ],
                [
                    'class' => 'filter-dropdown',
                    'id' => 'filter-order',
                    'onchange' => '$("#filter-form").submit()',
                ]
            ) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Content Section -->
<div class="content-section">
    <!-- Loading Overlay -->
    <div class="loading-overlay" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Results Count -->
    <div class="results-count">
        <strong><?= $dataProvider->totalCount ?></strong> locais encontrados
    </div>

    <!-- Locais Grid -->
    <div class="locais-grid">
        <?php if (empty($dataProvider->models)): ?>
            <div class="no-results">
                <p>Nenhum local encontrado com os filtros selecionados.</p>
            </div>
        <?php else: ?>
            <?php foreach ($dataProvider->models as $local): ?>
            <div class="local-card">
                <img src="<?= Yii::getAlias('@uploadsUrl') . '/' . Html::encode($local->imagem_principal) ?>" 
                    alt="<?= Html::encode($local->nome) ?>"
                    class="local-image">
                
                <div class="local-content">
                    <h3 class="local-title"><?= Html::encode($local->nome) ?></h3>
                    
                    <div class="local-location">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0a5.5 5.5 0 0 0-5.5 5.5c0 3.5 5.5 10.5 5.5 10.5s5.5-7 5.5-10.5A5.5 5.5 0 0 0 8 0zm0 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                        </svg>
                        <?= Html::encode($local->distrito->nome ?? 'Portugal') ?>
                    </div>
                    
                    <p class="local-description">
                        <?= Html::encode(mb_substr($local->descricao ?? '', 0, 120)) ?>...
                    </p>

                    <div class="local-footer">
                        <?php
                        $avgRating = $local->getAverageRating();
                        $ratingCount = $local->getRatingCount();
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                        ?>
                        <div class="local-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $fullStars): ?>
                                    ★
                                <?php elseif ($i == $fullStars + 1 && $hasHalfStar): ?>
                                    ☆
                                <?php else: ?>
                                    ☆
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($ratingCount > 0): ?>
                                <?= number_format($avgRating, 1) ?> (<?= $ratingCount ?>)
                            <?php else: ?>
                                Sem avaliações
                            <?php endif; ?>
                        </div>
                        <a href="<?= Url::to(['view', 'id' => $local->id]) ?>" class="view-details">
                            Ver Detalhes →
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (!empty($dataProvider->models)): ?>
    <div class="pagination-container">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination'],
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
            'maxButtonCount' => 5,
        ]) ?>
    </div>
    <?php endif; ?>
</div>

<?php Pjax::end(); ?>

<?php
$this->registerJs("
var searchTimeout;

// Debounced search for text input only
$('#search-input').on('keyup', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        $('#filter-form').submit();
    }, 500);
});

// Instant submit for dropdowns
$('#filter-tipo, #filter-distrito, #filter-order').on('change', function() {
    clearTimeout(searchTimeout);
    $('#filter-form').submit();
});

// Loading overlay
$(document).on('pjax:send', function() {
    $('.loading-overlay').fadeIn(200);
});

$(document).on('pjax:complete', function() {
    $('.loading-overlay').fadeOut(200);
});
");
?>


