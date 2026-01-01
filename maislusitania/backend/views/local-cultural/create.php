<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $uploadForm backend\models\UploadForm */
/* @var $horario common\models\Horario */

$this->title = 'Criar Local Cultural';
$this->params['breadcrumbs'][] = ['label' => 'Local Culturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="local-cultural-create">
    <h2><?= Html::encode($this->title) ?></h2>
    
    <?= $this->render('_form', [
                'model' => $model,
                'uploadForm' => $uploadForm,
                'horario' => $horario,
                'tipoLocais' => $tipoLocais,
                'distritos' => $distritos,
    ]) ?>

</div>