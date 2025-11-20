<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;
use common\models\UserProfile;

/**
 * Update form
 */
class UpdateForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $primeiro_nome;
    public $ultimo_nome;
    public $imagem_perfil;
    public $current_image;
    public $status;
    public $role;

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

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => function($query) {
                $query->andWhere(['!=', 'id', $this->id]);
            }, 'message' => 'Este email já está registado.'],

            ['password', 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'As passwords não coincidem.'],

            [['imagem_perfil'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            
            ['status', 'required'],
            ['status', 'in', 'range' => [0, 9, 10]],
            
            ['role', 'required'],
            ['role', 'in', 'range' => ['admin', 'gestor', 'user']],

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
            'email' => 'Email',
            'password' => 'Nova Password (deixe em branco para não alterar)',
            'password_confirm' => 'Confirmar Password',
            'imagem_perfil' => 'Imagem de Perfil',
            'status' => 'Status',
            'role' => 'Tipo de Utilizador',
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
        $this->email = $this->_user->email;
        $this->status = $this->_user->status;

        // Get current role
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->_user->id);
        if (!empty($roles)) {
            $this->role = array_keys($roles)[0];
        }

        if ($this->_userProfile) {
            $this->primeiro_nome = $this->_userProfile->primeiro_nome;
            $this->ultimo_nome = $this->_userProfile->ultimo_nome;
            $this->current_image = $this->_userProfile->imagem_perfil;
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
            $this->_user->email = $this->email;
            $this->_user->status = $this->status;
            
            // Atualizar password apenas se foi fornecida
            if (!empty($this->password)) {
                $this->_user->setPassword($this->password);
            }
            
            if (!$this->_user->save()) {
                throw new \Exception('Erro ao atualizar utilizador: ' . json_encode($this->_user->errors));
            }

            // Atualizar role
            $auth = Yii::$app->authManager;
            
            // Remover roles antigas
            $auth->revokeAll($this->_user->id);
            
            // Atribuir nova role
            $userRole = $auth->getRole($this->role);
            if ($userRole) {
                $auth->assign($userRole, $this->_user->id);
            } else {
                throw new \Exception('Role não encontrada: ' . $this->role);
            }

            // Upload da nova imagem
            $imageFile = UploadedFile::getInstance($this, 'imagem_perfil');
            $imageName = $this->current_image;
            
            if ($imageFile) {
                $uploadPath = Yii::getAlias('@backend/web/uploads/');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Deletar imagem antiga se existir
                if ($this->current_image && file_exists($uploadPath . $this->current_image)) {
                    unlink($uploadPath . $this->current_image);
                }
                
                $imageName = uniqid() . '_' . $imageFile->name;
                $filePath = $uploadPath . $imageName;
                
                if (!$imageFile->saveAs($filePath)) {
                    throw new \Exception('Erro ao fazer upload da imagem');
                }
            }

            // Atualizar ou criar perfil do utilizador
            if ($this->_userProfile === null) {
                $this->_userProfile = new UserProfile();
                $this->_userProfile->user_id = $this->_user->id;
            }

            $this->_userProfile->primeiro_nome = $this->primeiro_nome;
            $this->_userProfile->ultimo_nome = $this->ultimo_nome;
            $this->_userProfile->imagem_perfil = $imageName;

            if (!$this->_userProfile->save()) {
                throw new \Exception('Erro ao atualizar perfil: ' . json_encode($this->_userProfile->errors));
            }
            return true;
            
        } catch (\Exception $e) {
            $this->addError('username', $e->getMessage());
            return false;
        }
    }
}