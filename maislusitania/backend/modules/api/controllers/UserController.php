<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\AccessControl;

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
        // Ações padrão do ActiveController são mantidas, 
        // mas serão controladas pelo AccessControl
        return $actions;
    }

    // ========================================
    // Define campos a retornar
    // ========================================
    public function fields()
    {
        return [
            'id',
            'nome',
            // ← ADICIONAR campos a retornar
            
        ];
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
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['viewUser'],
                ],
                [
                    'actions' => ['create', 'update'],
                    'allow' => true,
                    'roles' => ['editUser'],
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['deleteUser'],
                ],
            ],
        ];

        return $behaviors;
    } 
}