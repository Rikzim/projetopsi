<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "noticia".
 *
 * @property int $id
 * @property string $titulo
 * @property string $conteudo
 * @property string|null $resumo
 * @property string|null $imagem
 * @property string|null $data_publicacao
 * @property int|null $visivel
 * @property int|null $local_id
 *
 * @property LocalCultural $local
 */
class Noticia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resumo', 'imagem', 'local_id'], 'default', 'value' => null],
            [['data_publicacao'], 'default', 'value' => 'now()'],
            [['visivel'], 'default', 'value' => 0],
            [['titulo', 'conteudo'], 'required'],
            [['conteudo'], 'string'],
            [['data_publicacao'], 'safe'],
            [['visivel', 'local_id'], 'integer'],
            [['titulo'], 'string', 'max' => 200],
            [['resumo'], 'string', 'max' => 500],
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
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'resumo' => 'Resumo',
            'imagem' => 'Imagem',
            'data_publicacao' => 'Data Publicacao',
            'visivel' => 'Visivel',
            'local_id' => 'Local ID',
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
