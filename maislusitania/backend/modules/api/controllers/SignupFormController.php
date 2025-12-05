<?php
namespace backend\modules\api\controllers;

use yii\rest\Controller;
use Yii;
use common\models\User;
use common\models\UserProfile;
use backend\models\SignupForm;
use yii\filters\Cors;

class SignupFormController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $username = Yii::$app->request->post('username');
        $email = Yii::$app->request->post('email');
        $password = Yii::$app->request->post('password');
        $primeiroNome = Yii::$app->request->post('primeiro_nome');
        $ultimoNome = Yii::$app->request->post('ultimo_nome');


        // Valida se campos estão vazios
        if (empty($username) || empty($password) || empty($email) || empty($primeiroNome) || empty($ultimoNome)) {
            Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'message' => 'Campos obrigatórios em falta'];
        }
        // Verifica se o utilizador já existe
        if(User::findOne(['username' => $username]) || User::findOne(['email' => $email])) {
            Yii::$app->response->statusCode = 409;
            return ['status' => 'error', 'message' => 'Utilizador já existe'];
        }
        // Cria novo utilizador
        $model = new SignupForm();
        $model->username = $username;
        $model->email = $email;
        $model->password = $password;
        $model->password_confirm = $password;
        $model->primeiro_nome = $primeiroNome;
        $model->ultimo_nome = $ultimoNome;
        $model->role = 'user';
        
        $user = $model->signup();

        if (!$user) {
            Yii::$app->response->statusCode = 500;
            return ['status' => 'error', 'message' => 'Erro ao criar utilizador', 'errors' => $model->errors];
        }

        Yii::$app->response->statusCode = 201;
        return [
            'status' => 'success',
            'message' => 'Utilizador criado com sucesso',
            'user_id' => $user->id,
        ];
    }
}