<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class HorarioFuncionamentoWidget extends Widget
{
    public $model;              // O modelo LocalCultural
    public $horarios = [];      // Array de horários personalizados (opcional)

    public function init()
    {
        parent::init();
        
        if ($this->model === null && empty($this->horarios)) {
            throw new \yii\base\InvalidConfigException('Defina "model" ou "horarios".');
        }

        // Se não foi passado horários customizados, tentar parsear do modelo
        if (empty($this->horarios) && $this->model !== null) {
            $this->horarios = $this->parseHorario($this->model->horario_funcionamento);
        }
    }

    /**
     * Parse do campo horario_funcionamento
     * Formato esperado: "Seg-Sex: 10:00-18:00, Sab: 10:00-14:00, Dom: Fechado"
     */
    private function parseHorario($horarioString)
    {
        // Por enquanto, retornar horários padrão
        // TODO: Implementar parse inteligente do string
        return [
            'Segunda-Feira' => '10:00 - 18:00',
            'Terça-Feira' => '10:00 - 18:00',
            'Quarta-Feira' => '10:00 - 18:00',
            'Quinta-Feira' => '10:00 - 18:00',
            'Sexta-Feira' => '10:00 - 18:00',
            'Sábado' => '10:00 - 18:00',
            'Domingo' => 'Fechado'
        ];
    }

    public function run()
    {
        return $this->render('horario-funcionamento', [
            'horarios' => $this->horarios,
        ]);
    }
}