<?php
use frontend\widgets\LeafletMap;
use yii\helpers\Html;

//Isto é apenas um exemplo de como usar o widget LeafletMap para exibir um mapa com marcadores de locais culturais.
//TODO: Mostrar mapa de Portugal com marcadores de locais culturais relevantes.
?>

<div class="testemapa-index mt-n5">
    <div class="card shadow-lg">
        <div class="card-body p-0" style="border-radius: 15px; overflow: hidden;">
            <?= LeafletMap::widget([
                'mapId' => 'testMap',
                'lat' => 39.5,
                'lng' => -8.0,
                'zoom' => 7,
                'markers' => $markers,
            ]) ?>
        </div>
    </div>
</div>

<?php
$this->registerCss("
    .testemapa-index {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .testemapa-index h1 {
        margin-bottom: 2rem;
        text-align: center;
        color: #2E5AAC;
    }
    
    .card {
        border-radius: 15px;
        border: none;
    }
    
    .leaflet-map-container {
        height: 700px !important;
        width: 100% !important;
        border-radius: 15px;
    }
");
?>