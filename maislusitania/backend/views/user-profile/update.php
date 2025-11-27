<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */

$this->title = 'Atualizar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>