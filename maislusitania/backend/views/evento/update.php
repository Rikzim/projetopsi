<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->title = 'Editar Evento';
?>

<div class="evento-update">
    
    <h2><?= Html::encode($this->title) ?></h2>
    
    <?=$this->render('_form', [
            'model' => $model,
            'uploadForm' => $uploadForm,
            'locais' => $locais,
    ]) ?>

</div>