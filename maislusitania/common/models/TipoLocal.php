<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipo_local".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 *
 * @property LocalCultural[] $localCulturals
 */
class TipoLocal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_local';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao'], 'required'],
            [['nome'], 'string', 'max' => 50],
            [['descricao'], 'string', 'max' => 255],
            [['nome'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[LocalCulturals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalCulturals()
    {
        return $this->hasMany(LocalCultural::class, ['tipo_id' => 'id']);
    }

}
