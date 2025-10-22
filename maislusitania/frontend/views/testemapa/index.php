<?php
use frontend\widgets\LeafletMap;
use yii\helpers\Html;

//Isto é apenas um exemplo de como usar o widget LeafletMap para exibir um mapa com marcadores de locais culturais.
//TODO: Mostrar mapa de Portugal com marcadores de locais culturais relevantes.

$this->title = 'Test Map';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="testemapa-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>This is a test page for the Leaflet map widget.</p>

    <?= LeafletMap::widget([
        'mapId' => 'testMap',
        'lat' => 38.7223,  // Lisbon
        'lng' => -9.1393,
        'zoom' => 13,
        'markers' => $markers,
    ]) ?>
</div>