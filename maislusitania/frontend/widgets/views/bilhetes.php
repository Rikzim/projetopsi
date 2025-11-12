<?php
/* @var $this yii\web\View */
/* @var $bilhetes array */
?>

<style>
    .bilhetes-card {
        background: white;
        border: 2px solid #4169E1;
        border-radius: 20px;
        padding: 25px;
        max-width: 900px;
        margin: 0 auto 30px;
    }

    .bilhetes-card-title {
        display: flex;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .bilhetes-card-icon {
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

    .ticket-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .ticket-row:last-child {
        border-bottom: none;
    }

    .ticket-info h4 {
        color: #4169E1;
        font-weight: bold;
        margin: 0 0 5px 0;
        font-size: 16px;
    }

    .ticket-info p {
        color: #666;
        font-size: 13px;
        margin: 0;
        line-height: 1.4;
    }

    .ticket-price {
        font-size: 24px;
        font-weight: bold;
        color: #4169E1;
        white-space: nowrap;
        margin-left: 20px;
    }

    @media (max-width: 768px) {
        .ticket-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .ticket-price {
            margin-left: 0;
            font-size: 20px;
        }
    }
</style>

<div class="bilhetes-card">
    <div class="bilhetes-card-title">
        <span class="bilhetes-card-icon">🎫</span>
        Bilhetes
    </div>

    <?php foreach ($bilhetes as $bilhete): ?>
        <div class="ticket-row">
            <div class="ticket-info">
                <h4><?= $bilhete['tipo'] ?></h4>
                <p><?= $bilhete['descricao'] ?></p>
            </div>
            <div class="ticket-price"><?= $bilhete['preco'] ?></div>
        </div>
    <?php endforeach; ?>
</div>