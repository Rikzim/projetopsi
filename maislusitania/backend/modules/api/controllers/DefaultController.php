<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;

class DefaultController extends Controller
{
    /**
     * GET /api
     * Retorna informações sobre a API
     */
    public function actionIndex()
    {
        return [
            'name' => 'MaisLusitania API',
            'version' => '1.0.0',
            'status' => 'online',
            'endpoints' => [
                '/api/distritos' => 'Gestão de distritos',
                '/api/users' => 'Gestão de utilizadores',
                '/api/avaliacoes' => 'Gestão de avaliações',
                '/api/eventos' => 'Gestão de eventos',
                '/api/noticias' => 'Gestão de notícias',
                '/api/favoritos' => 'Gestão de favoritos',
                //RESTANTAS ENDPOINTS AQUI
            ],
            'authentication' => 'HTTP Basic Auth',
        ];
    }

}