<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class EventosRelacionadosWidget extends Widget
{
    public $localCulturalId;    // ID do local cultural
    public $eventos = [];        // Array de eventos (opcional)
    public $limit = 3;           // Limite de eventos a mostrar

    public function init()
    {
        parent::init();
        
        // Se não foram passados eventos, buscar do banco de dados
        if (empty($this->eventos) && $this->localCulturalId !== null) {
            $this->eventos = $this->getEventosRelacionados();
        }
    }

    /**
     * Busca eventos relacionados ao local cultural
     * TODO: Implementar query real quando o modelo Evento existir
     */
    private function getEventosRelacionados()
    {
        // Por enquanto, retornar dados de exemplo
        return [
            [
                'id' => 1,
                'titulo' => 'Visita Guiada',
                'data' => '20 Jan de 2025',
                'limite' => '30',
                'descricao' => 'Desfrute de uma visita especial com antigas lápreas portuguesas no claustro do mosteiro.',
                'imagem' => null,
            ],
            [
                'id' => 2,
                'titulo' => 'Visita Guiada',
                'data' => '22 Jan de 2025',
                'limite' => '25',
                'descricao' => 'Desfrute de uma visita especial com antigas lápreas portuguesas no claustro do mosteiro.',
                'imagem' => null,
            ],
            [
                'id' => 3,
                'titulo' => 'Visita Guiada',
                'data' => '25 Jan de 2025',
                'limite' => '20',
                'descricao' => 'Desfrute de uma visita especial com antigas lápreas portuguesas no claustro do mosteiro.',
                'imagem' => null,
            ],
        ];
    }

    public function run()
    {
        if (empty($this->eventos)) {
            return ''; // Não renderizar se não houver eventos
        }

        return $this->render('eventos-relacionados', [
            'eventos' => array_slice($this->eventos, 0, $this->limit),
        ]);
    }
}