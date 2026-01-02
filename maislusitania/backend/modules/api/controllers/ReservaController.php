<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use Yii;

class ReservaController extends ActiveController
{
    public $modelClass = 'common\models\Reserva';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $userId = Yii::$app->user->id;

        $reservas = $modelClass::find()
            ->where(['utilizador_id' => $userId])
            ->with(['local'])
            ->orderBy(['data_criacao' => SORT_DESC])
            ->all();

        if (empty($reservas)) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Nenhuma reserva encontrada.'];
        }

        $data = array_map(function($reserva) {
            return [
                'id' => $reserva->id,
                'local_id' => $reserva->local->id,
                'local_nome' => $reserva->local->nome,
                'data_visita' => $reserva->data_visita,
                'preco_total' => number_format($reserva->preco_total, 2),
                'estado' => $reserva->estado,
                'data_criacao' => $reserva->data_criacao,
                'imagem_local' => $reserva->local->getImageAPI(),
            ];
        }, $reservas);

        Yii::$app->response->headers->set('X-Total-Count', (string)count($data));

        return $data;
    }

    public function actionView($id)
    {
        $modelClass = $this->modelClass;
        $userId = Yii::$app->user->id;

        $reserva = $modelClass::find()
            ->where(['id' => $id, 'utilizador_id' => $userId])
            ->with(['local', 'linhaReservas.tipoBilhete'])
            ->one();

        if ($reserva === null) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Reserva não encontrada ou não pertence ao utilizador.'];
        }

        // Expandir bilhetes individualmente
        $data = [];
        $bilheteNumero = 1;
        
        foreach ($reserva->linhaReservas as $linha) {
            for ($i = 1; $i <= $linha->quantidade; $i++) {
                $data[] = [
                    'numero' => $bilheteNumero,
                    'codigo' => str_pad($reserva->id, 6, '0', STR_PAD_LEFT) . '-' . str_pad($bilheteNumero, 3, '0', STR_PAD_LEFT),
                    'reserva_id' => $reserva->id,
                    'local_id' => $reserva->local->id,
                    'local_nome' => $reserva->local->nome,
                    'data_visita' => $reserva->data_visita,
                    'tipo_bilhete_id' => $linha->tipoBilhete->id,
                    'tipo_bilhete_nome' => $linha->tipoBilhete->nome,
                    'tipo_bilhete_descricao' => $linha->tipoBilhete->descricao,
                    'preco' => number_format($linha->tipoBilhete->preco, 2),
                    'estado' => $reserva->estado,
                ];
                $bilheteNumero++;
            }
        }

        Yii::$app->response->headers->set('X-Total-Count', (string)count($data));

        return $data;
    }

    public function actionSearch($nome){
        $modelClass = $this->modelClass;
        $userId = Yii::$app->user->id;

        $reservas = $modelClass::find()
            ->joinWith('local')
            ->where(['utilizador_id' => $userId])
            ->andWhere(['like', 'local_cultural.nome', $nome])
            ->with(['local'])
            ->orderBy(['data_criacao' => SORT_DESC])
            ->all();

        if (empty($reservas)) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Nenhuma reserva encontrada.'];
        }

        $data = array_map(function($reserva) {
            return [
                'id' => $reserva->id,
                'local_id' => $reserva->local->id,
                'local_nome' => $reserva->local->nome,
                'data_visita' => $reserva->data_visita,
                'preco_total' => number_format($reserva->preco_total, 2),
                'estado' => $reserva->estado,
                'data_criacao' => $reserva->data_criacao,
                'imagem_local' => $reserva->local->getImageAPI(),
            ];
        }, $reservas);

        Yii::$app->response->headers->set('X-Total-Count', (string)count($data));

        return $data;
    }

    public function actionCreate()
    {
        $postData = Yii::$app->request->post();

        if (empty($postData['local_id'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Local não especificado.'];
        }

        if (empty($postData['bilhetes'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Nenhum bilhete selecionado.'];
        }

        if (empty($postData['data_visita'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Data de visita não especificada.'];
        }

        try {
            $reserva = new \common\models\Reserva();
            $reserva->GuardarReserva($postData);

            Yii::$app->response->statusCode = 201;
            return [
                'id' => $reserva->id,
                'local_id' => $reserva->local_id,
                'local_nome' => $reserva->local->nome,
                'data_visita' => $reserva->data_visita,
                'preco_total' => number_format($reserva->preco_total, 2),
                'estado' => $reserva->estado,
                'data_criacao' => $reserva->data_criacao,
            ];

        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return ['error' => $e->getMessage()];
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

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

        $behaviors['contentNegotiator'] = [ // Resposta em JSON
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [

                [
                    'actions' => ['index', 'view', 'search'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['buyTickets'],
                ],
            ],
        ];

        return $behaviors;
    } 
}