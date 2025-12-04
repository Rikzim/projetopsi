<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class InformacoesUteisWidget extends Widget
{
    public $model;                  // O modelo LocalCultural
    public $showPreco = true;       // Mostrar preço
    public $precoText = 'Consultar Bilhetes';  // Texto do preço

    public function init()
    {
        parent::init();
        
        if ($this->model === null) {
            throw new \yii\base\InvalidConfigException('A propriedade "model" deve ser definida.');
        }
    }

    public function run()
    {
        return $this->render('informacoes-uteis', [
            'model' => $this->model,
            'showPreco' => $this->showPreco,
            'precoText' => $this->precoText,
        ]);
    }
}