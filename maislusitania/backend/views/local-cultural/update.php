<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $uploadForm backend\models\UploadForm */
/* @var $horario common\models\Horario */


$this->title = 'Update Local Cultural: ' . $model->nome;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'uploadForm' => $uploadForm,
                        'horario' => $horario,
                    ]) ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>