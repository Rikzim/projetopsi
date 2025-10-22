<?php

namespace frontend\controllers;

use yii\web\Controller;

class TestemapaController extends Controller
{
    public function actionIndex()
    {
        //TODO: Passar marcadores reais de locais culturais em Portugal.
        // Exemplo de marcadores: Passar o tipo de local cultural (castelo, museu, monumento) para definir o ícone.
        
        $markers = [
            // Lisboa - Castelos/Palácios
            [
                'lat' => 38.7139,
                'lng' => -9.1394,
                'popup' => '<b>Castelo de São Jorge</b><br>Castelo medieval - Lisboa',
                'type' => 'castle'
            ],
            
            // Lisboa - Monumentos
            [
                'lat' => 38.6979,
                'lng' => -9.2076,
                'popup' => '<b>Torre de Belém</b><br>Monumento histórico - Lisboa',
                'type' => 'monument'
            ],
            [
                'lat' => 38.6977,
                'lng' => -9.2066,
                'popup' => '<b>Mosteiro dos Jerónimos</b><br>Monumento do século XVI - Lisboa',
                'type' => 'monument'
            ],
            [
                'lat' => 38.7223,
                'lng' => -9.1393,
                'popup' => '<b>Praça do Comércio</b><br>Praça histórica - Lisboa',
                'type' => 'monument'
            ],
            
            // Sintra - Castelos/Palácios
            [
                'lat' => 38.7876,
                'lng' => -9.3906,
                'popup' => '<b>Palácio da Pena</b><br>Palácio romântico - Sintra',
                'type' => 'castle'
            ],
            [
                'lat' => 38.7969,
                'lng' => -9.3887,
                'popup' => '<b>Castelo dos Mouros</b><br>Castelo medieval - Sintra',
                'type' => 'castle'
            ],
            [
                'lat' => 38.7859,
                'lng' => -9.3958,
                'popup' => '<b>Quinta da Regaleira</b><br>Palácio e jardins - Sintra',
                'type' => 'castle'
            ],
            [
                'lat' => 38.7879,
                'lng' => -9.3908,
                'popup' => '<b>Palácio Nacional de Sintra</b><br>Palácio real - Sintra',
                'type' => 'castle'
            ],
            
            // Porto - Monumentos
            [
                'lat' => 41.1412,
                'lng' => -8.6118,
                'popup' => '<b>Torre dos Clérigos</b><br>Torre barroca - Porto',
                'type' => 'monument'
            ],
            [
                'lat' => 41.1406,
                'lng' => -8.6137,
                'popup' => '<b>Livraria Lello</b><br>Livraria histórica - Porto',
                'type' => 'monument'
            ],
            [
                'lat' => 41.1409,
                'lng' => -8.6138,
                'popup' => '<b>Sé do Porto</b><br>Catedral do Porto',
                'type' => 'monument'
            ],
            
            // Porto - Museus
            [
                'lat' => 41.1579,
                'lng' => -8.6291,
                'popup' => '<b>Museu de Serralves</b><br>Museu de arte contemporânea - Porto',
                'type' => 'museum'
            ],
            [
                'lat' => 41.1452,
                'lng' => -8.6118,
                'popup' => '<b>Museu Nacional Soares dos Reis</b><br>Museu de arte - Porto',
                'type' => 'museum'
            ],
            
            // Coimbra
            [
                'lat' => 40.2073,
                'lng' => -8.4277,
                'popup' => '<b>Universidade de Coimbra</b><br>Biblioteca Joanina - Coimbra',
                'type' => 'monument'
            ],
            [
                'lat' => 40.2085,
                'lng' => -8.4261,
                'popup' => '<b>Sé Velha de Coimbra</b><br>Catedral românica - Coimbra',
                'type' => 'monument'
            ],
            [
                'lat' => 40.2111,
                'lng' => -8.4292,
                'popup' => '<b>Mosteiro de Santa Cruz</b><br>Mosteiro - Coimbra',
                'type' => 'monument'
            ],
            
            // Évora
            [
                'lat' => 38.5719,
                'lng' => -7.9070,
                'popup' => '<b>Templo Romano de Évora</b><br>Templo romano - Évora',
                'type' => 'monument'
            ],
            [
                'lat' => 38.5667,
                'lng' => -7.9075,
                'popup' => '<b>Capela dos Ossos</b><br>Igreja do século XVII - Évora',
                'type' => 'monument'
            ],
            [
                'lat' => 38.5715,
                'lng' => -7.9077,
                'popup' => '<b>Sé de Évora</b><br>Catedral - Évora',
                'type' => 'monument'
            ],
            [
                'lat' => 38.5678,
                'lng' => -7.9061,
                'popup' => '<b>Museu de Évora</b><br>Museu arqueológico - Évora',
                'type' => 'museum'
            ],
            
            // Braga
            [
                'lat' => 41.5518,
                'lng' => -8.3963,
                'popup' => '<b>Bom Jesus do Monte</b><br>Santuário - Braga',
                'type' => 'monument'
            ],
            [
                'lat' => 41.5503,
                'lng' => -8.4263,
                'popup' => '<b>Sé de Braga</b><br>Catedral - Braga',
                'type' => 'monument'
            ],
            [
                'lat' => 41.5609,
                'lng' => -8.3967,
                'popup' => '<b>Santuário do Sameiro</b><br>Santuário mariano - Braga',
                'type' => 'monument'
            ],
            
            // Guimarães
            [
                'lat' => 41.4460,
                'lng' => -8.2919,
                'popup' => '<b>Castelo de Guimarães</b><br>Berço da nação - Guimarães',
                'type' => 'castle'
            ],
            [
                'lat' => 41.4429,
                'lng' => -8.2915,
                'popup' => '<b>Paço dos Duques de Bragança</b><br>Palácio do século XV - Guimarães',
                'type' => 'castle'
            ],
            [
                'lat' => 41.4418,
                'lng' => -8.2929,
                'popup' => '<b>Museu Alberto Sampaio</b><br>Museu de arte - Guimarães',
                'type' => 'museum'
            ],
            
            // Batalha
            [
                'lat' => 39.6603,
                'lng' => -8.8250,
                'popup' => '<b>Mosteiro da Batalha</b><br>Mosteiro gótico - Batalha',
                'type' => 'monument'
            ],
            
            // Alcobaça
            [
                'lat' => 39.5482,
                'lng' => -8.9784,
                'popup' => '<b>Mosteiro de Alcobaça</b><br>Mosteiro cisterciense - Alcobaça',
                'type' => 'monument'
            ],
            
            // Tomar
            [
                'lat' => 39.6029,
                'lng' => -8.4195,
                'popup' => '<b>Convento de Cristo</b><br>Convento templário - Tomar',
                'type' => 'monument'
            ],
            
            // Algarve
            [
                'lat' => 37.0175,
                'lng' => -7.9304,
                'popup' => '<b>Castelo de Silves</b><br>Castelo medieval - Silves',
                'type' => 'castle'
            ],
            [
                'lat' => 37.0194,
                'lng' => -7.9350,
                'popup' => '<b>Museu Municipal de Arqueologia de Silves</b><br>Museu - Silves',
                'type' => 'museum'
            ],
            
            // Óbidos
            [
                'lat' => 39.3606,
                'lng' => -9.1571,
                'popup' => '<b>Castelo de Óbidos</b><br>Vila medieval - Óbidos',
                'type' => 'castle'
            ],
            
            // Mafra
            [
                'lat' => 38.9371,
                'lng' => -9.3259,
                'popup' => '<b>Palácio Nacional de Mafra</b><br>Palácio barroco - Mafra',
                'type' => 'castle'
            ],
        ];
        
        return $this->render('index', [
            'markers' => $markers,
        ]);
    }
}