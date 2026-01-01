<?php

use yii\helpers\Html;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

/** @var $reserva */
/** @var $linha */
/** @var $ticketNumber */
/** @var $ticketCode */

// Generate QR Code
$qrCode = new QrCode(
    data: $ticketCode,
    size: 200,
    margin: 0
);
$writer = new SvgWriter();
$qrResult = $writer->write($qrCode);
$qrDataUri = $qrResult->getDataUri();
?>

<div class="ticket-pdf">
    <!-- Header -->
    <div class="ticket-header">
        <div class="logo">MAIS LUSITÂNIA</div>
        <div class="ticket-type-badge">BILHETE DE ENTRADA</div>
    </div>

    <!-- Main Content -->
    <div class="ticket-content">
        <h1 class="local-name"><?= Html::encode($reserva->local->nome) ?></h1>
        <p class="ticket-type"><?= Html::encode($linha->tipoBilhete->nome) ?></p>
        
        <div class="ticket-details">
            <div class="detail-row">
                <span class="detail-label">Data de Visita</span>
                <span class="detail-value"><?= Yii::$app->formatter->asDate($reserva->data_visita, 'dd/MM/yyyy') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Código do Bilhete</span>
                <span class="detail-value"><?= $ticketCode ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tipo de Bilhete</span>
                <span class="detail-value"><?= Html::encode($linha->tipoBilhete->nome) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Preço</span>
                <span class="detail-value"><?= $linha->tipoBilhete->getPrecoFormatado() ?></span>
            </div>
        </div>
    </div>

    <!-- QR Code Section -->
    <div class="qr-section">
        <img src="<?= $qrDataUri ?>" alt="QR Code" class="qr-code">
        <p class="qr-instruction">Apresente este código à entrada</p>
    </div>

    <!-- Footer -->
    <div class="ticket-footer">
        <p class="footer-text">Este bilhete é válido apenas para a data indicada.</p>
        <p class="footer-text">Mais Lusitânia - Descubra Portugal</p>
    </div>
</div>
