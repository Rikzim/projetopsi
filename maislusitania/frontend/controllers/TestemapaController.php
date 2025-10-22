<?php

namespace frontend\controllers;

use yii\web\Controller;

class TestemapaController extends Controller
{
    public function actionIndex()
    {
        //TODO: Passar marcadores reais de locais culturais em Portugal.
        

    $markers = [
    // Lisboa
    [
        'lat' => 38.6979,
        'lng' => -9.2076,
        'popup' => '<b>Torre de Belém</b><br>Monumento histórico - Lisboa'
    ],
    [
        'lat' => 38.6977,
        'lng' => -9.2066,
        'popup' => '<b>Mosteiro dos Jerónimos</b><br>Monumento do século XVI - Lisboa'
    ],
    [
        'lat' => 38.7139,
        'lng' => -9.1394,
        'popup' => '<b>Castelo de São Jorge</b><br>Castelo medieval - Lisboa'
    ],
    
    // Porto
    [
        'lat' => 41.1412,
        'lng' => -8.6118,
        'popup' => '<b>Torre dos Clérigos</b><br>Torre barroca - Porto'
    ],
    [
        'lat' => 41.1579,
        'lng' => -8.6291,
        'popup' => '<b>Museu de Serralves</b><br>Museu de arte contemporânea - Porto'
    ],
    [
        'lat' => 41.1406,
        'lng' => -8.6137,
        'popup' => '<b>Livraria Lello</b><br>Livraria histórica - Porto'
    ],
    
    // Sintra
    [
        'lat' => 38.7876,
        'lng' => -9.3906,
        'popup' => '<b>Palácio da Pena</b><br>Palácio romântico - Sintra'
    ],
    [
        'lat' => 38.7969,
        'lng' => -9.3887,
        'popup' => '<b>Castelo dos Mouros</b><br>Castelo medieval - Sintra'
    ],
    [
        'lat' => 38.7859,
        'lng' => -9.3958,
        'popup' => '<b>Quinta da Regaleira</b><br>Palácio e jardins místicos - Sintra'
    ],
    
    // Coimbra
    [
        'lat' => 40.2073,
        'lng' => -8.4277,
        'popup' => '<b>Universidade de Coimbra</b><br>Biblioteca Joanina - Coimbra'
    ],
    [
        'lat' => 40.2085,
        'lng' => -8.4261,
        'popup' => '<b>Sé Velha de Coimbra</b><br>Catedral românica - Coimbra'
    ],
    
    // Évora
    [
        'lat' => 38.5719,
        'lng' => -7.9070,
        'popup' => '<b>Templo Romano de Évora</b><br>Templo romano - Évora'
    ],
    [
        'lat' => 38.5667,
        'lng' => -7.9075,
        'popup' => '<b>Capela dos Ossos</b><br>Igreja do século XVII - Évora'
    ],
    
    // Braga
    [
        'lat' => 41.5518,
        'lng' => -8.3963,
        'popup' => '<b>Bom Jesus do Monte</b><br>Santuário - Braga'
    ],
    [
        'lat' => 41.5503,
        'lng' => -8.4263,
        'popup' => '<b>Sé de Braga</b><br>Catedral - Braga'
    ],
    
    // Guimarães
    [
        'lat' => 41.4460,
        'lng' => -8.2919,
        'popup' => '<b>Castelo de Guimarães</b><br>Berço da nação - Guimarães'
    ],
    [
        'lat' => 41.4429,
        'lng' => -8.2915,
        'popup' => '<b>Paço dos Duques de Bragança</b><br>Palácio do século XV - Guimarães'
    ],
    
    // Algarve
    [
        'lat' => 37.0175,
        'lng' => -7.9304,
        'popup' => '<b>Castelo de Silves</b><br>Castelo medieval - Silves'
    ],
    
    // Batalha
    [
        'lat' => 39.6603,
        'lng' => -8.8250,
        'popup' => '<b>Mosteiro da Batalha</b><br>Mosteiro gótico - Batalha'
    ],
    
    // Alcobaça
    [
        'lat' => 39.5482,
        'lng' => -8.9784,
        'popup' => '<b>Mosteiro de Alcobaça</b><br>Mosteiro cisterciense - Alcobaça'
    ],
    
    // Tomar
    [
        'lat' => 39.6029,
        'lng' => -8.4195,
        'popup' => '<b>Convento de Cristo</b><br>Convento templário - Tomar'
    ],
    ];
        return $this->render('index', [
            'markers' => $markers,
        ]);
    }
}