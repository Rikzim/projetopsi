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
            height: 920px;
            width: 100%;
            display: block;
            margin: 0;
            border-radius: 30px;
            position: relative;
            z-index: 1 !important; /* Menor que navbar (que geralmente é 1000+) */
        }
        
        /* Garantir que o mapa não corta os controles */
        .leaflet-container {
            border-radius: 30px;
            overflow: hidden;
            z-index: 1 !important;
        }
        
        /* Controlar z-index dos elementos do Leaflet */
        .leaflet-pane {
            z-index: 400 !important;
        }
        
        .leaflet-tile-pane {
            z-index: 200 !important;
        }
        
        .leaflet-overlay-pane {
            z-index: 400 !important;
        }
        
        .leaflet-shadow-pane {
            z-index: 500 !important;
        }
        
        .leaflet-marker-pane {
            z-index: 600 !important;
        }
        
        .leaflet-tooltip-pane {
            z-index: 650 !important;
        }
        
        .leaflet-popup-pane {
            z-index: 700 !important;
        }
        
        /* Controles devem ficar abaixo da navbar */
        .leaflet-top,
        .leaflet-bottom {
            z-index: 400 !important; /* Menor que navbar */
        }
        
        .leaflet-control {
            z-index: 400 !important;
        }
        
        /* Estilizar os créditos para não sobrepor */
        .leaflet-control-attribution {
            background: rgba(255, 255, 255, 0.9) !important;
            padding: 4px 10px !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
            border-radius: 5px !important;
            margin: 0 10px 10px 0 !important;
            box-shadow: 0 1px 5px rgba(0,0,0,0.2) !important;
            z-index: 400 !important;
        }
        
        .leaflet-control-attribution a {
            color: #2E5AAC !important;
            text-decoration: none !important;
        }
        
        .leaflet-control-attribution a:hover {
            text-decoration: underline !important;
        }
        
        /* Ajustar controles de zoom */
        .leaflet-control-zoom {
            margin: 15px !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
            overflow: hidden !important;
            z-index: 400 !important;
        }
        
        .leaflet-control-zoom a {
            width: 36px !important;
            height: 36px !important;
            line-height: 36px !important;
            font-size: 22px !important;
            font-weight: bold !important;
            background: white !important;
            color: #2E5AAC !important;
            border: none !important;
            transition: all 0.2s ease !important;
        }
        
        .leaflet-control-zoom a:hover {
            background: #2E5AAC !important;
            color: white !important;
        }
        
        .leaflet-control-zoom a:first-child {
            border-bottom: 1px solid #e0e0e0 !important;
        }
        
        .leaflet-control-zoom-in {
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }
        
        .leaflet-control-zoom-out {
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
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
                maxZoom: 18,
                zoomControl: true,
                attributionControl: true
            }).setView([{$this->lat}, {$this->lng}], {$this->zoom});
            
            // Usar CartoDB Voyager (ruas + menos POIs)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                subdomains: 'abcd',
                maxZoom: 20,
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> © <a href="https://carto.com/attributions">CARTO</a>'
            }).addTo(map);
            
            // Array para armazenar os marcadores
            var allMarkers = [];
            
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
                
                // Adicionar o tipo como opção do marcador
                markerOptions.type = markerData.type;
                
                var marker = L.marker([markerData.lat, markerData.lng], markerOptions).addTo(map);
                if (markerData.popup) {
                    marker.bindPopup(markerData.popup);
                }
                
                // Armazenar referência do marcador
                allMarkers.push(marker);
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
            
            // Expor o mapa e marcadores globalmente
            if (!window.leafletMaps) {
                window.leafletMaps = {};
            }
            window.leafletMaps['{$this->mapId}'] = {
                map: map,
                markers: allMarkers
            };
        })();
        JS;     
        
        $this->view->registerJs($js);
        
        return Html::tag('div', '', ['id' => $this->mapId, 'class' => 'leaflet-map-container']);
    }
}