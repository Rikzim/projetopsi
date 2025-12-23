<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // --- This is the critical change ---
        // We clear permissions and the hierarchy, but NEVER the roles themselves.
        $auth->removeAllPermissions();
        
        // This removes all parent-child links so we can rebuild them.
        $db = Yii::$app->db;
        $db->createCommand()->delete($auth->itemChildTable)->execute();

        // ============ CRIAR PERMISSÕES ============
        
        // Permissões de Locais Culturais
        $viewPlace = $auth->createPermission('viewPlace');
        $viewPlace->description = 'Visualizar locais';
        $auth->add($viewPlace);

        $addPlace = $auth->createPermission('addPlace');
        $addPlace->description = 'Adicionar locais';
        $auth->add($addPlace);

        $editPlace = $auth->createPermission('editPlace'); 
        $editPlace->description = 'Editar locais';
        $auth->add($editPlace);
        
        $deletePlace = $auth->createPermission('deletePlace');
        $deletePlace->description = 'Eliminar locais';
        $auth->add($deletePlace);
        
        // Permissões de Eventos
        $viewEvent = $auth->createPermission('viewEvent');
        $viewEvent->description = 'Visualizar eventos';
        $auth->add($viewEvent);

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
        $viewNews = $auth->createPermission('viewNews');
        $viewNews->description = 'Visualizar notícias';
        $auth->add($viewNews);

        $addNews = $auth->createPermission('addNews');
        $addNews->description = 'Adicionar notícias';
        $auth->add($addNews);
        
        $editNews = $auth->createPermission('editNews');
        $editNews->description = 'Editar notícias';
        $auth->add($editNews);
        
        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Eliminar notícias';
        $auth->add($deleteNews);
        
        // Permissões de Bilheteira/Reservas
        $viewBilling = $auth->createPermission('viewBilling');
        $viewBilling->description = 'Visualizar bilhetes';
        $auth->add($viewBilling);

        $addBilling = $auth->createPermission('addBilling');
        $addBilling->description = 'Adicionar bilhetes';
        $auth->add($addBilling);

        $editBilling = $auth->createPermission('editBilling');
        $editBilling->description = 'Editar bilhetes';
        $auth->add($editBilling);

        $deleteBilling = $auth->createPermission('deleteBilling');
        $deleteBilling->description = 'Eliminar bilhetes';
        $auth->add($deleteBilling);
        
        $buyTickets = $auth->createPermission('buyTickets');
        $buyTickets->description = 'Adquirir bilhetes online';
        $auth->add($buyTickets);

        $viewReservations = $auth->createPermission('viewReservations');
        $viewReservations->description = 'Visualizar reservas';
        $auth->add($viewReservations);

        $editReservations = $auth->createPermission('editReservations');
        $editReservations->description = 'Editar reservas';
        $auth->add($editReservations);

        $deleteReservations = $auth->createPermission('deleteReservations');
        $deleteReservations->description = 'Eliminar reservas';
        $auth->add($deleteReservations);

        $cancelOwnReservation = $auth->createPermission('cancelOwnReservation');
        $cancelOwnReservation->description = 'Cancelar próprias reservas';
        $auth->add($cancelOwnReservation);

        // Permissões de Utilizadores
        $viewUsers = $auth->createPermission('viewUser');
        $viewUsers->description = 'Visualizar utilizadores';
        $auth->add($viewUsers);

        $addUser = $auth->createPermission('addUser');
        $addUser->description = 'Adicionar utilizadores';
        $auth->add($addUser);

        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Editar utilizadores';
        $auth->add($editUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Eliminar utilizadores';
        $auth->add($deleteUser);

        $editProfile = $auth->createPermission('editProfile');
        $editProfile->description = 'Editar próprio perfil';
        $auth->add($editProfile);

        $viewOwnProfile = $auth->createPermission('viewOwnProfile');
        $viewOwnProfile->description = 'Visualizar próprio perfil';
        $auth->add($viewOwnProfile);

        $editOwnProfile = $auth->createPermission('editOwnProfile');
        $editOwnProfile->description = 'Editar próprio perfil via API';
        $auth->add($editOwnProfile);

        $deleteOwnProfile = $auth->createPermission('deleteOwnProfile');
        $deleteOwnProfile->description = 'Eliminar próprio perfil';
        $auth->add($deleteOwnProfile);
        
        // Permissões de Avaliações/Comentários
        $viewReviews = $auth->createPermission('viewReviews');
        $viewReviews->description = 'Visualizar avaliações e comentários';
        $auth->add($viewReviews);

        $addReview = $auth->createPermission('addReview');
        $addReview->description = 'Adicionar avaliações e comentários';
        $auth->add($addReview);

        $editReview = $auth->createPermission('editReview');
        $editReview->description = 'Editar avaliações e comentários';
        $auth->add($editReview);
        
        $editOwnReview = $auth->createPermission('editOwnReview');
        $editOwnReview->description = 'Editar próprias avaliações';
        $auth->add($editOwnReview);
        
        $deleteOwnReview = $auth->createPermission('deleteOwnReview');
        $deleteOwnReview->description = 'Eliminar próprias avaliações';
        $auth->add($deleteOwnReview);
        
        $deleteAnyReview = $auth->createPermission('deleteAnyReview');
        $deleteAnyReview->description = 'Soft Delete de qualquer avaliação';
        $auth->add($deleteAnyReview);
        
        // Permissões de Tipo Local
        $viewTypePlace = $auth->createPermission('viewTypePlace');
        $viewTypePlace->description = 'Visualizar tipos de locais';
        $auth->add($viewTypePlace);
        
        $addTypePlace = $auth->createPermission('addTypePlace');
        $addTypePlace->description = 'Adicionar tipos de locais';
        $auth->add($addTypePlace);

        $editTypePlace = $auth->createPermission('editTypePlace');
        $editTypePlace->description = 'Editar tipos de locais';
        $auth->add($editTypePlace);

        $deleteTypePlace = $auth->createPermission('deleteTypePlace');
        $deleteTypePlace->description = 'Eliminar tipos de locais';
        $auth->add($deleteTypePlace);

        // Permissões de Favoritos
        $addFavorite = $auth->createPermission('addFavorite');
        $addFavorite->description = 'Adicionar aos favoritos';
        $auth->add($addFavorite);

        $removeFavorite = $auth->createPermission('removeFavorite');
        $removeFavorite->description = 'Remover dos favoritos';
        $auth->add($removeFavorite);

        $viewFavorites = $auth->createPermission('viewFavorites');
        $viewFavorites->description = 'Visualizar lista de favoritos';
        $auth->add($viewFavorites);

        // Permissões de Distritos
        $viewDistrict = $auth->createPermission('viewDistrict');
        $viewDistrict->description = 'Visualizar distritos';
        $auth->add($viewDistrict);

        $addDistrict = $auth->createPermission('addDistrict');
        $addDistrict->description = 'Adicionar distritos';
        $auth->add($addDistrict);

        $editDistrict = $auth->createPermission('editDistrict');
        $editDistrict->description = 'Editar distritos';
        $auth->add($editDistrict);

        $deleteDistrict = $auth->createPermission('deleteDistrict');
        $deleteDistrict->description = 'Eliminar distritos';
        $auth->add($deleteDistrict);

        // Permissão de acesso ao Back-Office
        $accessBackoffice = $auth->createPermission('accessBackoffice');
        $accessBackoffice->description = 'Aceder ao back-office';
        $auth->add($accessBackoffice);
        
        // ============ CRIAR ROLES (IF THEY DON'T EXIST) ============
        
        // Role: User (autenticado)
        if (!($user = $auth->getRole('user'))) {
            $user = $auth->createRole('user');
            $user->description = 'Utilizador autenticado - Acesso completo ao front-office';
            $auth->add($user);
        }
        
        // Role: Gestor
        if (!($gestor = $auth->getRole('gestor'))) {
            $gestor = $auth->createRole('gestor');
            $gestor->description = 'Gestor - Acesso ao back-office para gestão de conteúdos';
            $auth->add($gestor);
        }
        
        // Role: Admin (Sys Admin)
        if (!($admin = $auth->getRole('admin'))) {
            $admin = $auth->createRole('admin');
            $admin->description = 'Administrador - Acesso total ao sistema';
            $auth->add($admin);
        }
        
        // ============ REBUILD HIERARCHY ============
        $auth->addChild($user, $viewPlace);
        $auth->addChild($user, $viewEvent);
        $auth->addChild($user, $viewNews);
        $auth->addChild($user, $buyTickets);
        $auth->addChild($user, $viewReservations);
        $auth->addChild($user, $cancelOwnReservation);
        $auth->addChild($user, $addReview);
        $auth->addChild($user, $editOwnReview);
        $auth->addChild($user, $deleteOwnReview);
        $auth->addChild($user, $viewOwnProfile);
        $auth->addChild($user, $editOwnProfile);
        $auth->addChild($user, $deleteOwnProfile);
        $auth->addChild($user, $addFavorite);
        $auth->addChild($user, $removeFavorite);
        $auth->addChild($user, $viewFavorites);
        
        // Role: Gestor
        $auth->addChild($gestor, $user); // Herda permissões de user
        $auth->addChild($gestor, $accessBackoffice);
        $auth->addChild($gestor, $addPlace);
        $auth->addChild($gestor, $editPlace);
        $auth->addChild($gestor, $deletePlace);
        $auth->addChild($gestor, $addEvent);
        $auth->addChild($gestor, $editEvent);
        $auth->addChild($gestor, $deleteEvent);
        $auth->addChild($gestor, $addNews);
        $auth->addChild($gestor, $editNews);
        $auth->addChild($gestor, $deleteNews);
        $auth->addChild($gestor, $editReservations);
        $auth->addChild($gestor, $deleteReservations);
        $auth->addChild($gestor, $viewBilling);
        $auth->addChild($gestor, $addBilling);
        $auth->addChild($gestor, $editBilling);
        $auth->addChild($gestor, $deleteBilling);
        $auth->addChild($gestor, $deleteAnyReview);
        $auth->addChild($gestor, $addTypePlace);
        $auth->addChild($gestor, $editTypePlace);
        $auth->addChild($gestor, $deleteTypePlace);
        
        // Role: Admin (Sys Admin)
        $auth->addChild($admin, $gestor); // Herda todas as permissões de gestor
        $auth->addChild($admin, $viewUsers);
        $auth->addChild($admin, $addUser);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $viewDistrict);
        $auth->addChild($admin, $addDistrict);
        $auth->addChild($admin, $editDistrict);
        $auth->addChild($admin, $deleteDistrict);
        
        echo "RBAC criado.\n";
    }
}