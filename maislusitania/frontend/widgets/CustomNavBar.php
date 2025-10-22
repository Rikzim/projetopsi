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
    public $logoUrl = '/images/logo/logo.svg';
    
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

    public function init()
    {
        parent::init();
        
        if (empty($this->menuItems)) {
            $this->menuItems = [
                ['label' => 'Sobre', 'url' => ['/site/about']],
                ['label' => 'Museus', 'url' => ['/museus/index']],
                ['label' => 'Monumentos', 'url' => ['/monumentos/index']],
                ['label' => 'Notícias', 'url' => ['/noticias/index']],
                ['label' => 'Eventos', 'url' => ['/eventos/index']],
                ['label' => 'Mapa', 'url' => ['/testemapa/index']],
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
        return $this->render('custom-navbar', [
            'logoUrl' => $logoUrl,
            'menuItems' => $this->menuItems,
            'brandColor' => $this->brandColor,
            'showAuthButtons' => $this->showAuthButtons,
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        
        $css = <<<CSS
        .custom-navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.8rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .custom-navbar .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .custom-navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: {$this->brandColor};
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .custom-navbar .navbar-brand img {
            width: 205px;
            height: 54px;
        }
        
        .custom-navbar .navbar-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        
        .custom-navbar .navbar-menu a {
            text-decoration: none;
            color: #333;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .custom-navbar .navbar-menu a:hover {
            color: {$this->brandColor};
        }
        
        .custom-navbar .navbar-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .custom-navbar .btn-signup {
            padding: 0.5rem 1.5rem;
            background-color: transparent;
            color: {$this->brandColor};
            border: 2px solid {$this->brandColor};
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .custom-navbar .btn-signup:hover {
            background-color: {$this->brandColor};
            color: white;
        }
        
        .custom-navbar .btn-login {
            padding: 0.5rem 1.5rem;
            background-color: {$this->brandColor};
            color: white;
            border: 2px solid {$this->brandColor};
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .custom-navbar .btn-login:hover {
            background-color: #1e4a9c;
            border-color: #1e4a9c;
        }
        
        .custom-navbar .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid {$this->brandColor};
            cursor: pointer;
        }
        
        .custom-navbar .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: {$this->brandColor};
        }
        
        @media (max-width: 992px) {
            .custom-navbar .navbar-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            
            .custom-navbar .navbar-menu.active {
                display: flex;
            }
            
            .custom-navbar .mobile-toggle {
                display: block;
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
        });
JS;
        
        $view->registerJs($js);
    }
}