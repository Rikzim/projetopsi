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
    }
    public function run()
    {
        return $this->render('noticias-relacionadas', [
            'noticias' => array_slice($this->noticias, 0, $this->limit),
        ]);
    }
}