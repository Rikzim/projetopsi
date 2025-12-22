<?php
namespace backend\modules\api\controllers;

use Yii;
use common\models\UserProfile;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class UserProfileController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\UserProfile';

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
    // ENDPOINT: Obter perfil do usuário autenticado
    // ========================================
    /**
     * Retorna o perfil do usuário autenticado
     * Endpoint: GET /api/user-profile/me?access-token=SEU_TOKEN
     * 
     * @return UserProfile|array
     */
    public function actionMe()
    {
        // Obtém o ID do usuário autenticado
        $user = Yii::$app->user->identity;
        
        // Busca o perfil do usuário autenticado
        $userProfile = UserProfile::findOne(['user_id' => $user->id]);
        
        // Se o perfil não existir, retorna erro 404
        if (!$userProfile) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Perfil não encontrado para este usuário.',
            ];
        }
        
        //Retorna o perfil com dados do user

        $data = array_map(function($userProfile) {
            return [
                'id' => $userProfile->id,
                'primeiro_nome' => $userProfile->primeiro_nome,
                'ultimo_nome' => $userProfile->ultimo_nome,
                'imagem_perfil' => $userProfile->getImageAPI(), // URL completa da imagem
                'user_id' => $userProfile->user_id,
                'username' => $userProfile->user->username, // Dados do user relacionado
                'email' => $userProfile->user->email,
                'data_adesao' => Yii::$app->formatter->asDate($userProfile->user->created_at),
                 
            ];
        }, [$userProfile]);
        return $data;
    }

    // ========================================
    // Controle de Acesso
    // ========================================
    public function checkAccess($action, $model = null, $params = [])
    {
        // Se o utilizador for admin (tiver permissão para gerir utilizadores), permite tudo
        if (Yii::$app->user->can('editUser')) {
            return;
        }

        // Se a ação for 'update' ou 'view', verifica se o perfil pertence ao utilizador logado
        if ($action === 'update' || $action === 'view' || $action === 'delete') {
            if ($model->user_id !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('Não tem permissão para aceder a este perfil.');
            }
        }
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
                // Permite a utilizadores autenticados aceder ao seu próprio perfil
                [
                    'actions' => ['me'],
                    'allow' => true,
                    'roles' => ['viewOwnProfile'],
                ],
                // Permite a utilizadores autenticados atualizarem o seu próprio perfil
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['editOwnProfile'],
                ],
                // Permissões de Admin para gerir todos os perfis
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['viewUser'],
                ],
                [
                    'actions' => ['create'],
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

        // retornar em json
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;

        return $behaviors;
    } 
}