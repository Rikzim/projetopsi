<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\UpdateForm $model */
/** @var common\models\UploadForm $uploadForm */

$this->title = 'Atualizar Utilizador: ' . $model->primeiro_nome . ' ' . $model->ultimo_nome;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm,
    ]) ?>

</div>