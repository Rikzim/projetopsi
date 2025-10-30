<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaReserva $model */

$this->title = 'Create Linha Reserva';
$this->params['breadcrumbs'][] = ['label' => 'Linha Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-reserva-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
