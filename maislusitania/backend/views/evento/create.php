<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->title = 'Create Evento';
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'uploadForm' => $uploadForm,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->


</div>