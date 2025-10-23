<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\LocalCultural $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Local Culturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="local-cultural-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome',
            'tipo_id',
            'morada',
            'distrito_id',
            'descricao:ntext',
            'horario_funcionamento',
            'contacto_telefone',
            'contacto_email:email',
            'website',
            'imagem_principal',
            'ativo',
        ],
    ]) ?>

</div>
