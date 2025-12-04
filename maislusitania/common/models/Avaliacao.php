<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacao".
 *
 * @property int $id
 * @property int $local_id
 * @property int $utilizador_id
 * @property int $classificacao
 * @property string|null $comentario
 * @property string $data_avaliacao
 * @property int $ativo
 *
 * @property LocalCultural $local
 * @property User $utilizador
 */
class Avaliacao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comentario'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 1],
            [['local_id', 'utilizador_id', 'classificacao'], 'required'],
            [['local_id', 'utilizador_id', 'classificacao', 'ativo'], 'integer'],
            [['comentario'], 'string'],
            [['data_avaliacao'], 'safe'],
            [['local_id', 'utilizador_id'], 'unique', 'targetAttribute' => ['local_id', 'utilizador_id']],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocalCultural::class, 'targetAttribute' => ['local_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'local_id' => 'Local ID',
            'utilizador_id' => 'Utilizador ID',
            'classificacao' => 'Classificacao',
            'comentario' => 'Comentario',
            'data_avaliacao' => 'Data Avaliacao',
            'ativo' => 'Ativo',
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
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

}
