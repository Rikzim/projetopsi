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
    public $markers = []; // Array: [['lat' => X, 'lng' => Y, 'popup' => 'Text', 'type' => 'castle|museum|monument']]

    //TODO: Adicionar opções para camadas, controles e estilos personalizados
    //TODO: Ao clicar no marcador, exibir informações detalhadas sobre o local cultural
    //TODO: Opção para abrir uma página dedicada ao local cultural
    
    public function init()
    {
        parent::init();
        LeafletAsset::register($this->view);
        
        $css = <<<CSS
        .leaflet-map-container {
            height: 600px;
            width: 100%;
            margin: 20px 0;
        }
        CSS;
        $this->view->registerCss($css);
    }

    public function run()
    {
        $markersJson = json_encode($this->markers);
        $baseUrl = Url::to('@web/images/markers/', true);
        
        $js = <<<JS
        (function() {
            var map = L.map('{$this->mapId}', {
                minZoom: 7,
                maxZoom: 18
            }).setView([{$this->lat}, {$this->lng}], {$this->zoom});
            
            // Usar CartoDB Voyager (ruas + menos POIs)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);
            
            // Define custom icons
            var castleIcon = L.icon({
                iconUrl: '{$baseUrl}marker_castelo.svg',
                iconSize: [48, 48],
                iconAnchor: [24, 48],
                popupAnchor: [0, -48]
            });
            
            var museumIcon = L.icon({
                iconUrl: '{$baseUrl}marker_museu.svg',
                iconSize: [48, 48],
                iconAnchor: [24, 48],
                popupAnchor: [0, -48]
            });
            
            var monumentIcon = L.icon({
                iconUrl: '{$baseUrl}marker_monumento.svg',
                iconSize: [48, 48],
                iconAnchor: [24, 48],
                popupAnchor: [0, -48]
            });
            
            var iconMap = {
                'castle': castleIcon,
                'museum': museumIcon,
                'monument': monumentIcon
            };
            
            var markers = {$markersJson};
            markers.forEach(function(markerData) {
                var icon = iconMap[markerData.type] || null;
                var markerOptions = icon ? { icon: icon } : {};
                
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
        })();
        JS;     
        
        $this->view->registerJs($js);
        
        return Html::tag('div', '', ['id' => $this->mapId, 'class' => 'leaflet-map-container']);
    }
}