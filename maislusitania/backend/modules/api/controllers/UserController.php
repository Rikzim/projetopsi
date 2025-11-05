<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;

class UserController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\User';

    // ========================================
    // Desabilita ações desnecessárias
    // ========================================
    public function actions()
    {
        $actions = parent::actions();
        
        // Remove a ação index (listar todos)
        unset($actions['index']);
        
        return $actions;
    }

    // ========================================
    // Controle de permissões
    // ========================================
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if (!is_array($behaviors)) {
            $behaviors = [];
        }

        // CORS para todos os controllers
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'only' => ['view'],  // Apenas para o GET com ID específico
        ];

        return $behaviors;
    } 
}