<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use common\models\Favorito;
use common\models\LocalCultural;
use Yii;

class FavoritoController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\Favorito';
    
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
        ];

        return $behaviors;
    }

    public function actionAdd($localid)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['status' => 'error', 'message' => 'Autenticação obrigatória'];
        }

        $favoritoExistente = Favorito::getFavoriteByUserAndLocal($user->id, $localid);

        if ($favoritoExistente) {
            return ['status' => 'error', 'message' => 'Favorito já existe'];
        }

        $novoFavorito = new Favorito();
        $novoFavorito->utilizador_id = $user->id;
        $novoFavorito->local_id = $localid;

        if ($novoFavorito->save()) {
            return ['status' => 'success', 'message' => 'Favorito adicionado com sucesso'];
        } else {
            return ['status' => 'error', 'errors' => $novoFavorito->errors];
        }
    }
    public function actionRemove($localid)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['status' => 'error', 'message' => 'Autenticação obrigatória'];
        }

        $favorito = Favorito::getFavoriteByUserAndLocal($user->id, $localid);

        if (!$favorito) {
            return ['status' => 'error', 'message' => 'Favorito não encontrado'];
        }

        if ($favorito->delete()) {
            return ['status' => 'success', 'message' => 'Favorito removido com sucesso'];
        } else {
            return ['status' => 'error', 'message' => 'Erro ao remover favorito'];
        }
    }

    public function actionToggle($localid)
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            return ['status' => 'error', 'message' => 'Autenticação obrigatória'];
        }

        $favorito = Favorito::getFavoriteByUserAndLocal($userId, $localid);

        if ($favorito) {
            // Se já existe, remove o favorito
            $favorito->delete();
            return ['status' => 'removed'];
        } else {
            // Se não existe, cria um novo favorito
            $novoFavorito = new Favorito();
            $novoFavorito->utilizador_id = $userId;
            $novoFavorito->local_id = $localid;
            if ($novoFavorito->save()) {
                return ['status' => 'added'];
            } else {
                return ['status' => 'error', 'errors' => $novoFavorito->errors];
            }
        }
    }
}