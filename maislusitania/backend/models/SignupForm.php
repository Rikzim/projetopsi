<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\UploadForm;
use common\models\User;
use common\models\UserProfile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $primeiro_nome;
    public $ultimo_nome;
    public $imagem_perfil;
    public $status = 10; // Ativo por padrão
    public $role = 'user'; // Role padrão

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
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este username já está a ser utilizado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já está registado.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'As passwords não coincidem.'],
            ['password_confirm', 'required'],

            [['imagem_perfil'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            
            ['status', 'in', 'range' => [0, 9, 10]],
            
            ['role', 'required'],
            ['role', 'in', 'range' => ['admin', 'gestor', 'user']],
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
            'password' => 'Password',
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
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        try {
            // Criar utilizador
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            
            if (!$user->save()) {
                throw new \Exception('Erro ao salvar utilizador');
            }

            // Atribuir role ao utilizador
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole($this->role);
            
            if ($userRole) {
                $auth->assign($userRole, $user->id);
            } else {
                throw new \Exception('Role não encontrada: ' . $this->role);
            }
            // Criar perfil do utilizador
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->primeiro_nome = $this->primeiro_nome;
            $userProfile->ultimo_nome = $this->ultimo_nome;
            $userProfile->imagem_perfil = $this->imagem_perfil;

            if (!$userProfile->save()) {
                throw new \Exception('Erro ao salvar perfil');
            }

            return $user;
            
        } catch (\Exception $e) {
            $this->addError('username', $e->getMessage());
            return null;
        }
    }
}