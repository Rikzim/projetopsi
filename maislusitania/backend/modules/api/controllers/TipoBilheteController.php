<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class TipoBilheteController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\TipoBilhete';

    // ========================================
    // Configura data provider
    // ========================================
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;
        
        return new ActiveDataProvider([
            'query' => $modelClass::find()->orderBy(['id' => SORT_DESC]), 
            'pagination' => [
                'pageSize' => 20, 
            ],
        ]);
    }

    // ========================================
    // Define campos a retornar
    // ========================================
    public function fields()
    {
        return [
            'id',
            // ← ADICIONAR campos a retornar
        ];
    }

    // ========================================
    // Controle de permissões
    // ========================================
    public function checkAccess($action, $model = null, $params = [])
    {
        $user = $this->module->user;

        // Apenas admins podem criar/editar/apagar
        if (in_array($action, ['create', 'update', 'delete'])) {
            if (!$user || $user->role !== 'admin') {
                throw new \yii\web\ForbiddenHttpException('Apenas administradores');
            }
        }
    }
}