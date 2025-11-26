<?php

use common\models\Evento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\EventoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $tiposLocal */
/** @var int $totalEventos */

$this->title = 'Eventos';

$this->registerCssFile('@web/css/evento/index.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<?php Pjax::begin([
        'id' => 'evento-pjax',
        'enablePushState' => true,
        'timeout' => 5000,
]); ?>

<div class="eventos-section">
    <div class="loading-overlay" style="display: none;">
        <div class="spinner"></div>
    </div>

    <div class="eventos-container">
        <aside class="eventos-sidebar">
            <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => [
                            'data-pjax' => '',
                            'id' => 'filter-form',
                            'class' => 'filter-form',
                    ],
            ]); ?>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Pesquisar</h3>
                <div class="search-box">
                    <?= $form->field($searchModel, 'titulo', [
                            'template' => '{input}',
                    ])->textInput([
                            'placeholder' => 'Pesquisar eventos...',
                            'class' => 'search-input',
                            'id' => 'search-input',
                    ]) ?>
                </div>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Categorias</h3>
                <div class="category-list">
                    <a href="<?= Url::to(['index']) ?>" class="category-item <?= empty(Yii::$app->request->get('tipo')) ? 'active' : '' ?>">
                        <span>Todos</span>
                        <span class="category-badge"><?= $totalEventos ?></span>
                    </a>

                    <?php foreach ($tiposLocal as $tipo): ?>
                        <?php if ($tipo['total'] > 0): ?>
                            <a href="<?= Url::to(['index', 'tipo' => $tipo['id']]) ?>"
                               class="category-item <?= Yii::$app->request->get('tipo') == $tipo['id'] ? 'active' : '' ?>">
                                <span><?= Html::encode($tipo['nome']) ?></span>
                                <span class="category-badge"><?= $tipo['total'] ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </aside>

        <div class="eventos-content">
            <div class="results-count">
                <strong><?= $dataProvider->totalCount ?></strong> eventos encontrados
            </div>

            <?php if (empty($dataProvider->models)): ?>
                <div class="no-results">
                    <p>Nenhum evento encontrado.</p>
                </div>
            <?php else: ?>
                <?php foreach ($dataProvider->models as $evento): ?>
                    <a href="<?= Url::to(['view', 'id' => $evento->id]) ?>" class="evento-list-card">
                        <div class="evento-list-image" style="background-image: url('<?= Yii::getAlias('@uploadsUrl') . '/' . Html::encode($evento->imagem) ?>');">
                            <span class="evento-list-category">
                                <?= Html::encode($evento->local && $evento->local->tipo ? $evento->local->tipo->nome : 'Eventos') ?>
                            </span>
                        </div>

                        <div class="evento-list-content">
                            <h3 class="evento-list-title">
                                <?= Html::encode($evento->titulo) ?>
                            </h3>

                            <p class="evento-list-description">
                                <?= Html::encode($evento->descricao) ?>
                            </p>

                            <div class="evento-list-meta">
                                <span class="meta-item">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    <?= Yii::$app->formatter->asDate($evento->data_inicio, 'dd MMM yyyy') ?>
                                </span>

                                <span class="meta-item">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94z"/>
                                    </svg>
                                    <?= Html::encode($evento->local && $evento->local->distrito ? $evento->local->distrito->nome : 'Portugal') ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

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

<?php Pjax::end(); ?>

<?php
$this->registerJs("
var searchTimeout;

$('#search-input').on('keyup', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        $('#filter-form').submit();
    }, 500);
});

$(document).on('pjax:send', function() {
    $('.loading-overlay').fadeIn(200);
});

$(document).on('pjax:complete', function() {
    $('.loading-overlay').fadeOut(200);
});
");
?>
