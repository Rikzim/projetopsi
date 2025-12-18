<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use Yii;

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
        return $behaviors;
    } 

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $eventos = $modelClass::find()
            ->orderBy(['id' => SORT_DESC])
            ->where(['ativo' => true])
            ->all();
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
        return [$data];
    }

    public function actionView($id)
    {
        $modelClass = $this->modelClass;
        $evento = $modelClass::find()
            ->orderBy(['id' => SORT_DESC])
            ->where(['ativo' => true])
            ->all();
        if (!$evento) {
            throw new NotFoundHttpException('Evento não encontrado.');
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
        }, $evento);
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
            return ['message' => 'Nenhum evento encontrado com esse tipo de local.'];
        }

        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
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
            return ['data' => ['message' => 'Nenhum evento encontrado com esse tipo de local.']]; // Retorna array vazio se nenhum evento encontrado
        }

        $data = array_map(function($evento) {
            return [
                'id' => $evento->id,
                'titulo' => $evento->titulo,
                'imagem' => $evento->getImageAPI(),
                'data_inicio' => date('d/m/Y H:i', strtotime($evento->data_inicio)),
                'data_fim' => date('d/m/Y H:i', strtotime($evento->data_fim)),
            ];
        }, $eventos);

        return $data;
    }
}