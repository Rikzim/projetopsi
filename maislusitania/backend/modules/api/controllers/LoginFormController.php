<?php
namespace backend\modules\api\controllers;

use yii\rest\Controller;
use Yii;
use common\models\LoginForm;
use yii\filters\Cors;

class LoginController extends Controller
{
    public $enableCsrfValidation = false; // necessário para aceitar POST externo (Android)

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Permitir CORS (Android pode chamar)
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET','POST','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');

        if (!$model->validate()) {
            Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'message' => 'Campos inválidos'];
        }

        $user = $model->getUser();

        if (!$user) {
            Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Utilizador não encontrado'];
        }

        if (!$user->validatePassword($model->password)) {
            Yii::$app->response->statusCode = 401;
            return ['status' => 'error', 'message' => 'Palavra-passe incorreta'];
        }

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
