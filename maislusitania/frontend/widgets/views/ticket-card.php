<?php

use yii\helpers\Html;

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
            <h3 class="ticket-local-name"><?= Html::encode($reserva->local->nome) ?></h3>
            <p class="ticket-type"><?= Html::encode($linha->tipoBilhete->nome) ?></p>
        </div>

        <div class="ticket-info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-calendar36.svg') ?>" alt="Calendar">
                </div>
                <div class="info-content">
                    <span class="info-label">Data de Visita</span>
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
                    <span class="info-label">Tipo de Bilhete</span>
                    <span class="info-value"><?= Html::encode($linha->tipoBilhete->nome) ?></span>
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
            <svg viewBox="0 0 100 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <rect x="0" y="0" width="2" height="40" fill="#000"/>
                <rect x="3" y="0" width="1" height="40" fill="#000"/>
                <rect x="5" y="0" width="3" height="40" fill="#000"/>
                <rect x="9" y="0" width="1" height="40" fill="#000"/>
                <rect x="11" y="0" width="2" height="40" fill="#000"/>
                <rect x="14" y="0" width="4" height="40" fill="#000"/>
                <rect x="19" y="0" width="1" height="40" fill="#000"/>
                <rect x="21" y="0" width="2" height="40" fill="#000"/>
                <rect x="24" y="0" width="1" height="40" fill="#000"/>
                <rect x="26" y="0" width="3" height="40" fill="#000"/>
                <rect x="30" y="0" width="2" height="40" fill="#000"/>
                <rect x="33" y="0" width="1" height="40" fill="#000"/>
                <rect x="35" y="0" width="4" height="40" fill="#000"/>
                <rect x="40" y="0" width="1" height="40" fill="#000"/>
                <rect x="42" y="0" width="2" height="40" fill="#000"/>
                <rect x="45" y="0" width="3" height="40" fill="#000"/>
                <rect x="49" y="0" width="1" height="40" fill="#000"/>
                <rect x="51" y="0" width="2" height="40" fill="#000"/>
                <rect x="54" y="0" width="1" height="40" fill="#000"/>
                <rect x="56" y="0" width="4" height="40" fill="#000"/>
                <rect x="61" y="0" width="2" height="40" fill="#000"/>
                <rect x="64" y="0" width="1" height="40" fill="#000"/>
                <rect x="66" y="0" width="3" height="40" fill="#000"/>
                <rect x="70" y="0" width="1" height="40" fill="#000"/>
                <rect x="72" y="0" width="2" height="40" fill="#000"/>
                <rect x="75" y="0" width="4" height="40" fill="#000"/>
                <rect x="80" y="0" width="1" height="40" fill="#000"/>
                <rect x="82" y="0" width="3" height="40" fill="#000"/>
                <rect x="86" y="0" width="2" height="40" fill="#000"/>
                <rect x="89" y="0" width="1" height="40" fill="#000"/>
                <rect x="91" y="0" width="2" height="40" fill="#000"/>
                <rect x="94" y="0" width="4" height="40" fill="#000"/>
                <rect x="99" y="0" width="1" height="40" fill="#000"/>
            </svg>
        </div>
        <?php endif; ?>
    </div>
</div>