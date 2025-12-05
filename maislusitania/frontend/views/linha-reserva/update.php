<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaReserva $model */

$this->title = 'Update Linha Reserva: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-reserva-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
