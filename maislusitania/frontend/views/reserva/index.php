<?php
/** @var yii\web\View $this */
/** @var array $reservas */
/** @var array $reservasExpiradas */

use yii\helpers\Html;
use frontend\widgets\TicketCard;

$this->title = 'Meus Bilhetes';
$this->registerCssFile('@web/css/reservas/index.css');
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
        <?php if (empty($reservas) && empty($reservasExpiradas)): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <img src="<?= Yii::getAlias('@web/images/icons/blue/icon-ticket.svg') ?>" alt="Ticket Icon">
                </div>
                <h2>Ainda não tem bilhetes</h2>
                <p>Explore nossos museus e monumentos e comece sua jornada cultural!</p>
                <?= Html::a('Explorar Locais', ['/mapa/index'], ['class' => 'btn-explore']) ?>
            </div>
        <?php else: ?>
            
            <!-- Reservas Ativas -->
            <?php if (!empty($reservas)): ?>
                <div class="section-header">
                    <h2 class="section-title">Bilhetes Ativos</h2>
                    <p class="section-subtitle">Seus próximos bilhetes válidos para visitas</p>
                </div>
                
                <div class="tickets-grid">
                    <?php foreach ($reservas as $reserva): ?>
                        <?php foreach ($reserva->linhaReservas as $linha): ?>
                            <?php for ($i = 1; $i <= $linha->quantidade; $i++): ?>
                                <?= TicketCard::widget([
                                    'reserva' => $reserva,
                                    'linha' => $linha,
                                    'ticketNumber' => $i,
                                    'isExpirado' => false,
                                ]) ?>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Reservas Expiradas -->
            <?php if (!empty($reservasExpiradas)): ?>
                <div class="section-header expired-section">
                    <h2 class="section-title">Bilhetes Expirados</h2>
                    <p class="section-subtitle">Histórico de bilhetes com data de visita ultrapassada</p>
                </div>
                
                <div class="tickets-grid">
                    <?php foreach ($reservasExpiradas as $reserva): ?>
                        <?php foreach ($reserva->linhaReservas as $linha): ?>
                            <?php for ($i = 1; $i <= $linha->quantidade; $i++): ?>
                                <?= TicketCard::widget([
                                    'reserva' => $reserva,
                                    'linha' => $linha,
                                    'ticketNumber' => $i,
                                    'isExpirado' => true,
                                ]) ?>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>