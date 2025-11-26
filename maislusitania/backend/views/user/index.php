<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Profile Image',
                'format' => 'raw',
                'value' => function ($model) {
                    $profile = $model->userProfile;
                    if ($profile && !empty($profile->imagem_perfil)) {
                        $imageUrl = Yii::getAlias('@web') . '/uploads/' . Html::encode($profile->imagem_perfil);
                        return Html::img($imageUrl, ['width' => '50', 'height' => '50', 'style' => 'object-fit: cover; border-radius: 50%;']);
                    }
                    return Html::tag('div', strtoupper(substr($model->username, 0, 1)), [
                        'style' => 'width: 50px; height: 50px; border-radius: 50%; background-color: #2E5AAC; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;'
                    ]);
                },
            ],
            'username',
            'email:email',
            'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            ['label' => 'Role',
                    'value' => function (User $model) {
                        $roles = Yii::$app->authManager->getRolesByUser($model->id);
                        if (empty($roles)) {
                            return '—';
                        }
                        return implode(', ', array_keys($roles)); // shows role names like "admin, editor"
                    },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
