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
 * @property float|null $preco
 * @property string|null $imagem
 * @property int|null $ativo
 *
 * @property LocalCultural $local
 */
class Evento extends \yii\db\ActiveRecord
{


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
            [['preco'], 'default', 'value' => '_utf8mb4\'0.00\''],
            [['ativo'], 'default', 'value' => 0],
            [['local_id', 'titulo', 'data_inicio'], 'required'],
            [['local_id', 'ativo'], 'integer'],
            [['descricao'], 'string'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['preco'], 'number'],
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
            'preco' => 'Preco',
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

}
