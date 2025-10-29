<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class CustomFooter extends Widget
{
    /**
     * @var string Logo URL
     */
    public $logoUrl = '@web/images/logo/logo.svg';
    
    /**
     * @var string Logo text
     */
    public $logoText = '+Lusitânia';
    
    /**
     * @var string Cor principal (azul)
     */
    public $brandColor = '#2E5AAC';
    
    /**
     * @var array Links da primeira coluna
     */
    public $column1Links = [];
    
    /**
     * @var array Links da segunda coluna
     */
    public $column2Links = [];
    
    /**
     * @var array Links da terceira coluna
     */
    public $column3Links = [];
    
    /**
     * @var array Redes sociais
     */
    public $socialLinks = [];

    public function init()
    {
        parent::init();
        
        if (empty($this->column1Links)) {
            $this->column1Links = [
                'title' => 'Explorar',
                'links' => [
                    ['label' => 'Museus', 'url' => ['/museus/index']],
                    ['label' => 'Monumentos', 'url' => ['/monumentos/index']],
                    ['label' => 'Eventos', 'url' => ['/eventos/index']],
                    ['label' => 'Notícias', 'url' => ['/noticias/index']],
                ]
            ];
        }
        
        if (empty($this->column2Links)) {
            $this->column2Links = [
                'title' => 'Sobre',
                'links' => [
                    ['label' => 'Quem Somos', 'url' => ['/site/about']],
                    ['label' => 'Contactos', 'url' => ['/site/contact']],
                ]
            ];
        }
        
        if (empty($this->column3Links)) {
            $this->column3Links = [
                'title' => 'Suporte',
                'links' => [
                    ['label' => 'FAQ', 'url' => ['/site/faq']],
                ]
            ];
        }
        
        if (empty($this->socialLinks)) {
            $this->socialLinks = [
                ['icon' => 'facebook', 'url' => 'https://facebook.com'],
                ['icon' => 'instagram', 'url' => 'https://instagram.com'],
                ['icon' => 'twitter', 'url' => 'https://twitter.com'],
                ['icon' => 'youtube', 'url' => 'https://youtube.com'],
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
        return $this->render('custom-footer', [
            'logoUrl' => $logoUrl,
            'logoText' => $this->logoText,
            'brandColor' => $this->brandColor,
            'column1Links' => $this->column1Links,
            'column2Links' => $this->column2Links,
            'column3Links' => $this->column3Links,
            'socialLinks' => $this->socialLinks,
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        
        $css = <<<CSS
        .custom-footer {
            background-color: #ffffffff;
            border-top: 2px solid {$this->brandColor};
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        
        .custom-footer .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }
        
        .custom-footer .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .custom-footer .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .custom-footer .footer-brand img {
            width: 200px;
            height: 53px;
        }
        
        .custom-footer .footer-brand p {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
            max-width: 300px;
        }
        
        .custom-footer .footer-column h4 {
            color: {$this->brandColor};
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .custom-footer .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .custom-footer .footer-column ul li {
            margin-bottom: 0.75rem;
        }
        
        .custom-footer .footer-column ul li a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .custom-footer .footer-column ul li a:hover {
            color: {$this->brandColor};
        }
        
        .custom-footer .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .custom-footer .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid {$this->brandColor};
            background-color: #ffffff;
            color: {$this->brandColor};
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .custom-footer .footer-social a:hover {
            background-color: {$this->brandColor};
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        .custom-footer .footer-bottom {
            border-top: 1px solid #dee2e6;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .custom-footer .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .custom-footer .footer-bottom-links a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .custom-footer .footer-bottom-links a:hover {
            color: {$this->brandColor};
        }
        
        @media (max-width: 992px) {
            .custom-footer .footer-container {
                padding: 0 1.5rem;
            }
            
            .custom-footer .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .custom-footer .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .custom-footer .footer-bottom-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .custom-footer {
                padding: 3rem 0 1.5rem;
            }
        }
CSS;
        
        $view->registerCss($css);
    }
}