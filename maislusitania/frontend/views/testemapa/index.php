<?php
use frontend\widgets\LeafletMap;
use yii\helpers\Html;

$this->title = 'Mapa de Locais Culturais';
?>

<div class="testemapa-index mt-5">
    <h1 class="text-center mb-4" style="color: #2E5AAC;">
        <?= Html::encode('Mapa de Locais Culturais em Portugal') ?>
    </h1>
    
    <div class="card" style="border: 2px solid #2E5AAC; border-radius: 15px; max-width: 1200px; margin: 0 auto;">
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