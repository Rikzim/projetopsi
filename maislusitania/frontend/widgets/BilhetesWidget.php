<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\TipoBilhete;

class BilhetesWidget extends Widget
{
    public $model;              // O modelo LocalCultural
    public $bilhetes = [];      // Array de bilhetes (opcional)
    public $showComprar = true; // Mostrar botão comprar
    public $maxQuantidade = 10; // Quantidade máxima por bilhete

    public function init()
    {
        parent::init();
        
        if (empty($this->bilhetes) && $this->model !== null) {
            $this->bilhetes = $this->getBilhetesFromDatabase();
        }
    }

    private function getBilhetesFromDatabase()
    {
        $bilhetesModels = TipoBilhete::find()
            ->where(['local_id' => $this->model->id, 'ativo' => 1])
            ->orderBy(['preco' => SORT_DESC])
            ->all();

        $bilhetes = [];
        foreach ($bilhetesModels as $bilhete) {
            $preco = floatval($bilhete->preco);
            $gratuito = ($preco == 0);
            
            if ($gratuito) {
                $precoFormatado = 'Grátis';
            } else {
                $precoFormatado = number_format($preco, 2, ',', '') . '€';
            }
            
            $bilhetes[] = [
                'id' => $bilhete->id,
                'tipo' => $bilhete->nome,
                'descricao' => $bilhete->descricao,
                'preco' => $precoFormatado,
                'preco_valor' => $preco,
                'gratuito' => $gratuito,
            ];
        }

        return $bilhetes;
    }

    public function run()
    {
        return $this->render('bilhetes', [
            'bilhetes' => $this->bilhetes,
            'model' => $this->model, // Passar o modelo completo
            'showComprar' => $this->showComprar,
            'maxQuantidade' => $this->maxQuantidade,
        ]);
    }
}