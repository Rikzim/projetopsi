<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id
 * @property int $local_id
 * @property string $titulo
 * @property string|null $descricao
 * @property string $data_inicio
 * @property string|null $data_fim
 * @property string|null $imagem
 * @property int $ativo
 *
 * @property LocalCultural $local
 */
class Evento extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'data_fim', 'imagem'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 1],
            [['local_id', 'titulo', 'data_inicio'], 'required'],
            [['local_id', 'ativo'], 'integer'],
            [['descricao'], 'string'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['titulo'], 'string', 'max' => 200],
            [['imagem'], 'string', 'max' => 255],
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
            'local_id' => 'Local ID',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'imagem' => 'Imagem',
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

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }


    /**
     * Obter a imagem atual do evento
     * @return string|null
     */
    public function getCurrentImage()
    {
        return $this->imagem;
    }
}
