<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        // ============ CRIAR PERMISSÕES ============
        
        // Permissões de Museus
        $addMuseum = $auth->createPermission('addMuseum');
        $addMuseum->description = 'Adicionar museus';
        $auth->add($addMuseum);
        
        $editMuseum = $auth->createPermission('editMuseum');
        $editMuseum->description = 'Editar museus';
        $auth->add($editMuseum);
        
        $deleteMuseum = $auth->createPermission('deleteMuseum');
        $deleteMuseum->description = 'Eliminar museus';
        $auth->add($deleteMuseum);
        
        // Permissões de Monumentos
        $addMonument = $auth->createPermission('addMonument');
        $addMonument->description = 'Adicionar monumentos';
        $auth->add($addMonument);
        
        $editMonument = $auth->createPermission('editMonument');
        $editMonument->description = 'Editar monumentos';
        $auth->add($editMonument);
        
        $deleteMonument = $auth->createPermission('deleteMonument');
        $deleteMonument->description = 'Eliminar monumentos';
        $auth->add($deleteMonument);
        
        // Permissões de Eventos
        $addEvent = $auth->createPermission('addEvent');
        $addEvent->description = 'Adicionar eventos';
        $auth->add($addEvent);
        
        $editEvent = $auth->createPermission('editEvent');
        $editEvent->description = 'Editar eventos';
        $auth->add($editEvent);
        
        $deleteEvent = $auth->createPermission('deleteEvent');
        $deleteEvent->description = 'Eliminar eventos';
        $auth->add($deleteEvent);
        
        // Permissões de Notícias
        $addNews = $auth->createPermission('addNews');
        $addNews->description = 'Adicionar notícias';
        $auth->add($addNews);
        
        $editNews = $auth->createPermission('editNews');
        $editNews->description = 'Editar notícias';
        $auth->add($editNews);
        
        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Eliminar notícias';
        $auth->add($deleteNews);
        
        // Permissões de Bilheteira
        $manageBilling = $auth->createPermission('manageBilling');
        $manageBilling->description = 'Gerir bilheteira (preços, disponibilidade, descontos)';
        $auth->add($manageBilling);
        
        $buyTickets = $auth->createPermission('buyTickets');
        $buyTickets->description = 'Adquirir bilhetes online';
        $auth->add($buyTickets);
        
        // Permissões de Utilizadores
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Gerir utilizadores (criar, editar, remover, atribuir roles)';
        $auth->add($manageUsers);
        
        $editProfile = $auth->createPermission('editProfile');
        $editProfile->description = 'Editar próprio perfil';
        $auth->add($editProfile);
        
        // Permissões de Avaliações/Comentários
        $addReview = $auth->createPermission('addReview');
        $addReview->description = 'Adicionar avaliações e comentários';
        $auth->add($addReview);
        
        $editOwnReview = $auth->createPermission('editOwnReview');
        $editOwnReview->description = 'Editar próprias avaliações';
        $auth->add($editOwnReview);
        
        $deleteOwnReview = $auth->createPermission('deleteOwnReview');
        $deleteOwnReview->description = 'Eliminar próprias avaliações';
        $auth->add($deleteOwnReview);
        
        $deleteAnyReview = $auth->createPermission('deleteAnyReview');
        $deleteAnyReview->description = 'Eliminar qualquer avaliação';
        $auth->add($deleteAnyReview);
        
        // Permissões de Visualização (todos têm acesso)
        $viewContent = $auth->createPermission('viewContent');
        $viewContent->description = 'Visualizar museus, monumentos, eventos, notícias';
        $auth->add($viewContent);
        
        $viewMap = $auth->createPermission('viewMap');
        $viewMap->description = 'Visualizar mapa interativo';
        $auth->add($viewMap);
        
        $searchContent = $auth->createPermission('searchContent');
        $searchContent->description = 'Pesquisar museus e monumentos';
        $auth->add($searchContent);
        
        // Permissão de acesso ao Back-Office
        $accessBackoffice = $auth->createPermission('accessBackoffice');
        $accessBackoffice->description = 'Aceder ao back-office';
        $auth->add($accessBackoffice);
        
        // ============ CRIAR ROLES ============
        
        // Role: User (autenticado)
        $user = $auth->createRole('user');
        $user->description = 'Utilizador autenticado - Acesso completo ao front-office';
        $auth->add($user);
        $auth->addChild($user, $buyTickets);
        $auth->addChild($user, $addReview);
        $auth->addChild($user, $editOwnReview);
        $auth->addChild($user, $deleteOwnReview);
        $auth->addChild($user, $editProfile);
        
        // Role: Gestor
        $gestor = $auth->createRole('gestor');
        $gestor->description = 'Gestor - Acesso ao back-office para gestão de conteúdos';
        $auth->add($gestor);
        $auth->addChild($gestor, $user); // Herda permissões de user
        $auth->addChild($gestor, $accessBackoffice);
        $auth->addChild($gestor, $addMuseum);
        $auth->addChild($gestor, $editMuseum);
        $auth->addChild($gestor, $deleteMuseum);
        $auth->addChild($gestor, $addMonument);
        $auth->addChild($gestor, $editMonument);
        $auth->addChild($gestor, $deleteMonument);
        $auth->addChild($gestor, $addEvent);
        $auth->addChild($gestor, $editEvent);
        $auth->addChild($gestor, $deleteEvent);
        $auth->addChild($gestor, $addNews);
        $auth->addChild($gestor, $editNews);
        $auth->addChild($gestor, $deleteNews);
        $auth->addChild($gestor, $manageBilling);
        $auth->addChild($gestor, $deleteAnyReview);
        
        // Role: Admin (Sys Admin)
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrador - Acesso total ao sistema';
        $auth->add($admin);
        $auth->addChild($admin, $gestor); // Herda todas as permissões de gestor
        $auth->addChild($admin, $manageUsers);
        
        // ============ ATRIBUIR ROLES A UTILIZADORES (EXEMPLO) ============
        // Descomente e ajuste os IDs conforme necessário
        // $auth->assign($admin, 1);   // User ID 1 = Admin
        // $auth->assign($gestor, 2);  // User ID 2 = Gestor
        // $auth->assign($user, 3);    // User ID 3 = User
        
        echo "   Roles e permissões criadas com sucesso!\n\n";
        echo "   Resumo:\n";
        echo "   - User: Comprar bilhetes, avaliar, gerir perfil\n";
        echo "   - Gestor: Gerir museus, monumentos, eventos, notícias, bilheteira\n";
        echo "   - Admin: Controlo total + gestão de utilizadores\n";
    }
}