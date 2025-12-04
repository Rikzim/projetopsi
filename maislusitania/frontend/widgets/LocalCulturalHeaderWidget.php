<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class LocalCulturalHeaderWidget extends Widget
{
    // Propriedades públicas que podem ser configuradas
    public $model;              // O modelo LocalCultural
    public $showBadge = true;   // Mostrar ou não o badge do tipo
    public $showRating = true;  // Mostrar ou não as avaliações

    /**
     * Inicializa o widget
     */
    public function init()
    {
        parent::init();
        
        // Validação: garantir que o model foi passado
        if ($this->model === null) {
            throw new \yii\base\InvalidConfigException('A propriedade "model" deve ser definida.');
        }
    }

    /**
     * Renderiza o widget
     */
    public function run()
    {
        $averageRating = $this->model->getAverageRating();
        $ratingCount = $this->model->getRatingCount();

        return $this->render('local-cultural-header', [
            'model' => $this->model,
            'showBadge' => $this->showBadge,
            'showRating' => $this->showRating,
            'averageRating' => $averageRating,
            'ratingCount' => $ratingCount,
        ]);
    }

}