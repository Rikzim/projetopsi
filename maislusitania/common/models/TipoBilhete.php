<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipo_bilhete".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $preco
 * @property int $ativo
 * @property int $local_id
 *
 * @property LocalCultural $local
 * @property LinhaReserva[] $linhaReservas
 */
class TipoBilhete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_bilhete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'preco', 'ativo', 'local_id'], 'required'],
            [['preco'], 'number'],
            [['ativo', 'local_id'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['descricao'], 'string', 'max' => 255],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocalCultural::class, 'targetAttribute' => ['local_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'preco' => 'Preço',
            'ativo' => 'Ativo',
            'local_id' => 'Local Cultural',
        ];
    }

    /**
     * Gets query for [[Local]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }

    /**
     * Gets query for [[LinhaReservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaReservas()
    {
        return $this->hasMany(LinhaReserva::class, ['tipo_bilhete_id' => 'id']);
    }

    /**
     * Verifica se o bilhete é gratuito
     * @return bool
     */
    public function isGratuito()
    {
        return floatval($this->preco) == 0;
    }

    /**
     * Retorna o preço formatado com símbolo de euro
     * @return string
     */
    public function getPrecoFormatado()
    {
        if ($this->isGratuito()) {
            return 'Grátis';
        }

        // Formatar: 10.00 => 10,00€
        return number_format($this->preco, 2, ',', '') . '€';
    }

    //Metodos adicionados

    //Retorna uma lista de bilhetes formatados para um local cultural específico
    public static function getBilhetesFormatados($localId)
    {
        $bilhetes = self::find()
            ->where(['local_id' => $localId, 'ativo' => 1])
            ->orderBy(['preco' => SORT_DESC])
            ->all();

        $resultado = [];
        foreach ($bilhetes as $bilhete) {
            $preco = floatval($bilhete->preco);
            $gratuito = ($preco == 0);

            $resultado[] = [
                'id' => $bilhete->id,
                'tipo' => $bilhete->nome,
                'descricao' => $bilhete->descricao,
                'preco' => $gratuito ? 'Grátis' : number_format($preco, 2, ',', '') . '€',
                'preco_valor' => $preco,
                'gratuito' => $gratuito,
            ];
        }

        return $resultado;
    }
}
