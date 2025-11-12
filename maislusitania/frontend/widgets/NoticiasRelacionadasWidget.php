<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class NoticiasRelacionadasWidget extends Widget
{
    public $localCulturalId;    // ID do local cultural
    public $noticias = [];       // Array de notícias (opcional)
    public $limit = 3;           // Limite de notícias a mostrar

    public function init()
    {
        parent::init();
        
        // Se não foram passadas notícias, buscar do banco de dados
        if (empty($this->noticias) && $this->localCulturalId !== null) {
            $this->noticias = $this->getNoticiasRelacionadas();
        }
    }

    /**
     * Busca notícias relacionadas ao local cultural
     * TODO: Implementar query real quando o modelo Noticia existir
     */
    private function getNoticiasRelacionadas()
    {
        // Por enquanto, retornar dados de exemplo
        return [
            [
                'id' => 1,
                'titulo' => 'Visita Guiada',
                'data' => '20 Jan de 2025',
                'local' => 'Lisboa',
                'tempo_leitura' => '5min',
                'descricao' => 'Desfrute de uma visita especial com antigas lápreas portuguesas no claustro do mosteiro.',
                'imagem' => null,
            ],
            [
                'id' => 2,
                'titulo' => 'Nova Exposição',
                'data' => '18 Jan de 2025',
                'local' => 'Lisboa',
                'tempo_leitura' => '3min',
                'descricao' => 'Conheça a nova exposição de arte contemporânea portuguesa.',
                'imagem' => null,
            ],
            [
                'id' => 3,
                'titulo' => 'Restauração Completa',
                'data' => '15 Jan de 2025',
                'local' => 'Lisboa',
                'tempo_leitura' => '7min',
                'descricao' => 'O monumento passou por um processo de restauração que durou 2 anos.',
                'imagem' => null,
            ],
        ];
    }

    public function run()
    {
        if (empty($this->noticias)) {
            return ''; // Não renderizar se não houver notícias
        }

        return $this->render('noticias-relacionadas', [
            'noticias' => array_slice($this->noticias, 0, $this->limit),
        ]);
    }
}