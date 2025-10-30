<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_reserva".
 *
 * @property int $id
 * @property int $reserva_id
 * @property int $quantidade
 * @property int $tipo_bilhete_id
 *
 * @property Reserva $reserva
 * @property TipoBilhete $tipoBilhete
 */
class LinhaReserva extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'quantidade', 'tipo_bilhete_id'], 'required'],
            [['reserva_id', 'quantidade', 'tipo_bilhete_id'], 'integer'],
            [['tipo_bilhete_id'], 'unique'],
            [['reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reserva::class, 'targetAttribute' => ['reserva_id' => 'id']],
            [['tipo_bilhete_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoBilhete::class, 'targetAttribute' => ['tipo_bilhete_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reserva_id' => 'Reserva ID',
            'quantidade' => 'Quantidade',
            'tipo_bilhete_id' => 'Tipo Bilhete ID',
        ];
    }

    /**
     * Gets query for [[Reserva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReserva()
    {
        return $this->hasOne(Reserva::class, ['id' => 'reserva_id']);
    }

    /**
     * Gets query for [[TipoBilhete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoBilhete()
    {
        return $this->hasOne(TipoBilhete::class, ['id' => 'tipo_bilhete_id']);
    }

}
