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