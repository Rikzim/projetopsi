<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\assets\LeafletAsset;

class LeafletMap extends Widget
{
    public $mapId = 'map';
    public $lat = 51.505;
    public $lng = -0.09;
    public $zoom = 13;
    public $markers = []; //Array de marcadores, aqui é onde vai receber e exibir os locais culturais

    //TODO: Adicionar opções para camadas, controles e estilos personalizados
    //TODO: Ao clicar no marcador, exibir informações detalhadas sobre o local cultural
    //TODO: Opção para abrir uma página dedicada ao local cultural

    public function init()
    {
        parent::init();
        LeafletAsset::register($this->view);
        
        // Register inline CSS
        $css = <<<CSS
        .leaflet-map-container {
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
        CSS;
        $this->view->registerCss($css);
    }

    public function run()
    {
        $markersJson = json_encode($this->markers);
        
        $js = <<<JS
        (function() {
            var map = L.map('{$this->mapId}').setView([{$this->lat}, {$this->lng}], {$this->zoom});
            
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            
            var markers = {$markersJson};
            markers.forEach(function(markerData) {
                var marker = L.marker([markerData.lat, markerData.lng]).addTo(map);
                if (markerData.popup) {
                    marker.bindPopup(markerData.popup);
                }
            });
        })();
        JS;
        
        $this->view->registerJs($js);
        
        return Html::tag('div', '', ['id' => $this->mapId, 'class' => 'leaflet-map-container']);
    }
}