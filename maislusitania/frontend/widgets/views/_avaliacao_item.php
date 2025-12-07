<?php

use yii\helpers\Html;

/** @var common\models\Avaliacao $model */
?>
<div class="avaliacao-item">
    <div class="avaliacao-header">
        <div class="user-info">
            <?= Html::encode($model->utilizador->username) ?>
        </div>
        <div class="stars">
            <?php
            // Display solid stars for the rating and empty stars for the remainder.
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $model->classificacao ? '★' : '☆';
            }
            ?>
        </div>
        <div class="date">
            <?= Yii::$app->formatter->asDate($model->data_avaliacao, 'medium') ?>
        </div>
    </div>

    <?php if (!empty($model->comentario)): ?>
        <div class="comentario-texto">
            <p><?= nl2br(Html::encode($model->comentario)) ?></p>
        </div>
    <?php endif; ?>
</div>
