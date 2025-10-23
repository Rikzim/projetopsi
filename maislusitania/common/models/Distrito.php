<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "distrito".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $codigo
 *
 * @property LocalCultural[] $localCulturals
 */
class Distrito extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distrito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'default', 'value' => null],
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 50],
            [['codigo'], 'string', 'max' => 10],
            [['nome'], 'unique'],
            [['codigo'], 'unique'],
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
            'codigo' => 'Codigo',
        ];
    }

    /**
     * Gets query for [[LocalCulturals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalCulturals()
    {
        return $this->hasMany(LocalCultural::class, ['distrito_id' => 'id']);
    }

}
