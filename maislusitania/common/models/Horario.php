<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property string|null $segunda
 * @property string|null $terca
 * @property string|null $quarta
 * @property string|null $quinta
 * @property string|null $sexta
 * @property string|null $sabado
 * @property string|null $domingo
 * @property int $id
 *
 * @property LocalCultural $localCultural
 */
class Horario extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'], 'default', 'value' => null],
            [['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'segunda' => 'Segunda',
            'terca' => 'Terca',
            'quarta' => 'Quarta',
            'quinta' => 'Quinta',
            'sexta' => 'Sexta',
            'sabado' => 'Sabado',
            'domingo' => 'Domingo',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[LocalCultural]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalCultural()
    {
        return $this->hasOne(LocalCultural::class, ['horario_id' => 'id']);
    }

}
