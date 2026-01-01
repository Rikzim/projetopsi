<?php

use yii\helpers\Html;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

/** @var $reserva */
/** @var $linha */
/** @var $ticketNumber */
/** @var $isExpirado */
/** @var $imagemUrl */
/** @var $estadoVisual */
/** @var $cssClassEstado */
?>

<div class="ticket-card <?= $cssClassEstado ?>">
    <!-- Ticket Header -->
    <div class="ticket-header">
        <div class="ticket-logo">
            <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-ticket.svg') ?>" alt="Ticket">
        </div>
        <div class="ticket-status-badge <?= $cssClassEstado ?>">
            <?= $estadoVisual ?>
        </div>
    </div>

    <!-- Ticket Body -->
    <div class="ticket-body">
        <div class="ticket-main-info">
            <h3 class="ticket-local-name" title="<?= Html::encode($reserva->local->nome) ?>"><?= Html::encode($reserva->local->nome) ?></h3>
            <p class="ticket-type" title="<?= Html::encode($linha->tipoBilhete->nome) ?>"><?= Html::encode($linha->tipoBilhete->nome) ?></p>
        </div>

        <div class="ticket-info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-calendar36.svg') ?>" alt="Calendar">
                </div>
                <div class="info-content">
                    <span class="info-label">Data</span>
                    <span class="info-value"><?= Yii::$app->formatter->asDate($reserva->data_visita, 'dd/MM/yyyy') ?></span>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-ticket.svg') ?>" alt="Ticket">
                </div>
                <div class="info-content">
                    <span class="info-label">Código</span>
                    <span class="info-value">#<?= str_pad($reserva->id, 6, '0', STR_PAD_LEFT) ?>-<?= $ticketNumber ?></span>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-profile.svg') ?>" alt="User">
                </div>
                <div class="info-content">
                    <span class="info-label">Tipo</span>
                    <span class="info-value" title="<?= Html::encode($linha->tipoBilhete->nome) ?>"><?= Html::encode($linha->tipoBilhete->nome) ?></span>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-euro.svg') ?>" alt="Price">
                </div>
                <div class="info-content">
                    <span class="info-label">Preço</span>
                    <span class="info-value"><?= $linha->tipoBilhete->getPrecoFormatado() ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Footer -->
    <div class="ticket-footer">
        <?php if (!$isExpirado && $reserva->estado === 'Confirmada'): ?>
        <div class="ticket-barcode">
            <?php
                // Construct the code string to match the visual display format
                $ticketCode = '#' . str_pad($reserva->id, 6, '0', STR_PAD_LEFT) . '-' . $ticketNumber;

                // Use named arguments to set properties directly in the constructor
                $qrCode = new QrCode(
                    data: $ticketCode,
                    size: 150,
                    margin: 0
                );

                $writer = new PngWriter();
                $qrResult = $writer->write($qrCode);
            ?>
            <img src="<?= $qrResult->getDataUri() ?>" alt="QR Code" style="display: block; margin: 0 auto;">
        </div>
        <div class="ticket-actions">
            <?= Html::a(
                'Download PDF',
                ['reserva/download-ticket', 'id' => $reserva->id, 'linha_id' => $linha->id, 'ticket' => $ticketNumber],
                ['class' => 'btn-ticket-action primary', 'target' => '_blank']
            ) ?>
        </div>
        <?php endif; ?>
    </div>
</div>