<?php

namespace backend\modules\api\controllers;
use yii\rest\ActiveController;
use yii\filters\Cors;


class DistritoController extends ActiveController
{
 public $modelClass = 'common\models\Distrito';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Permitir chamadas externas (CORS)
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET','POST','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        return $behaviors;
    }

}
