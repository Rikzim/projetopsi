<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class TicketCard extends Widget
{
    public $reserva;
    public $linha;
    public $ticketNumber;
    public $isExpirado = false;

    public function run()
    {
        $imagemUrl = $this->reserva->local->imagem_principal 
            ?? Yii::getAlias('@web/images/placeholder.jpg');
        
        $estadoVisual = $this->isExpirado ? 'Expirado' : $this->reserva->estado;
        $cssClassEstado = strtolower($estadoVisual);

        return $this->render('ticket-card', [
            'reserva' => $this->reserva,
            'linha' => $this->linha,
            'ticketNumber' => $this->ticketNumber,
            'isExpirado' => $this->isExpirado,
            'imagemUrl' => $imagemUrl,
            'estadoVisual' => $estadoVisual,
            'cssClassEstado' => $cssClassEstado,
        ]);
    }
}