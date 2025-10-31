<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\LocalCultural;

class MapaController extends Controller
{
    public function actionIndex()
    {
        $locais = LocalCultural::find()->all();
        
        $markers = [];
        foreach ($locais as $local) 
        {
            $markers[] = 
            [
                'lat' => (float)$local->latitude,
                'lng' => (float)$local->longitude,
                'popup' => '<b>' . $local->nome . '</b><br>' . $local->distrito->nome,
                'type' => $local->tipo->nome,
                'icone' => $local->tipo->icone // Mudado de tipoLocal para tipo
            ];
        }
        
        return $this->render('index', [
            'markers' => $markers,
        ]);
    }
}