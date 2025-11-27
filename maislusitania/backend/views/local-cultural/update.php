<?php

/* @var $this yii\web\View */
/* @var $model common\models\LocalCultural */
/* @var $uploadForm backend\models\UploadForm */
/* @var $horario common\models\Horario */

$this->title = 'Update Local Cultural: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Local Culturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>