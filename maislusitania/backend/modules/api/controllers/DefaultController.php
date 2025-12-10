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
                '/api/linhas-reserva' => 'Gestão de linhas de reserva',
                '/api/local-culturals' => 'Gestão de locais culturais',
                '/api/tipo-bilhetes' => 'Gestão de tipos de bilhete',
                '/api/tipo-locals' => 'Gestão de tipos de local',
                '/api/user-profile' => 'Gestão de perfis de utilizador',
                '/api/mapa' => 'Gestão de mapa',
                //RESTANTAS ENDPOINTS AQUI
            ],
        ];
    }

}