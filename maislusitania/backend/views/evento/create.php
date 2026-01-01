<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->title = 'Criar Evento';
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="evento-create">
    <h2><?= Html::encode($this->title) ?></h2>

        <?= $this->render('_form', [
                'model' => $model,
                'uploadForm' => $uploadForm,
                'locais' => $locais,
        ]) ?>


</div>