<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $primeiro_nome
 * @property string $ultimo_nome
 * @property string|null $imagem_perfil
 * @property int $user_id
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagem_perfil'], 'default', 'value' => null],
            [['primeiro_nome', 'ultimo_nome', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['primeiro_nome', 'ultimo_nome', 'imagem_perfil'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'primeiro_nome' => 'Primeiro Nome',
            'ultimo_nome' => 'Ultimo Nome',
            'imagem_perfil' => 'Imagem Perfil',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Obter a imagem atual do perfil do utilizador
     * @return string|null
     */
    public function getImage()
    {
        if (empty($this->imagem_perfil)) {
            return null;
        }

        return '/uploads/' . $this->imagem_perfil;
    }
}
