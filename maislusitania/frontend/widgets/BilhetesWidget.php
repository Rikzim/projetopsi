<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\TipoBilhete;

class BilhetesWidget extends Widget
{
    public $model;
    public $bilhetes = [];
    public $showComprar = true;
    public $maxQuantidade = 10;

    public function init()
    {
        parent::init();
        
        if (empty($this->bilhetes) && $this->model !== null) {
            // ✅ Widget pode chamar Model diretamente
            $this->bilhetes = TipoBilhete::getBilhetesFormatados($this->model->id);
        }
    }

    public function run()
    {
        return $this->render('bilhetes', [
            'bilhetes' => $this->bilhetes,
            'model' => $this->model,
            'showComprar' => $this->showComprar,
            'maxQuantidade' => $this->maxQuantidade,
        ]);
    }
}