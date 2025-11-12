<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BilhetesWidget extends Widget
{
    public $model;          // O modelo LocalCultural
    public $bilhetes = [];  // Array de bilhetes (opcional)

    public function init()
    {
        parent::init();
        
        // Se não foram passados bilhetes, usar dados padrão de exemplo
        if (empty($this->bilhetes)) {
            $this->bilhetes = [
                [
                    'tipo' => 'Adulto',
                    'descricao' => 'Acesso completo ao monumento e exposições permanentes',
                    'preco' => '10€',
                ],
                [
                    'tipo' => 'Criança',
                    'descricao' => 'Acesso completo ao monumento e exposições permanentes',
                    'preco' => 'Grátis',
                ],
                [
                    'tipo' => 'Sénior',
                    'descricao' => 'Acesso completo ao monumento e exposições permanentes',
                    'preco' => '7€',
                ],
                [
                    'tipo' => 'Estudante',
                    'descricao' => 'Acesso completo ao monumento e exposições permanentes',
                    'preco' => '3.50€',
                ],
            ];
        }
    }

    public function run()
    {
        return $this->render('bilhetes', [
            'bilhetes' => $this->bilhetes,
        ]);
    }
}