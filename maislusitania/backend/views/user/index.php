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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>
                        Gestão de Utilizadores
                    </h3>
                    <div class="card-tools">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar Utilizador', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    </div>
                </div>

                <!-- Filtros e Pesquisa -->
                <div class="card-body border-bottom">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => true,
                            'id' => 'user-filter-form'
                        ],
                    ]); ?>
                    
                    <div class="row align-items-center">
                        <!-- Campo de Pesquisa Geral -->
                        <div class="col-lg-6 col-md-6 mb-2">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <?= Html::activeTextInput($searchModel, 'globalSearch', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pesquisar por username ou email...'
                                ]) ?>
                            </div>
                        </div>
                        
                        <!-- Filtro por Estado -->
                        <div class="col-lg-3 col-md-3 mb-2">
                            <?= Html::activeDropDownList($searchModel, 'status', 
                                [
                                    User::STATUS_ACTIVE => 'Ativo',
                                    User::STATUS_INACTIVE => 'Inativo',
                                ],
                                [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Todos os Estados',
                                    'onchange' => '$("#user-filter-form").submit()'
                                ]
                            ) ?>
                        </div>
                        
                        <!-- Botões -->
                        <div class="col-lg-3 col-md-3 mb-2">
                            <div class="btn-group w-100">
                                <?= Html::submitButton('<i class="fas fa-search"></i>', [
                                    'class' => 'btn btn-primary btn-sm',
                                    'title' => 'Pesquisar'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-redo"></i>', ['index'], [
                                    'class' => 'btn btn-secondary btn-sm',
                                    'title' => 'Limpar Filtros'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
                
                <div class="card-body p-0">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                        'headerRowOptions' => ['class' => 'bg-light'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 50px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'label' => 'Imagem',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $profile = $model->userProfile;
                                    if ($profile && !empty($profile->imagem_perfil)) {
                                        return Html::img($profile->getImage(), [
                                            'width' => '50', 
                                            'height' => '50', 
                                            'style' => 'object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;'
                                        ]);
                                    }
                                    return Html::tag('div', strtoupper(substr($model->username, 0, 1)), [
                                        'style' => 'width: 50px; height: 50px; border-radius: 50%; background-color: #2E5AAC; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; margin: 0 auto;'
                                    ]);
                                },
                                'headerOptions' => ['style' => 'width: 70px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'attribute' => 'username',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::tag('div',
                                        Html::tag('strong', Html::encode($model->username), ['class' => 'text-dark']) .
                                        Html::tag('small', Html::encode($model->email), ['class' => 'd-block text-muted']),
                                        ['class' => 'py-1']
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 250px;'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Estado',
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->status == 10) {
                                        return Html::tag('span',
                                            '<i class="fas fa-check-circle mr-2"></i>Ativo',
                                            [
                                                'class' => 'badge badge-success',
                                                'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                            ]
                                        );
                                    }
                                    return Html::tag('span',
                                        '<i class="fas fa-times-circle mr-2"></i>Inativo',
                                        [
                                            'class' => 'badge badge-danger',
                                            'style' => 'font-size: 0.95rem; padding: 0.6em 1em; display: inline-block;'
                                        ]
                                    );
                                },
                                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'label' => 'Role',
                                'value' => function (User $model) {
                                    $roles = Yii::$app->authManager->getRolesByUser($model->id);
                                    if (empty($roles)) {
                                        return '—';
                                    }
                                    return implode(', ', array_keys($roles));
                                },
                                'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-eye"></i>',
                                            ['view', 'id' => $model->id],
                                            [
                                                'title' => 'Ver Detalhes',
                                                'class' => 'btn btn-sm btn-info mr-1',
                                                'data-pjax' => '0',
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-edit"></i>',
                                            ['update', 'id' => $model->id],
                                            [
                                                'title' => 'Editar',
                                                'class' => 'btn btn-sm btn-warning mr-1',
                                                'data-pjax' => '0',
                                            ]
                                        );
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-trash"></i>',
                                            ['delete', 'id' => $model->id],
                                            [
                                                'title' => 'Eliminar',
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Tem a certeza que deseja eliminar este utilizador?',
                                                    'method' => 'post',
                                                ],
                                            ]
                                        );
                                    },
                                ],
                                'headerOptions' => ['style' => 'width: 180px; text-align: center;'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'text-muted small px-3 py-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                            'options' => ['class' => 'pagination pagination-sm justify-content-center mb-0'],
                        ]
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>