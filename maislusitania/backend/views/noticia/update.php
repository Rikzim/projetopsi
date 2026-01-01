<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Noticia */~
/* @var $uploadForm backend\models\UploadForm */

$this->title = 'Editar Notícia: ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="noticia-update">
    <h2><?= Html::encode($this->title) ?></h2>
    <?=$this->render('_form', [
                        'model' => $model,
                        'locais' => $locais,
                        'uploadForm' => $uploadForm,
                    ]) ?>
</div>