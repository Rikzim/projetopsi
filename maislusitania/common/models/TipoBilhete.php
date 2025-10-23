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
 * @property LinhaReserva $id0
 * @property LocalCultural $localCultural
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
            [['local_id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => LinhaReserva::class, 'targetAttribute' => ['id' => 'tipo_bilhete_id']],
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
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(LinhaReserva::class, ['tipo_bilhete_id' => 'id']);
    }

    /**
     * Gets query for [[LocalCultural]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalCultural()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }

}
