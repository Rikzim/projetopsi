<?php

use yii\helpers\Html;

?>

<div class="avaliacao-item">
    <div class="avaliacao-header">
        <strong><?= Html::encode($model->utilizador->username ?? 'Utilizador') ?></strong>
        <div class="rating-display">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star <?= $i <= $model->classificacao ? 'filled' : '' ?>">★</span>
            <?php endfor; ?>
        </div>
        <span class="avaliacao-date"><?= Yii::$app->formatter->asDate($model->data_avaliacao) ?></span>
    </div>
    <?php if ($model->comentario): ?>
        <p class="avaliacao-comentario"><?= Html::encode($model->comentario) ?></p>
    <?php endif; ?>
</div>
