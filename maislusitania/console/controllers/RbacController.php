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

        // Permissões de Horários
        $viewSchedule = $auth->createPermission('viewSchedule');
        $viewSchedule->description = 'Visualizar horários';
        $auth->add($viewSchedule);

        $addSchedule = $auth->createPermission('addSchedule');
        $addSchedule->description = 'Adicionar horários';
        $auth->add($addSchedule);

        $editSchedule = $auth->createPermission('editSchedule');
        $editSchedule->description = 'Editar horários';
        $auth->add($editSchedule);

        $deleteSchedule = $auth->createPermission('deleteSchedule');
        $deleteSchedule->description = 'Eliminar horários';
        $auth->add($deleteSchedule);

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
        
        // ============ CRIAR ROLES ============
        
        // Role: User (autenticado)
        $user = $auth->createRole('user');
        $user->description = 'Utilizador autenticado - Acesso completo ao front-office';
        $auth->add($user);
        $auth->addChild($user, $viewPlace);
        $auth->addChild($user, $viewEvent);
        $auth->addChild($user, $viewNews);
        $auth->addChild($user, $viewSchedule);
        $auth->addChild($user, $viewDistrict);
        $auth->addChild($user, $buyTickets);
        $auth->addChild($user, $viewReservations);
        $auth->addChild($user, $cancelOwnReservation);
        $auth->addChild($user, $addReview);
        $auth->addChild($user, $editOwnReview);
        $auth->addChild($user, $deleteOwnReview);
        $auth->addChild($user, $editProfile);
        $auth->addChild($user, $addFavorite);
        $auth->addChild($user, $removeFavorite);
        $auth->addChild($user, $viewFavorites);
        
        // Role: Gestor
        $gestor = $auth->createRole('gestor');
        $gestor->description = 'Gestor - Acesso ao back-office para gestão de conteúdos';
        $auth->add($gestor);
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
        $auth->addChild($gestor, $viewBilling);
        $auth->addChild($gestor, $addBilling);
        $auth->addChild($gestor, $editBilling);
        $auth->addChild($gestor, $deleteBilling);
        $auth->addChild($gestor, $deleteAnyReview);
        $auth->addChild($gestor, $addTypePlace);
        $auth->addChild($gestor, $editTypePlace);
        $auth->addChild($gestor, $deleteTypePlace);
        $auth->addChild($gestor, $addSchedule);
        $auth->addChild($gestor, $editSchedule);
        $auth->addChild($gestor, $deleteSchedule);
        
        
        // Role: Admin (Sys Admin)
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrador - Acesso total ao sistema';
        $auth->add($admin);
        $auth->addChild($admin, $gestor); // Herda todas as permissões de gestor
        $auth->addChild($admin, $viewUsers);
        $auth->addChild($admin, $addUser);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $addDistrict);
        $auth->addChild($admin, $editDistrict);
        $auth->addChild($admin, $deleteDistrict);

        // Adicionar role ao admin por defeito (ID=1)
        $auth->assign($admin, 8); //
        
        echo "✅ Roles e permissões criadas com sucesso!\n\n";
        echo "📋 Resumo:\n";
        echo "   • User: Visualizar conteúdos, comprar bilhetes, avaliar, favoritos, gerir perfil\n";
        echo "   • Gestor: Gerir locais, eventos, notícias, bilheteira, tipos de local, horários\n";
        echo "   • Admin: Controlo total + gestão de utilizadores e distritos\n\n";
        echo "📊 Total de permissões: " . count($auth->getPermissions()) . "\n";
        echo "👥 Total de roles: " . count($auth->getRoles()) . "\n";
    }
}