<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\LocalCultural;
use common\models\TipoLocal;

class MapaController extends Controller
{

    public function actionIndex()
    {
        $locais = LocalCultural::find()->all();
        $tipolocal = TipoLocal::find()->all();
        
        $markers = [];
        $types = [];
        foreach ($locais as $local) 
        {
            $markers[] = 
            [
                'lat' => (float)$local->latitude,
                'lng' => (float)$local->longitude,
                'popup' => $this->buildPopupHtml($local),
                'type' => $local->tipo->nome,
                'icone' => $local->tipo->getImage()
            ];
        }

        foreach ($tipolocal as $tipo) 
        {
            $types[] = 
            [
                'nome' => $tipo->nome,
                'icone' => $tipo->getImage()
            ];
        }
        
        return $this->render('index', [
            'markers' => $markers,
            'types' => $types,
        ]);
    }

    private function buildPopupHtml($local)
    {
        $baseurl = \yii\helpers\Url::base(true);
        $imagemUrl = $local->getImage();
        
        return <<<HTML
        <div class="custom-popup">
            <div class="popup-image">
                <img src="{$imagemUrl}" alt="{$local->nome}" style="max-width: 100%; height: auto;" />
                <span class="popup-badge">{$local->tipo->nome}</span>
            </div>
            <div class="popup-content">
                <h3 class="popup-title">{$local->nome}</h3>
                <div class="popup-info">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{$local->morada}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span>{$local->contacto_telefone}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>{$local->horario_funcionamento}</span>
                    </div>
                </div>
                <a href="{$baseurl}/local-cultural/view?id={$local->id}" class="btn-details">
                    Ver Detalhes
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        HTML;
    }
}