<?php
use frontend\widgets\LeafletMap;
use yii\helpers\Html;

$this->title = 'Mapa de Locais Culturais';
?>

<style>
    .mapa-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .mapa-header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .mapa-header h1 {
        color: #2E5AAC;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .mapa-header p {
        color: #2E5AAC;
        font-size: 1.1rem;
        font-weight: 400;
    }
    
    .mapa-content {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    
    .sidebar-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 250px;
        flex-shrink: 0;
    }
    
    .sidebar-left {
        background: #2E5AAC;
        border-radius: 20px;
        padding: 25px;
        color: white;
    }
    
    .search-box {
        margin-bottom: 25px;
    }
    
    .search-box h3 {
        color: white;
        font-size: 16px;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .search-box input {
        width: 100%;
        padding: 10px 15px;
        border-radius: 20px;
        border: none;
        font-size: 14px;
    }
    
    .filter-section {
        margin-bottom: 25px;
    }
    
    .filter-section h3 {
        color: white;
        font-size: 16px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .filter-option {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
    }
    
    .legendas-section {
        margin-bottom: 25px;
    }
    
    .legendas-section h3 {
        color: white;
        font-size: 16px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .legenda-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .legenda-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }
    
    .btn-criar-rota {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 30px;
        width: 100%;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }
    
    .map-wrapper {
        flex: 1;
        border: 2px solid #2E5AAC;
        border-radius: 30px;
        min-height: 835px;
        position: relative;
        overflow: hidden;
    }
    
    .instructions-box {
        background: #2E5AAC;
        border-radius: 30px;
        padding: 25px;
        color: white;
    }
    
    .instructions-box h3 {
        font-size: 18px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .instructions-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .instructions-box li {
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
        padding-left: 15px;
        position: relative;
    }
    
    .instructions-box li:before {
        content: "•";
        position: absolute;
        left: 0;
        font-weight: bold;
    }
</style>

<div class="mapa-container">
    <div class="mapa-header">
        <h1><?= Html::encode('Mapa de Locais Culturais em Portugal') ?></h1>
        <p>Explore museus, monumentos e património cultural em todo o país</p>
    </div>
    
    <div class="mapa-content">
        <!-- Container com ambas sidebars à esquerda -->
        <div class="sidebar-container">
            <!-- Sidebar Esquerda -->
            <div class="sidebar-left">
                <div class="search-box">
                    <h3>Pesquisar Locais</h3>
                    <input type="text" placeholder="🔍 Inserir localidade...">
                </div>
                
                <div class="filter-section">
                    <h3>Filtrar por Tipo</h3>
                    <div class="filter-option">
                        <input type="checkbox" id="museus" checked>
                        <label for="museus">Museus</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="monumentos" checked>
                        <label for="monumentos">Monumentos</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="patrimonio" checked>
                        <label for="patrimonio">Património</label>
                    </div>
                </div>
                
                <div class="legendas-section">
                    <h3>Legendas</h3>
                    <div class="legenda-item">
                        <span class="legenda-color" style="background: #FFC107;"></span>
                        <span>Museu</span>
                    </div>
                    <div class="legenda-item">
                        <span class="legenda-color" style="background: #4CAF50;"></span>
                        <span>Monumento</span>
                    </div>
                    <div class="legenda-item">
                        <span class="legenda-color" style="background: #2196F3;"></span>
                        <span>Património</span>
                    </div>
                </div>
            </div>
            
            <!-- Instruções -->
            <div class="instructions-box">
                <h3>Como Usar</h3>
                <ul>
                    <li>Clique nos marcadores para ver detalhes sobre cada local</li>
                    <li>Passe o rato por cima dos marcadores para ver o nome do local</li>
                    <li>Use os filtros e a pesquisa para encontrar apenas os tipos de locais que lhe interessam</li>
                    <li>Use a pesquisa para encontrar um local específico</li>
                </ul>
            </div>
        </div>
        
        <!-- Mapa -->
        <div class="map-wrapper">
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