<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use Yii;
use yii\filters\AccessControl;

class EventoController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\Evento';
    
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

        if (!is_array($behaviors)) {
            $behaviors = [];
        }

        $behaviors['corsFilter'] = [ // Adiciona CORS 
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        $behaviors['contentNegotiator'] = [ // Resposta em JSON
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['authenticator'] = [ // Adiciona autenticação
            'class' => QueryParamAuth::class,
        ];
        
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['index', 'view', 'tipo-local', 'search'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    } 

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $eventos = $modelClass::find()
            ->orderBy(['id' => SORT_DESC])
            ->where(['ativo' => true])
            ->all();

        if (empty($eventos)) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Nenhum evento encontrado.'];
        }
        
        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'nome_local' => $evento->local->nome,
                'descricao' => $evento->descricao,
                'imagem' => $evento->getImageAPI(),
                'data_inicio' => date('d/m/Y H:i', strtotime($evento->data_inicio)),
                'data_fim' => date('d/m/Y H:i', strtotime($evento->data_fim)),
            ];
        }, $eventos);

        Yii::$app->response->headers->set('X-Total-Count', (string)count($data));

        return $data;
    }

    public function actionView($id)
    {
        $modelClass = $this->modelClass;
        $evento = $modelClass::findOne(['id' => $id, 'ativo' => true]);

        if (!$evento) {
            Yii::$app->response->statusCode = 404;
            return ['error' => "O evento com o ID $id não foi encontrado."];
        }
        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'nome_local' => $evento->local->nome,
                'titulo' => $evento->titulo,
                'descricao' => $evento->descricao,
                'imagem' => $evento->getImageAPI(),
                'data_inicio' => date('d/m/Y H:i', strtotime($evento->data_inicio)),
                'data_fim' => date('d/m/Y H:i', strtotime($evento->data_fim)),
            ];
        }, [$evento]);
        return $data;
    }

    // Extra Patterns
    public function actionTipoLocal($nome)
    {
        $modelClass = $this->modelClass;
        $eventos = $modelClass::find()
            ->joinWith('local.tipoLocal') // ALTERADO: tipoLocal para tipo
            ->where(['LIKE', 'LOWER(tipo_local.nome)', strtolower($nome)])
            ->andWhere(['evento.ativo' => true])
            ->all();
            
        if (empty($eventos)) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Nenhum evento encontrado com esse tipo de local.'];
        }

        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'descricao' => $evento->descricao,
                'imagem' => $evento->getImageAPI(),
                'data_inicio' => date('d/m/Y H:i', strtotime($evento->data_inicio)),
                'data_fim' => date('d/m/Y H:i', strtotime($evento->data_fim)),
            ];
        }, $eventos);

        return $data;
    }

    public function actionSearch($nome)
    {
        $modelClass = $this->modelClass;
        $eventos = $modelClass::find()
            ->where(['LIKE', 'LOWER(titulo)', strtolower($nome)])
            ->andWhere(['ativo' => true])
            ->all();
        if (empty($eventos)) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Nenhum evento encontrado com esse nome.'];
        }

        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'descricao' => $evento->descricao,
                'imagem' => $evento->getImageAPI(),
                'data_inicio' => date('d/m/Y H:i', strtotime($evento->data_inicio)),
                'data_fim' => date('d/m/Y H:i', strtotime($evento->data_fim)),
            ];
        }, $eventos);

        Yii::$app->response->headers->set('X-Total-Count', (string)count($data));

        return $data;
    }
}