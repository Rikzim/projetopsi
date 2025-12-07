<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;
use common\models\UserProfile;
use common\models\UploadForm;

/**
 * Update form
 */
class UpdateForm extends Model
{
    public $id;
    public $username;
    public $primeiro_nome;
    public $ultimo_nome;
    public $imagem_perfil;
    public $current_image;

    private $_user;
    private $_userProfile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['primeiro_nome', 'trim'],
            ['primeiro_nome', 'required'],
            ['primeiro_nome', 'string', 'max' => 255],

            ['ultimo_nome', 'trim'],
            ['ultimo_nome', 'required'],
            ['ultimo_nome', 'string', 'max' => 255],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => function($query) {
                $query->andWhere(['!=', 'id', $this->id]);
            }, 'message' => 'Este username já está a ser utilizado.'],

            [['imagem_perfil'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            ['current_image', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'primeiro_nome' => 'Primeiro Nome',
            'ultimo_nome' => 'Último Nome',
            'username' => 'Username',
            'imagem_perfil' => 'Imagem de Perfil',
        ];
    }

    /**
     * Get available roles
     * @return array
     */
    public static function getRoles()
    {
        return [
            'user' => 'Utilizador',
            'gestor' => 'Gestor',
            'admin' => 'Administrador',
        ];
    }

    /**
     * Load data from User and UserProfile
     */
    public function loadUser($id)
    {
        $this->_user = User::findOne($id);
        $this->_userProfile = UserProfile::findOne(['user_id' => $id]);

        if ($this->_user === null) {
            return false;
        }

        $this->id = $this->_user->id;
        $this->username = $this->_user->username;

        if ($this->_userProfile) {
            $this->primeiro_nome = $this->_userProfile->primeiro_nome;
            $this->ultimo_nome = $this->_userProfile->ultimo_nome;
            $this->current_image = $this->_userProfile->imagem_perfil;
            $this->imagem_perfil = $this->_userProfile->imagem_perfil;
        }

        return true;
    }

    /**
     * Updates user.
     *
     * @return bool
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }
        
        try {
            // Atualizar utilizador
            $this->_user->username = $this->username;
            
            if (!$this->_user->save()) {
                throw new \Exception('Erro ao atualizar utilizador: ' . json_encode($this->_user->errors));
            }


            // Atualizar ou criar perfil do utilizador
            if ($this->_userProfile === null) {
                $this->_userProfile = new UserProfile();
                $this->_userProfile->user_id = $this->_user->id;
            }

            $this->_userProfile->primeiro_nome = $this->primeiro_nome;
            $this->_userProfile->ultimo_nome = $this->ultimo_nome;
            $this->_userProfile->imagem_perfil = $this->imagem_perfil ?: $this->current_image;

            if (!$this->_userProfile->save()) {
                throw new \Exception('Erro ao atualizar perfil: ' . json_encode($this->_userProfile->errors));
            }
            return true;
            
        } catch (\Exception $e) {
            $this->addError('username', $e->getMessage());
            return false;
        }
    }

    public function getImage(){
        if (empty($this->imagem_perfil)) {
            return null;
        }

        return '/uploads/' . $this->imagem_perfil;
    }
}