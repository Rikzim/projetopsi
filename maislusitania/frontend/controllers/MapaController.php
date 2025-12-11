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
                'type' => $local->tipoLocal->nome,
                'icone' => $local->tipoLocal->getImage()
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
            <div class="popup-image-container">
                <img src="{$imagemUrl}" alt="{$local->nome}" class="popup-image" />
                <span class="popup-badge">{$local->tipoLocal->nome}</span>
            </div>
            <div class="popup-content">
                <div class="popup-header">
                    <h3 class="popup-title">{$local->nome}</h3>
                    <p class="popup-subtitle">{$local->morada}</p>
                </div>
                <div class="popup-details">
                    <div class="info-item">
                        <span>{$local->contacto_telefone}</span>
                    </div>
                    <div class="info-item">
                        <span>{$local->contacto_email}</span>
                    </div>
                </div>
                <div class="popup-footer">
                    <a href="{$baseurl}/local-cultural/view?id={$local->id}" class="btn-details">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
        HTML;
    }
}