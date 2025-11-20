<?php
namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class CustomNavBar extends Widget
{
    /**
     * @var string Logo URL
     */
    public $logoUrl = '@web/images/logo/Logo.svg';

    /**
     * @var string Logo text
     */
    public $logoText = '+Lusitânia';

    /**
     * @var array Menu items
     * Formato: [
     *     ['label' => 'Sobre', 'url' => ['/site/about']],
     *     ...
     * ]
     */
    public $menuItems = [];

    /**
     * @var string Cor principal (azul)
     */
    public $brandColor = '#2E5AAC';

    /**
     * @var bool Mostrar botões de login/signup
     */
    public $showAuthButtons = true;

    /**
     * @var string Label for signup button
     */
    public $signupLabel = 'Registar';

    /**
     * @var string Label for login button
     */
    public $loginLabel = 'Entrar';

    public function init()
    {
        parent::init();

        if (empty($this->menuItems)) {
            $this->menuItems = [
                ['label' => 'Mapa', 'url' => ['/mapa/index']],
                ['label' => 'Locais', 'url' => ['/local-cultural/index']],
                ['label' => 'Notícias', 'url' => ['/noticia/index']],
                ['label' => 'Eventos', 'url' => ['/evento/index']],
                ['label' => 'Sobre', 'url' => ['/site/about']],
            ];
        }
    }


    public function run()
    {
        $this->registerAssets();
        $logoUrl = $this->logoUrl;
        if (strpos($logoUrl, '@web') === 0) {
            $logoUrl = Yii::$app->request->baseUrl . str_replace('@web', '', $logoUrl);
        }

        $username = '';
        $userInitial = '';
        $userImage = Yii::$app->request->baseUrl . '/images/default-user.png'; // Initialize here

        if (!Yii::$app->user->isGuest) {
            $identity = Yii::$app->user->identity;
            $profile = $identity ? $identity->userProfile : null;
            
            $username = $identity->username;
            $userInitial = strtoupper(substr($username, 0, 1));
            
            if ($profile && !empty($profile->imagem_perfil)) {
                // Use the backend URL path for uploaded images
                $userImage = '../../../backend/web/uploads/' . $profile->imagem_perfil;
            }
        }

        return $this->render('custom-navbar', [
            'logoUrl' => $logoUrl,
            'menuItems' => $this->menuItems,
            'brandColor' => $this->brandColor,
            'showAuthButtons' => $this->showAuthButtons,
            'isGuest' => Yii::$app->user->isGuest,
            'username' => $username,
            'userInitial' => $userInitial,
            'userImage' => $userImage,
            'signupLabel' => $this->signupLabel,
            'loginLabel' => $this->loginLabel,
        ]);
    }


    protected function registerAssets()
    {
        $view = $this->getView();

        $css = <<<CSS
        .custom-navbar {
    background-color: transparent;
    padding: 0.25rem 0;
    position: fixed;
    top: 1rem;
    z-index: 1000;
    width: 100%;
}

.custom-navbar .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0.75rem 2.5rem;
    background-color: #ffffff;
    border: 2px solid {$this->brandColor};
    border-radius: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    min-height: 65px;
}

.custom-navbar .navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    color: {$this->brandColor};
    font-size: 1.5rem;
    font-weight: 600;
    flex-shrink: 0;
    width: 250px;
}

.custom-navbar .navbar-brand img {
    width: 180px;
    height: 45px;
    object-fit: contain;
}

.custom-navbar .navbar-menu {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
    flex: 1;
    justify-content: center;
}

.custom-navbar .navbar-menu a {
    text-decoration: none;
    color: {$this->brandColor};
    font-size: 0.95rem;
    font-weight: 600;
    padding: 0.6rem 0.75rem;
    border-radius: 30px;
    transition: all 0.3s ease;
    display: inline-block;
    line-height: 1.5;
}

.custom-navbar .navbar-menu a:hover {
    background-color: {$this->brandColor};
    color: white;
}

.custom-navbar .navbar-auth {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    width: 250px;
    justify-content: flex-end;
}

.custom-navbar .btn-signup {
    padding: 0.6rem 1.5rem;
    background-color: transparent;
    color: {$this->brandColor};
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    line-height: 1.5;
}

.custom-navbar .btn-login {
    padding: 0.6rem 1.5rem;
    background-color: {$this->brandColor};
    color: white;
    border: 2px solid {$this->brandColor};
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    line-height: 1.5;
}

.custom-navbar .btn-login:hover {
    background-color: #1e4a9c;
    border-color: #1e4a9c;
}

.custom-navbar .user-info {
    position: relative;
    display: flex;
    align-items: center;
}

.custom-navbar .user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid {$this->brandColor};
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: {$this->brandColor};
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.custom-navbar .user-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(46, 90, 172, 0.3);
}

