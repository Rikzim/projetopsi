<?php

namespace frontend\controllers;

use yii\web\Controller;

class TestemapaController extends Controller
{
    public function actionIndex()
    {
        $markers = [
            [
                'lat' => 38.7223, 
                'lng' => -9.1393, 
                'popup' => '<b>Praça do Comércio</b><br>Historic square in Lisbon'
            ],
            [
                'lat' => 38.7169, 
                'lng' => -9.1399, 
                'popup' => '<b>Bairro Alto</b><br>Traditional neighborhood'
            ],
            [
                'lat' => 38.7139, 
                'lng' => -9.1394, 
                'popup' => '<b>Chiado</b><br>Cultural district'
            ],
        ];
        
        return $this->render('index', [
            'markers' => $markers,
        ]);
    }
}