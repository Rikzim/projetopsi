<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Models\TipoBilhete $model */

$this->params['breadcrumbs'][] = ['label' => 'Tipo Bilhetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-bilhete-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'localCultural' => $localCultural,
    ]) ?>

</div>
