<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LocalCultural $local */
/** @var array $bilhetes Array com os bilhetes selecionados */
/** @var float $precoTotal */

$this->title = 'Confirmar Reserva';
?>

<style>
    .confirmar-reserva-card {
        background: white;
        border: 2px solid #2E5AAC;
        border-radius: 20px;
        padding: 30px;
        max-width: 700px;
        margin: 30px auto;
    }

    .confirmar-titulo {
        color: #2E5AAC;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    .info-local {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .info-local h3 {
        color: #2E5AAC;
        margin: 0 0 5px 0;
        font-size: 18px;
    }

    .bilhetes-resumo {
        margin: 20px 0;
    }

    .bilhete-linha {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .bilhete-linha-total {
        border-bottom: none !important;
        border-top: 2px solid #2E5AAC;
        font-weight: bold;
        margin-top: 10px;
        padding-top: 15px;
    }

    .bilhete-info {
        flex: 1;
    }

    .bilhete-preco {
        color: #2E5AAC;
        font-weight: bold;
    }

    .botoes-acao {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 2px solid #2E5AAC;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .btn-cancelar,
    .btn-confirmar {
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
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancelar {
        background: #2E5AAC;
    }

    .btn-cancelar:hover {
        background: #1e3a6e;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(46, 90, 172, 0.3);
        color: white;
    }

    .btn-confirmar {
        background: #2E5AAC;
    }

    .btn-confirmar:hover {
        background: #1e3a6e;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(46, 90, 172, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .botoes-acao {
            flex-direction: column;
            gap: 15px;
        }

        .btn-cancelar,
        .btn-confirmar {
            width: 100%;
        }
    }
</style>

<div class="confirmar-reserva-card">
    <h1 class="confirmar-titulo">Confirmar Reserva</h1>

    <!-- Informação do Local -->
    <div class="info-local">
        <h3><?= Html::encode($local->nome) ?></h3>
        <p style="margin: 0; color: #666;">
            <?= Html::encode($local->morada) ?>
        </p>
    </div>

    <!-- Resumo dos Bilhetes -->
    <div class="bilhetes-resumo">
        <h4 style="color: #2E5AAC; margin-bottom: 15px;">Bilhetes Selecionados:</h4>

        <?php foreach ($bilhetes as $bilhete): ?>
            <?php
            // Calcular subtotal
            $subtotal = $bilhete['quantidade'] * $bilhete['preco_unitario'];
            ?>
            <div class="bilhete-linha">
                <div class="bilhete-info">
                    <strong><?= Html::encode($bilhete['tipo']) ?></strong>
                    <span style="color: #666;"> x<?= $bilhete['quantidade'] ?></span>
                    <span style="color: #999; font-size: 12px;">
                        (<?= number_format($bilhete['preco_unitario'], 2, ',', '') ?>€ cada)
                    </span>
                </div>
                <div class="bilhete-preco">
                    <?= number_format($subtotal, 2, ',', '') ?>€
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Linha do Total -->
        <div class="bilhete-linha">
            <div class="bilhete-info">TOTAL</div>
            <div class="bilhete-preco" style="font-size: 20px;">
                <?= number_format($precoTotal, 2, ',', '') ?>€
            </div>
        </div>
    </div>

    <!-- Formulário de Confirmação -->
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['reserva/create'],
        'method' => 'post',
    ]); ?>

    <!-- Campo hidden que indica confirmação -->
    <?= Html::hiddenInput('confirmar', '1') ?>

    <!-- Dados do local -->
    <?= Html::hiddenInput('local_id', $local->id) ?>

    <!-- Dados dos bilhetes -->
    <?php foreach ($bilhetes as $bilhete): ?>
        <?= Html::hiddenInput("bilhetes[{$bilhete['tipo_bilhete_id']}][quantidade]", $bilhete['quantidade']) ?>
        <?= Html::hiddenInput("bilhetes[{$bilhete['tipo_bilhete_id']}][tipo_bilhete_id]", $bilhete['tipo_bilhete_id']) ?>
    <?php endforeach; ?>

    <!-- Selecionar data visita -->
    <div class="info-local" style="margin-top: 20px;">
        <h4 style="color: #2E5AAC; margin: 0 0 10px 0;">Data da Visita:</h4>
        <?= Html::input('date', 'data_visita', '', [
            'id' => 'data-visita',
            'required' => true,
            'min' => date('Y-m-d', strtotime('+1 day')),
            'style' => 'width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;'
        ]) ?>
    </div>

    <!-- Botões de Ação -->
    <div class="botoes-acao">
        <?= Html::a('Cancelar', ['local-cultural/view', 'id' => $local->id], ['class' => 'btn-cancelar']) ?>
        <?= Html::submitButton('✓ Confirmar Reserva', ['class' => 'btn-confirmar']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>