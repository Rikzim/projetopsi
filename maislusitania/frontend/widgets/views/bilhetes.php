<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $bilhetes array */
/* @var $model common\models\LocalCultural */
/* @var $showComprar boolean */
/* @var $maxQuantidade integer */
?>

<style>
    .bilhetes-card {
        background: white;
        border: 2px solid #2E5AAC;
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
        background: #2E5AAC;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
        font-size: 18px;
    }

    .bilhetes-card-icon img {
        width: 18px;
        height: 18px;
    }

    .ticket-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .ticket-row:last-child {
        border-bottom: none;
    }

    .ticket-info {
        flex: 1;
        min-width: 0;
    }

    .ticket-info h4 {
        color: #2E5AAC;
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
        color: #2E5AAC;
        white-space: nowrap;
        min-width: 100px;
        text-align: right;
    }

    .quantity-input {
        width: 80px;
        padding: 8px;
        text-align: center;
        border: 2px solid #2E5AAC;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #1e3a6e;
    }

    .comprar-section {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 2px solid #2E5AAC;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .btn-comprar-global {
        background: #2E5AAC;
        color: white;
        padding: 15px 40px;
        border-radius: 25px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-comprar-global:hover {
        background: #1e3a6e;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(46, 90, 172, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .ticket-row {
            flex-wrap: wrap;
        }

        .ticket-price {
            order: 2;
            font-size: 20px;
        }

        .quantity-input {
            order: 3;
            margin-top: 10px;
        }

        .comprar-section {
            flex-direction: column;
            gap: 15px;
        }

        .btn-comprar-global {
            width: 100%;
        }
    }
</style>

<div class="bilhetes-card">
    <div class="bilhetes-card-title">
        <span class="bilhetes-card-icon">
            <img src="<?= Url::to('@web/images/icons/icon-bilhete.svg') ?>" alt="Bilhetes">
        </span>
        Bilhetes
    </div>

    <?php if (empty($bilhetes)): ?>
        <p style="text-align: center; color: #666; padding: 20px;">
            Nenhum bilhete disponível no momento.
        </p>
    <?php else: ?>
        
        <?php $form = ActiveForm::begin([
            'action' => ['reserva/create'],
            'method' => 'post',
        ]); ?>

            <!-- Campo oculto com o local_id -->
            <?= Html::hiddenInput('local_id', $model->id) ?>

            <?php foreach ($bilhetes as $index => $bilhete): ?>
                <div class="ticket-row">
                    <div class="ticket-info">
                        <h4><?= Html::encode($bilhete['tipo']) ?></h4>
                        <p><?= Html::encode($bilhete['descricao']) ?></p>
                    </div>
                    
                    <div class="ticket-price">
                        <?= Html::encode($bilhete['preco']) ?>
                    </div>

                    <?php if (isset($showComprar) && $showComprar): ?>
                        <!-- Input de Quantidade -->
                        <?= Html::input('number', 
                            'bilhetes[' . $bilhete['id'] . '][quantidade]', 
                            0, 
                            [
                                'class' => 'quantity-input',
                                'min' => 0,
                                'max' => $maxQuantidade,
                            ]
                        ) ?>
                        
                        <!-- Campos ocultos com informações do bilhete -->
                        <?= Html::hiddenInput('bilhetes[' . $bilhete['id'] . '][tipo_bilhete_id]', $bilhete['id']) ?>
                        <?= Html::hiddenInput('bilhetes[' . $bilhete['id'] . '][preco]', $bilhete['preco_valor']) ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <!-- Seção de Compra -->
            <?php if (isset($showComprar) && $showComprar): ?>
                <div class="comprar-section">
                    <?= Html::submitButton('Comprar Bilhetes', [
                        'class' => 'btn-comprar-global',
                        'id' => 'btn-comprar-global',
                    ]) ?>
                </div>
            <?php endif; ?>

        <?php ActiveForm::end(); ?>

    <?php endif; ?>
</div>