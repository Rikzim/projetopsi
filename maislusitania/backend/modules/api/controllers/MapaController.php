<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\Cors;
use common\models\LocalCultural;
use common\models\TipoLocal;
use Yii;

class MapaController extends ActiveController
{
    // ========================================
    // Define o modelo
    // ========================================
    public $modelClass = 'common\models\LocalCultural';

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

    // Lista todos os locais e o seus tipos com a imagem
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $modelClass = $this->modelClass;
        $locais = $modelClass::find()
            ->where(['ativo' => true])
            ->all();

        $data = array_map(function($local) {
            return [
                'id' => $local->id,
                'nome' => $local->nome,
                'imagem' => $local->getImageAPI(),
                'tipo' => $local->tipoLocal->nome,
                'latitude' => $local->latitude,
                'longitude' => $local->longitude,
                'markerImagem' => $local->tipoLocal->getImageAPI(),
            ];
        }, $locais);

        return $data;
    }
}