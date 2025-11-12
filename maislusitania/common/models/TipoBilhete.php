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
 * @property LinhaReserva $linhaReserva
 * @property LocalCultural $local
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
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'ativo' => 'Ativo',
            'local_id' => 'Local ID',
        ];
    }

    /**
     * Gets query for [[LinhaReserva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaReserva()
    {
        return $this->hasOne(LinhaReserva::class, ['tipo_bilhete_id' => 'id']);
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

}
