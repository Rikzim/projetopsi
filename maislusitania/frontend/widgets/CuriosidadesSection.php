<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class CuriosidadesSection extends Widget
{
    public $title = 'Curiosidades do Nosso Património';
    public $backgroundColor = '#2E5AAC';
    public $cards = [];

    public function init()
    {
        parent::init();
        if (empty($this->cards)) {
            $this->cards = [
                [
                    'image' => '@web/images/mosteiro.jpg',
                    'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                    'buttonText' => 'Ver mais',
                    'url' => '#'
                ],
                [
                    'image' => '@web/images/mosteiro.jpg',
                    'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                    'buttonText' => 'Ver mais',
                    'url' => '#'
                ],
                [
                    'image' => '@web/images/mosteiro.jpg',
                    'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                    'buttonText' => 'Ver mais',
                    'url' => '#'
                ],
                [
                    'image' => '@web/images/mosteiro.jpg',
                    'title' => 'O Mosteiro dos Jerónimos levou um século para ser concluído.',
                    'buttonText' => 'Ver mais',
                    'url' => '#'
                ]
            ];
        }
    }

    public function run()
    {
        return $this->render('curiosidades-section', [
            'title' => $this->title,
            'backgroundColor' => $this->backgroundColor,
            'cards' => $this->cards,
        ]);
    }
}
