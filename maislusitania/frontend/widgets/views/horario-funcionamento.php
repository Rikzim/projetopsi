<?php
/* @var $this yii\web\View */
/* @var $horarios array */
?>

<style>
    .horario-card {
        background: white;
        border: 2px solid #4169E1;
        border-radius: 20px;
        padding: 25px;
    }

    .horario-card-title {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .horario-card-icon {
        width: 32px;
        height: 32px;
        background: #4169E1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
        font-size: 18px;
    }

    .schedule-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #4169E1;
    }

    .schedule-row:last-child {
        border-bottom: none;
    }

    .schedule-day {
        font-weight: 500;
    }

    .schedule-hours {
        color: #666;
    }

    .schedule-hours.fechado {
        color: #999;
        font-style: italic;
    }
</style>

<div class="horario-card">
    <div class="horario-card-title">
        <span class="horario-card-icon">🕐</span>
        Horário de Funcionamento
    </div>
    
    <?php foreach ($horarios as $dia => $horario): ?>
        <div class="schedule-row">
            <span class="schedule-day"><?= $dia ?></span>
            <span class="schedule-hours <?= strtolower($horario) === 'fechado' ? 'fechado' : '' ?>">
                <?= $horario ?>
            </span>
        </div>
    <?php endforeach; ?>
</div>