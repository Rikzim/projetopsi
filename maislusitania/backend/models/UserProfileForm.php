<?php

namespace backend\models;

use common\models\UserProfile;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UserProfileForm extends Model
{
    public $primeiro_nome;
    public $ultimo_nome;
    public $imagem_perfil;
    public $user_id;
    
    private $_userProfile;

    public function __construct($userProfile = null, $config = [])
    {
        if ($userProfile instanceof UserProfile) {
            $this->_userProfile = $userProfile;
            $this->primeiro_nome = $userProfile->primeiro_nome;
            $this->ultimo_nome = $userProfile->ultimo_nome;
            $this->user_id = $userProfile->user_id;
        } else {
            $this->_userProfile = new UserProfile();
        }
        
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['primeiro_nome', 'ultimo_nome'], 'required'],
            [['user_id'], 'integer'],
            [['primeiro_nome', 'ultimo_nome'], 'string', 'max' => 255],
            [['imagem_perfil'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'primeiro_nome' => 'Primeiro Nome',
            'ultimo_nome' => 'Último Nome',
            'user_id' => 'Utilizador',
            'imagem_perfil' => 'Foto de Perfil',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_userProfile->primeiro_nome = $this->primeiro_nome;
        $this->_userProfile->ultimo_nome = $this->ultimo_nome;
        $this->_userProfile->user_id = $this->user_id;

        // Handle image upload
        if ($this->imageFile instanceof UploadedFile) {
            $uploadPath = Yii::getAlias('@backend/web/uploads/profiles/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old image if exists
            if (!empty($this->_userProfile->imagem_perfil)) {
                $oldImagePath = $uploadPath . $this->_userProfile->imagem_perfil;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $fileName = 'profile_' . uniqid() . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->_userProfile->imagem_perfil = $fileName;
            }
        }

        return $this->_userProfile->save(false);
    }

    public function getUserProfile()
    {
        return $this->_userProfile;
    }

    public function getCurrentImage()
    {
        return $this->_userProfile->imagem_perfil;
    }

    public function getId()
    {
        return $this->_userProfile->id;
    }

    public function getIsNewRecord()
    {
        return $this->_userProfile->isNewRecord;
    }
}