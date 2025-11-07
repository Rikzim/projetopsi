<?php
namespace backend\modules\api\controllers;

use yii\rest\Controller;
use Yii;
use common\models\User;
use yii\filters\Cors;

class LoginFormController extends Controller
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
        $passwordHash = Yii::$app->request->post('password_hash');

        // Valida se campos estão vazios
        if (empty($username) || empty($passwordHash)) {
            Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'message' => 'Username ou password vazios'];
        }

        // Procura o utilizador
        $user = User::findOne(['username' => $username]);

        if (!$user) {
            Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Utilizador não encontrado'];
        }

        // ✅ Compara os hashes diretamente
        if ($user->password_hash !== $passwordHash) {
            Yii::$app->response->statusCode = 401;
            return ['status' => 'error', 'message' => 'Palavra-passe incorreta'];
        }

        // Retorna o token
        if (empty($user->access_token)) {
            $user->generateAccessToken();
            $user->save(false);
        }

        return [
            'status' => 'success',
            'access_token' => $user->access_token,
            'user_id' => $user->id,
            'username' => $user->username,
        ];
    }
}