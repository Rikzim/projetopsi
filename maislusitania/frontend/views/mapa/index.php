<?php
use frontend\widgets\LeafletMap;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'Mapa de Locais Culturais';
$this->registerCssFile('@web/css/mapa/index.css');
?>

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
                    <input class="search-input" id="searchInput" type="text" placeholder="Inserir localidade...">
                </div>
                
                <div class="filter-section">
                    <h3>Filtrar por Tipo</h3>
                    <!-- TODO: Ao ter mais de 4 tipos, por um dropdown -->
                    <?php foreach ($types as $type): ?>
                        <div class="filter-option">
                            <input type="checkbox" class="type-filter" id="filter-<?= Html::encode(strtolower(str_replace(' ', '-', $type['nome']))) ?>" data-type="<?= Html::encode($type['nome']) ?>" checked>
                            <label for="filter-<?= Html::encode(strtolower(str_replace(' ', '-', $type['nome']))) ?>"><?= Html::encode($type['nome']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="legendas-section">
                    <h3>Legendas</h3>
                    <?php foreach ($types as $type): ?>
                        <div class="legenda-item">
                        <img class="legenda-icon" src="<?= Html::encode($type['icone']) ?>" alt="">
                            <span class="legenda-nome"><?= Html::encode($type['nome']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Instruções -->
            <div class="instructions-box">
                <i class="fas fa-info-circle"></i>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Esperar o mapa carregar
        setTimeout(function() {
            if (!window.leafletMaps || !window.leafletMaps['testMap']) {
                console.error('Mapa não encontrado');
                return;
            }
            
            const mapObj = window.leafletMaps['testMap'];
            const map = mapObj.map;
            const allMarkers = mapObj.markers;
           
            // Filtragem por Tipo
            const typeCheckboxes = document.querySelectorAll('.type-filter');
            
            function filterMarkers() {
                const selectedTypes = Array.from(typeCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-type'));
                
                const query = document.getElementById('searchInput').value.toLowerCase();
                
                allMarkers.forEach(marker => {
                    const typeMatch = selectedTypes.includes(marker.options.type);
                    const popupContent = marker.getPopup() ? marker.getPopup().getContent().toLowerCase() : '';
                    const searchMatch = query === '' || popupContent.includes(query);
                    
                    if (typeMatch && searchMatch) {
                        map.addLayer(marker);
                    } else {
                        map.removeLayer(marker);
                    }
                });
            }
            
            typeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', filterMarkers);
            });
            
            // Pesquisa por Localidade
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', filterMarkers);
            
        }, 1000); // Esperar 1 segundo para garantir que o mapa carregou
    });
</script>