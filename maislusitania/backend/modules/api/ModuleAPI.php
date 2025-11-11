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

}
