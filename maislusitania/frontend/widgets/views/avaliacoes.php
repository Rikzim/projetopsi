<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Avaliacao|null $userAvaliacao */
/** @var int $localCulturalId */
/** @var bool $canAdd */
/** @var bool $canEdit */
/** @var bool $canDelete */

?>

<div class="avaliacoes-section">
    <h2>Avaliações</h2>

    <?php if (!Yii::$app->user->isGuest && $canAdd): ?>
        <div class="user-avaliacao-form">
            <h3><?= $userAvaliacao ? 'Editar a minha avaliação' : 'Adicionar avaliação' ?></h3>

            <?php $form = ActiveForm::begin([
                'action' => $userAvaliacao
                    ? Url::to(['avaliacao/update', 'id' => $userAvaliacao->id])
                    : Url::to(['avaliacao/create']),
                'method' => 'post',
                'options' => ['data-pjax' => true],
            ]); ?>

            <?= Html::hiddenInput('local_id', $localCulturalId) ?>

            <div class="rating-input">
                <label>Classificação:</label>
                <div class="star-rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" name="classificacao" value="<?= $i ?>"
                               id="star<?= $i ?>"
                            <?= $userAvaliacao && $userAvaliacao->classificacao == $i ? 'checked' : '' ?> required>
                        <label for="star<?= $i ?>">★</label>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::label('Comentário', 'comentario') ?>
                <?= Html::textarea('comentario', $userAvaliacao ? $userAvaliacao->comentario : '', [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Partilhe a sua experiência...'
                ]) ?>
            </div>

            <div class="form-actions">
                <?php if ($userAvaliacao && $canEdit): ?>
                    <?= Html::submitButton('Atualizar', ['class' => 'btn btn-primary']) ?>
                <?php elseif (!$userAvaliacao): ?>
                    <?= Html::submitButton('Publicar', ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>

                <?php if ($userAvaliacao && $canDelete): ?>
                    <?= Html::a('Eliminar', ['avaliacao/delete', 'id' => $userAvaliacao->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Tem a certeza que deseja eliminar a sua avaliação?',
                            'method' => 'post',
                            'pjax' => '1', // Esta linha instrui o Yii a tratar este link via Pjax
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>

    <div class="avaliacoes-list">
        <h3>Todas as Avaliações</h3>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_avaliacao_item',
            'layout' => "{items}\n{pager}",
            'emptyText' => '<p class="text-muted">Ainda não existem avaliações. Seja o primeiro a avaliar!</p>',
            'pager' => [
                'class' => 'yii\bootstrap5\LinkPager',
                'maxButtonCount' => 5,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]); ?>
    </div>
</div>
