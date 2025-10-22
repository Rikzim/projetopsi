<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class LeafletAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    ];
    
    public $js = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}