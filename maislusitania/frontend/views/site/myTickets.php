<?php

/** @var yii\web\View $this */
/** @var array $reservas */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Meus Bilhetes';
$this->registerCssFile('@web/css/site/mytickets.css');
?>

<div class="my-tickets-page">
    <!-- Hero Section -->
    <div class="tickets-hero">
        <div class="hero-content">
            <h1 class="hero-title">Meus Bilhetes</h1>
            <p class="hero-subtitle">Gerencie todos os seus bilhetes de museus e monumentos</p>
        </div>
    </div>

    <div class="tickets-container">
        <?php 
        // Contar total de bilhetes individuais
        $totalBilhetes = 0;
        foreach ($reservas as $reserva) {
            foreach ($reserva->linhaReservas as $linha) {
                $totalBilhetes += $linha->quantidade;
            }
        }
        ?>
        
        <?php if ($totalBilhetes === 0): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">🎫</div>
                <h2>Ainda não tem bilhetes</h2>
                <p>Explore nossos museus e monumentos e comece sua jornada cultural!</p>
                <?= Html::a('Explorar Locais', ['/mapa/index'], ['class' => 'btn-explore']) ?>
            </div>
        <?php else: ?>
            <!-- Tickets Grid -->
            <div class="tickets-grid">
                <?php foreach ($reservas as $reserva): ?>
                    <?php
                    // Imagem do local
                    $imagemUrl = $reserva->local->imagem_principal 
                        ?? Yii::getAlias('@web/images/placeholder.jpg');
                    ?>
                    
                    <?php foreach ($reserva->linhaReservas as $linha): ?>
                        <?php for ($i = 1; $i <= $linha->quantidade; $i++): ?>
                            <div class="ticket-card <?= $reserva->estado ?>">
                                <!-- Ticket Header -->
                                <div class="ticket-header">
                                    <div class="ticket-logo"></div>
                                    <div class="ticket-status-badge <?= $reserva->estado ?>">
                                        <?= $reserva->estado ?>
                                    </div>
                                </div>

                                <!-- Ticket Body -->
                                <div class="ticket-body">
                                    <div class="ticket-main-info">
                                        <h3 class="ticket-local-name"><?= Html::encode($reserva->local->nome) ?></h3>
                                        <p class="ticket-type"><?= Html::encode($linha->tipoBilhete->nome) ?></p>
                                    </div>

                                    <div class="ticket-image-preview" style="background-image: url('<?= Html::encode($imagemUrl) ?>')"></div>

                                    <div class="ticket-info-grid">
                                        <div class="info-item">
                                            <span class="info-label">📅 Data</span>
                                            <span class="info-value"><?= Yii::$app->formatter->asDate($reserva->data_visita, 'dd/MM/yyyy') ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">🎫 Código</span>
                                            <span class="info-value">#<?= str_pad($reserva->id, 6, '0', STR_PAD_LEFT) ?>-<?= $i ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">👤 Tipo</span>
                                            <span class="info-value"><?= Html::encode($linha->tipoBilhete->nome) ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">💰 Preço</span>
                                            <span class="info-value"><?= Yii::$app->formatter->asCurrency($linha->tipoBilhete->preco, 'EUR') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ticket Footer -->
                                <div class="ticket-footer">
                                    <div class="ticket-barcode">
                                        <svg viewBox="0 0 200 40" xmlns="http://www.w3.org/2000/svg">
                                            <?php
                                            $barcodeId = $reserva->id . $i;
                                            $x = 0;
                                            for ($j = 0; $j < 40; $j++) {
                                                $width = (($barcodeId + $j) % 3) + 1;
                                                if ($j % 2 === 0) {
                                                    echo '<rect x="' . $x . '" y="0" width="' . $width . '" height="40" fill="#000"/>';
                                                }
                                                $x += $width + 1;
                                            }
                                            ?>
                                        </svg>
                                    </div>
                                    
                                    <div class="ticket-actions">
                                        <?php if ($reserva->estado === 'Confirmada'): ?>
                                            <?= Html::a(
                                                '<span>📥</span> Download', 
                                                ['/reserva/download-ticket', 'id' => $reserva->id, 'ticket' => $i], 
                                                ['class' => 'btn-ticket-action', 'target' => '_blank']
                                            ) ?>
                                        <?php endif; ?>
                                        
                                        <?= Html::a(
                                            '<span>ℹ️</span> Detalhes', 
                                            ['/reserva/view', 'id' => $reserva->id], 
                                            ['class' => 'btn-ticket-action secondary']
                                        ) ?>
                                    </div>
                                </div>

                                <!-- Perforation Effect -->
                                <div class="ticket-perforation"></div>
                            </div>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>