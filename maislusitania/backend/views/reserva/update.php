<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var array $utilizadores */
/** @var array $locais */

$this->title = 'Update Reserva: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reserva-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'utilizadores' => $utilizadores,
        'locais' => $locais,
    ]) ?>

</div>
