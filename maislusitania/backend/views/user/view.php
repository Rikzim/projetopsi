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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user mr-2"></i>
                        <?= Html::encode($this->title) ?>
                    </h3>
                    <div class="card-tools ml-auto">
                        <?= Html::a('<i class="fas fa-edit mr-2"></i>Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm mr-2']) ?>
                        <?= Html::a('<i class="fas fa-trash mr-2"></i>Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja eliminar este utilizador?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna da Imagem -->
                        <div class="col-md-4 mb-4">
                            <div class="text-center">
                                <?php if ($userProfile && $userProfile->imagem_perfil): ?>
                                    <?= Html::img($userProfile->getImage(), [
                                        'class' => 'img-fluid rounded shadow-sm img-thumbnail',
                                        // Increased max-width and max-height for a bigger image
                                        'style' => 'width: 100%; max-width: 350px; max-height: 450px; object-fit: cover;',
                                        'alt' => Html::encode($this->title)
                                    ]) ?>
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 350px;">
                                        <i class="fas fa-user-circle fa-7x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Coluna dos Detalhes -->
                        <div class="col-md-8">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => ['class' => 'table table-hover table-striped detail-view'],
                                'attributes' => [
                                    'id',
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
                                                    return '<span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Ativo</span>';
                                                case 9:
                                                    return '<span class="badge badge-warning"><i class="fas fa-exclamation-circle mr-1"></i>Inativo</span>';
                                                case 0:
                                                    return '<span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i>Eliminado</span>';
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
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-arrow-left mr-2"></i>Voltar à Lista', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>