<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\AccessControl;
use Yii;

class ReservaController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\Reserva';

    // ========================================
    // Configura data provider
    // ========================================
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        
        // Desabilitar a action 'create' padrão para usar nossa customizada
        unset($actions['create']);
        
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
    // Action customizada para criar reservas
    // ========================================
    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $postData = Yii::$app->request->post();

        // Validações básicas
        if (empty($postData['local_id'])) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Local não especificado.'
            ];
        }

        if (empty($postData['bilhetes'])) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Nenhum bilhete selecionado.'
            ];
        }

        if (empty($postData['data_visita'])) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Data de visita não especificada.'
            ];
        }

        try {
            $reserva = new \common\models\Reserva();
            $reserva->GuardarReserva($postData);

            // Carregar os dados completos da reserva criada com suas relações
            $reservaCompleta = \common\models\Reserva::find()
                ->where(['id' => $reserva->id])
                ->with([
                    'local',
                    'linhaReservas',
                    'linhaReservas.tipoBilhete'
                ])
                ->one();

            Yii::$app->response->statusCode = 201;
            return [
                'success' => true,
                'message' => 'Reserva criada com sucesso!',
                'data' => [
                    'id' => $reservaCompleta->id,
                    'local' => [
                        'id' => $reservaCompleta->local->id,
                        'nome' => $reservaCompleta->local->nome,
                    ],
                    'data_visita' => $reservaCompleta->data_visita,
                    'preco_total' => $reservaCompleta->preco_total,
                    'estado' => $reservaCompleta->estado,
                    'data_criacao' => $reservaCompleta->data_criacao,
                    'bilhetes' => array_map(function($linha) {
                        return [
                            'tipo' => $linha->tipoBilhete->nome,
                            'quantidade' => $linha->quantidade,
                        ];
                    }, $reservaCompleta->linhaReservas),
                ]
            ];

        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    // ========================================
    // Action para buscar bilhetes individuais de um utilizador
    // ========================================
    public function actionBilhetes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Verificar se está autenticado
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->response->statusCode = 401;
            return [
                'success' => false,
                'message' => 'Utilizador não autenticado.'
            ];
        }

        // Busca o ID do utilizador autenticado através do token
        $userId = \Yii::$app->user->id;

        // Buscar todas as reservas do utilizador com suas relações
        $reservas = \common\models\Reserva::find()
            ->where(['utilizador_id' => $userId])
            ->with([
                'local',
                'linhaReservas.tipoBilhete'
            ])
            ->orderBy(['data_criacao' => SORT_DESC])
            ->all();

        // Verificar se foram encontradas reservas
        if (empty($reservas)) {
            return [
                'success' => true,
                'message' => 'Nenhum bilhete encontrado para este utilizador.',
                'data' => []
            ];
        }

        // Expandir os bilhetes individuais
        $bilhetesIndividuais = [];
        
        foreach ($reservas as $reserva) {
            foreach ($reserva->linhaReservas as $linha) {
                // Para cada quantidade, criar um bilhete individual
                for ($i = 1; $i <= $linha->quantidade; $i++) {
                    $bilhetesIndividuais[] = [
                        'codigo' => str_pad($reserva->id, 6, '0', STR_PAD_LEFT) . '-' . $i,
                        'reserva_id' => $reserva->id,
                        'local' => [
                            'id' => $reserva->local->id,
                            'nome' => $reserva->local->nome,
                        ],
                        'data_visita' => $reserva->data_visita,
                        'tipo_bilhete' => $linha->tipoBilhete->nome,
                        'preco' => $linha->tipoBilhete->preco,
                        'estado' => $reserva->estado,
                        'data_criacao' => $reserva->data_criacao,
                    ];
                }
            }
        }

        return [
            'success' => true,
            'message' => 'Bilhetes encontrados com sucesso.',
            'data' => $bilhetesIndividuais,
            'total' => count($bilhetesIndividuais)
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
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        
        $behaviors['authenticator'] = [
           
            'class' => QueryParamAuth::class,
            //only=> ['index'],  //Apenas para o GET
            
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['buyTickets'],
                ],
                [
                    'actions' => ['bilhetes'],
                    'allow' => true,
                    'roles' => ['@'], // @ significa utilizadores autenticados
                ],
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['viewBilling'],
                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['editBilling'],
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['deleteBilling'],
                ],
            ],
        ];

        return $behaviors;
    } 
}