<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TipoLocal $model */
/** @var common\models\UploadForm $uploadForm */

$this->title = 'Create Tipo Local';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Locals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Criar Tipo de Local';
?>
<div class="tipo-local-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm,
    ]) ?>

</div>
