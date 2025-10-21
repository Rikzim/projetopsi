<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        // Criar role User
        $user = $auth->createRole('user');
        $user->description = 'Usuário comum - Não tem acesso ao backend';
        $auth->add($user);
        
        // Criar role Gestor
        $gestor = $auth->createRole('gestor');
        $gestor->description = 'Gestor - Tem acesso ao backend';
        $auth->add($gestor);
        
        // Criar role Admin
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrador - Tem acesso total';
        $auth->add($admin);
        
        // Hierarquia: Admin herda permissões de Gestor, Gestor herda de User
        $auth->addChild($gestor, $user);
        $auth->addChild($admin, $gestor);
        
        // Assign roles to users. 1 and 2 são IDs de exemplo
        // Substitua pelos IDs reais dos seus usuários
        // $auth->assign($user, 3);    // Usuário ID 3 = User
        // $auth->assign($gestor, 2);  // Usuário ID 2 = Gestor
        // $auth->assign($admin, 1);   // Usuário ID 1 = Admin
        
        echo "Roles criadas com sucesso!\n";
    }
}