<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $uploadForm backend\models\UploadForm */
/* @var $horario common\models\Horario */


$this->title = 'Editar Local Cultural: ' . $model->nome;
?>

<div class="local-cultural-update">
    <h2><?= Html::encode($this->title) ?></h2>
         
        <?=$this->render('_form', [
                        'model' => $model,
                        'uploadForm' => $uploadForm,
                        'horario' => $horario,
                        'tipoLocais' => $tipoLocais,
                        'distritos' => $distritos,
            ]) ?>

</div>