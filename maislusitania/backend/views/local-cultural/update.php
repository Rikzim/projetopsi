<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LocalCulturalForm */

$this->title = 'Update Local Cultural: ' . $model->getLocalCultural()->nome;
$this->params['breadcrumbs'][] = ['label' => 'Local Culturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getLocalCultural()->nome, 'url' => ['view', 'id' => $model->getLocalCultural()->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1><?= Html::encode($this->title) ?></h1>

                    <?= $this->render('_form', [
                        'model' => $model,
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