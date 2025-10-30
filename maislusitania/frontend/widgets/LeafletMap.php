<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LeafletAsset;

class LeafletMap extends Widget
{
    public $mapId = 'map';
    public $lat = 51.505;
    public $lng = -0.09;
    public $zoom = 13;
    public $markers = []; // Array: [['lat' => X, 'lng' => Y, 'popup' => 'Text', 'icone' => 'URL']]

    //TODO: Adicionar opções para camadas, controles e estilos personalizados
    //TODO: Ao clicar no marcador, exibir informações detalhadas sobre o local cultural
    //TODO: Opção para abrir uma página dedicada ao local cultural
    
    public function init()
    {
        parent::init();
        LeafletAsset::register($this->view);
        
        $css = <<<CSS
        .leaflet-map-container {
            height: 835px;
            width: 100%;
            display: block;
            margin: 0;
            border-radius: 30px;
        }
        
        /* Esconder o link "Leaflet"  se não ele sobrepõe*/
        .leaflet-control-attribution {
            display: none !important;
        }
        CSS;
        $this->view->registerCss($css);
    }

    public function run()
    {
        $markersJson = json_encode($this->markers);
        
        $js = <<<JS
        (function() {
            var map = L.map('{$this->mapId}', {
                minZoom: 7,
                maxZoom: 18
            }).setView([{$this->lat}, {$this->lng}], {$this->zoom});
            
            // Usar CartoDB Voyager (ruas + menos POIs)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);
            
            var markers = {$markersJson};
            markers.forEach(function(markerData) {
                var markerOptions = {};
                
                // Se tiver URL do ícone, criar ícone personalizado
                if (markerData.icone) {
                    var customIcon = L.icon({
                        iconUrl: markerData.icone,
                        iconSize: [48, 48],
                        iconAnchor: [24, 48],
                        popupAnchor: [0, -48]
                    });
                    markerOptions.icon = customIcon;
                }
                
                var marker = L.marker([markerData.lat, markerData.lng], markerOptions).addTo(map);
                if (markerData.popup) {
                    marker.bindPopup(markerData.popup);
                }
            });
            
            // Limitar zoom a Portugal
            var southWest = L.latLng(36.5, -10.0);
            var northEast = L.latLng(42.5, -6.0);
            var bounds = L.latLngBounds(southWest, northEast);
            map.setMaxBounds(bounds);
            
            // Force map to resize after load
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        })();
        JS;     
        
        $this->view->registerJs($js);
        
        return Html::tag('div', '', ['id' => $this->mapId, 'class' => 'leaflet-map-container']);
    }
}