.custom-navbar .user-dropdown {
    position: absolute;
    top: calc(100% + 1rem);
    right: 0;
    background: white;
    border-radius: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    min-width: 260px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
    border: 2px solid {$this->brandColor};
}

.custom-navbar .user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.custom-navbar .user-dropdown-header {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-radius: 26px 26px 0 0;
    color: white;
    background: {$this->brandColor};
}

.custom-navbar .user-dropdown-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    color: {$this->brandColor};
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.3rem;
}

.custom-navbar .user-dropdown-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.custom-navbar .user-dropdown-info strong {
    font-size: 1rem;
    font-weight: 600;
}

.custom-navbar .user-dropdown-info small {
    font-size: 0.85rem;
    opacity: 0.9;
}

.custom-navbar .user-dropdown-divider {
    height: 2px;
    background: {$this->brandColor};
    margin: 0.5rem 0;
}

.custom-navbar .user-dropdown-menu {
    list-style: none;
    padding: 0.5rem 0;
    margin: 0;
}

.custom-navbar .user-dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    color: #495057;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    font-weight: 500;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.custom-navbar .user-dropdown-item:hover {
    background: #f8f9fa;
    color: {$this->brandColor};
}

.custom-navbar .user-dropdown-item svg {
    width: 18px;
    height: 18px;
}

.custom-navbar .logout-item {
    color: #dc3545;
}

.custom-navbar .logout-item:hover {
    background: #fff5f5;
    color: #dc3545;
}

.custom-navbar .mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: {$this->brandColor};
}

.custom-navbar .mobile-auth {
    display: none;
}

@media (max-width: 992px) {
    .custom-navbar .navbar-container {
        padding: 0.75rem 1.5rem;
        max-width: calc(100% - 2rem);
        margin: 0 1rem;
    }

    .custom-navbar .navbar-menu {
        display: none;
        position: absolute;
        top: calc(100% + 0.5rem);
        left: 1rem;
        right: 1rem;
        background: white;
        flex-direction: column;
        padding: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-radius: 12px;
        border: 2px solid {$this->brandColor};
    }

    .custom-navbar .navbar-menu.active {
        display: flex;
    }

    .custom-navbar .navbar-menu li {
        width: 100%;
    }

    .custom-navbar .navbar-menu a {
        display: block;
        padding: 0.75rem 1rem;
        text-align: center;
        border-radius: 8px;
    }

    .custom-navbar .mobile-toggle {
        display: block;
    }

    .custom-navbar .navbar-auth {
        display: none;
    }

    .custom-navbar .mobile-auth {
        display: flex;
        gap: 0.75rem;
        flex-direction: column;
        padding-top: 0.75rem;
        border-top: 2px solid #e9ecef;
        margin-top: 0.75rem;
    }

    .custom-navbar .mobile-auth .btn-signup,
    .custom-navbar .mobile-auth .btn-login {
        display: block;
        text-align: center;
        padding: 0.75rem 1.5rem;
    }

    .custom-navbar .mobile-auth .btn-signup {
        background-color: transparent;
        color: {$this->brandColor};
        border: 2px solid {$this->brandColor};
    }

    .custom-navbar .mobile-auth .btn-login {
        background-color: {$this->brandColor};
        color: white;
    }

    .custom-navbar .mobile-user-section {
        width: 100%;
    }

    .custom-navbar .mobile-user-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, {$this->brandColor} 0%, #1e4a9c 100%);
        border-radius: 8px;
        color: white;
        margin-bottom: 0.5rem;
    }

    .custom-navbar .mobile-user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        color: {$this->brandColor};
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .custom-navbar .mobile-user-name {
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    .custom-navbar .mobile-menu-link {
        display: block;
        padding: 0.75rem 1rem;
        text-align: left;
        text-decoration: none;
        color: {$this->brandColor};
        font-weight: 600;
        background: none;
        border: none;
        width: 100%;
        cursor: pointer;
        border-radius: 8px;
        transition: background 0.2s ease;
        font-size: 0.95rem;
    }

    .custom-navbar .mobile-menu-link:hover {
        background: #f8f9fa;
    }

    .custom-navbar .mobile-menu-link.logout {
        color: #dc3545;
    }

    .custom-navbar .mobile-menu-link.logout:hover {
        background: #fff5f5;
    }

    .custom-navbar .user-dropdown {
        right: -1rem;
    }
}

CSS;

        $view->registerCss($css);

        $js = <<<JS
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.mobile-toggle');
            const menu = document.querySelector('.navbar-menu');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('active');
                });
            }

            // User dropdown toggle
            const userToggle = document.getElementById('user-dropdown-toggle');
            const userDropdown = document.getElementById('user-dropdown-menu');

            if (userToggle && userDropdown) {
                userToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userToggle.contains(e.target)) {
                        userDropdown.classList.remove('show');
                    }
                });
            }
        });
JS;

        $view->registerJs($js);
    }
}
