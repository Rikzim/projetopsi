<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var common\models\UserProfile $userProfile */

$this->title = $userProfile ? $userProfile->primeiro_nome . ' ' . $userProfile->ultimo_nome : $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que deseja eliminar este utilizador?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'imagem_perfil',
                'label' => 'Imagem de Perfil',
                'value' => function($model) use ($userProfile) {
                    if ($userProfile && $userProfile->imagem_perfil) {
                        return Html::img('@web/uploads/' . $userProfile->imagem_perfil, [
                            'style' => 'max-width: 200px;',
                            'class' => 'img-thumbnail'
                        ]);
                    }
                    return 'Sem imagem';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'primeiro_nome',
                'label' => 'Primeiro Nome',
                'value' => $userProfile ? $userProfile->primeiro_nome : '-',
            ],
            [
                'attribute' => 'ultimo_nome',
                'label' => 'Último Nome',
                'value' => $userProfile ? $userProfile->ultimo_nome : '-',
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    switch($model->status) {
                        case 10:
                            return '<span class="badge badge-success">Ativo</span>';
                        case 9:
                            return '<span class="badge badge-warning">Inativo</span>';
                        case 0:
                            return '<span class="badge badge-danger">Eliminado</span>';
                        default:
                            return '<span class="badge badge-secondary">Desconhecido</span>';
                    }
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Roles',
                'value' => function($model) {
                    $auth = Yii::$app->authManager;
                    $roles = $auth->getRolesByUser($model->id);
                    if (!empty($roles)) {
                        $roleNames = array_map(function($role) {
                            return '<span class="badge badge-primary">' . Html::encode($role->name) . '</span>';
                        }, $roles);
                        return implode(' ', $roleNames);
                    }
                    return '<span class="badge badge-warning">Sem roles</span>';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s'],
                'label' => 'Data de Criação',
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d/m/Y H:i:s'],
                'label' => 'Última Atualização',
            ],
            'auth_key',
            'password_reset_token',
            'verification_token',
        ],
    ]) ?>

</div>