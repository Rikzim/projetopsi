<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Models\TipoBilhete $model */

$this->title = 'Create Tipo Bilhete';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Bilhetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-bilhete-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'localCultural' => $localCultural,
    ]) ?>

</div>
