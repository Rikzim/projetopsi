<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;

class AvaliacaoController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\Avaliacao';

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
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        
        $behaviors['authenticator'] = [
           
            'class' => QueryParamAuth::class,
            //only=> ['index'],  //Apenas para o GET
            
        ];

        return $behaviors;
    } 

    public function actionAdd($localid)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            Yii::$app->response->statusCode = 401;
            return ['status' => 'error', 'message' => 'Autenticação obrigatória'];
        }

        $model = new $this->modelClass;

        $model->local_id = $localid;
        $model->utilizador_id = $user->id;
        $model->classificacao = Yii::$app->request->post('classificacao');
        $model->comentario = Yii::$app->request->post('comentario', null);
        $model->data_avaliacao = date('Y-m-d H:i:s');
        $model->ativo = 1;

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return $model;
        } else {
            Yii::$app->response->statusCode = 400;
            return ['errors' => $model->errors];
        }
    }

    public function actionRemove($id){
        $user = Yii::$app->user->identity;
        
        if (!$user) {
            Yii::$app->response->statusCode = 401;
            return ['status' => 'error', 'message' => 'Autenticação obrigatória'];
        }

        $modelClass = $this->modelClass;

        $avaliacao = $modelClass::findOne(['id' => $id, 'utilizador_id' => $user->id]);

        if (!$avaliacao) {
            Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Avaliação não encontrada'];
        }

        if ($avaliacao->delete()) {
            Yii::$app->response->statusCode = 200;
            return ['status' => 'success', 'message' => 'Avaliação removida com sucesso'];
        } else {
            Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'message' => 'Erro ao remover avaliação'];
        }
    }
}