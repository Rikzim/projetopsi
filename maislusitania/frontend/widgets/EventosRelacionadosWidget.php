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
    }
    public function run()
    {
        return $this->render('eventos-relacionados', [
            'eventos' => array_slice($this->eventos, 0, $this->limit),
        ]);
    }
}