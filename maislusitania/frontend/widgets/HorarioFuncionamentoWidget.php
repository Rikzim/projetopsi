<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\Horario;

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

        // Buscar horários da base de dados
        if (empty($this->horarios) && $this->model !== null) {
            $this->horarios = $this->buscarHorarios();
        }
    }

    /**
     * Busca os horários da base de dados pela relação
     */
    private function buscarHorarios()
    {
        $horariosArray = [];
        
        // Busca os horários relacionados ao local
        $horarios = $this->model->horarios;
        
        if (empty($horarios)) {
            // Se não houver horários na BD, retorna mensagem
            return ['Mensagem' => 'Este local ainda não tem horários cadastrados'];
        }
        
        foreach ($horarios as $horario) {
            
            // Verifica qual dia da semana tem valor
            if (!empty($horario->segunda)) {
                $horariosArray['Segunda-Feira'] = $horario->segunda;
            }
            if (!empty($horario->terca)) {
                $horariosArray['Terça-Feira'] = $horario->terca;
            }
            if (!empty($horario->quarta)) {
                $horariosArray['Quarta-Feira'] = $horario->quarta;
            }
            if (!empty($horario->quinta)) {
                $horariosArray['Quinta-Feira'] = $horario->quinta;
            }
            if (!empty($horario->sexta)) {
                $horariosArray['Sexta-Feira'] = $horario->sexta;
            }
            if (!empty($horario->sabado)) {
                $horariosArray['Sábado'] = $horario->sabado;
            }
            if (!empty($horario->domingo)) {
                $horariosArray['Domingo'] = $horario->domingo;
            }
        }
        
        return $horariosArray;
    }


    public function run()
    {
        return $this->render('horario-funcionamento', [
            'horarios' => $this->horarios,
        ]);
    }
}