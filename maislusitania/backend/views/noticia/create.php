<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Noticia */
/* @var $uploadForm backend\models\UploadForm */

$this->title = 'Criar Notícia';
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="noticia-create">
    <h2><?= Html::encode($this->title) ?></h2>

                    <?=$this->render('_form', [
                        'model' => $model,
                        'locais' => $locais,
                        'uploadForm' => $uploadForm,
                    ]) ?>

</div>