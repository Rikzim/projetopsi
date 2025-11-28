<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TipoLocal $model */
/** @var common\models\UploadForm $uploadForm */

$this->title = 'Update Tipo Local: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Locals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-local-update">
    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm,
    ]) ?>
</div>
