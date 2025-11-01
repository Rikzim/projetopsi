<?php

namespace backend\modules\api;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;

/**
 * api module definition class
 */
class ModuleAPI extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';
    public $user = null; // Guardar utilizador autenticado

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here

        // CRÍTICO: Desativa sessões para manter API stateless
        \Yii::$app->user->enableSession = false;
    }

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

        // Autenticação para todos os controllers
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            
            // OPCIONAL: Excluir alguns controllers/actions
            // 'except' => ['login/index', 'public/view'],
            
            'auth' => [$this, 'auth']
        ];

        return $behaviors;
    }

    /**
     * Autenticação global para todo o módulo
     */
    public function auth($username, $password)
    {
        $user = \common\models\User::findByUsername($username);
        
        if ($user && $user->validatePassword($password))
        {
            $this->user = $user; // Guardar para autorização
            return $user;
        }
        
        throw new \yii\web\ForbiddenHttpException('Autenticação falhou');
    }
}
