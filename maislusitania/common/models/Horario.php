<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property int $local_id
 * @property string|null $segunda
 * @property string|null $terca
 * @property string|null $quarta
 * @property string|null $quinta
 * @property string|null $sexta
 * @property string|null $sabado
 * @property string|null $domingo
 * @property int $id
 *
 * @property LocalCultural $local
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
            [['local_id'], 'required'],
            [['local_id'], 'integer'],
            [['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'], 'string', 'max' => 100],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocalCultural::class, 'targetAttribute' => ['local_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'local_id' => 'Local ID',
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
     * Gets query for [[Local]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(LocalCultural::class, ['id' => 'local_id']);
    }

}
