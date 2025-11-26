<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class HeroSection extends Widget
{
    public $title;
    public $subtitle;
    public $buttons = [];
    public $backgroundImage = 'http://localhost/projetopsi/maislusitania/frontend/web/images/hero-background.jpg';
    public $showOverlay = true; // Add this property

    public function run()
    {
        $this->registerCss();

        $imageUrl = Url::to($this->backgroundImage);

        return $this->render('hero-section', [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'buttons' => $this->buttons,
            'backgroundImage' => $imageUrl,
            'showOverlay' => $this->showOverlay, // Pass to view
        ]);
    }

    protected function registerCss()
    {
        $this->view->registerCss("
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
        .hero-section-widget {
            width: 100vw !important;
            height: 100vh !important;
            margin-left: calc(-50vw + 50%) !important;
            margin-right: calc(-50vw + 50%) !important;
            margin-top: 0 !important;
            position: relative;
            top: -70px;
            padding-top: 70px;
        }

        .hero-section-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .hero-section-widget h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .hero-section-widget p {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 3rem;
        }

        @media (max-width: 768px) {
            .hero-section-widget h1 {
                font-size: 2.5rem;
            }
            .hero-section-widget p {
                font-size: 1.2rem;
            }
        }
    ");
    }
}
