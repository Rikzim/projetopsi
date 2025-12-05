<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use Yii;

class NoticiaController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\Noticia';

    // ========================================
    // Configura data provider
    // ========================================
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']); // Remover ação view padrão
        unset($actions['index']); // Remover ação index padrão
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

        // CORS para todos os controllers
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        
        return $behaviors;
    } 

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $modelClass = $this->modelClass;
        $noticia = $modelClass::find()
            ->where(['ativo' => true])
            ->all();

        $data = array_map(function($noticia) {
            return [
                'id' => $noticia->id,
                'nome' => $noticia->titulo,
                'resumo' => $noticia->resumo,
                'imagem' => $noticia->getImageAPI(),
                'data_publicacao' => $noticia->data_publicacao,
            ];
        }, $noticia);

        return ['data' => $data];
    }

    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $modelClass = $this->modelClass;
        $noticia = $modelClass::find()
            ->where(['id' => $id, 'ativo' => true])
            ->one();

        if (!$noticia) {
            throw new NotFoundHttpException('Notícia não encontrada.');
        }

        return ['data' => $noticia];
    }
}