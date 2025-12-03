<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class InfiniteCarousel extends Widget
{
    public $items = [];
    public $cardWidth = 400;
    public $cardHeight = 250;
    public $cardGap = 1;
    public $carouselId;
    public $backgroundColor = 'transparent';
    public $prevArrow = '@web/images/ui/seta-esquerda.svg';
    public $nextArrow = '@web/images/ui/seta-direita.svg';

    public function init()
    {
        parent::init();

        if ($this->carouselId === null) {
            $this->carouselId = $this->getId();
        }

        if (empty($this->items)) {
            $this->items = $this->getDefaultItems();
        }
    }

    public function run()
    {
        $this->registerAssets();

        $processedItems = array_map(function($item) {
            if (isset($item['image'])) {
                if (strpos($item['image'], '/') === false) {
                    $item['image'] = '/uploads/' . $item['image'];
                }
            }
            return $item;
        }, $this->items);

        $prevUrl = Url::to($this->prevArrow);
        $nextUrl = Url::to($this->nextArrow);

        return $this->render('infinite-carousel', [
            'items' => $processedItems,
            'cardWidth' => $this->cardWidth,
            'cardHeight' => $this->cardHeight,
            'cardGap' => $this->cardGap,
            'carouselId' => $this->carouselId,
            'backgroundColor' => $this->backgroundColor,
            'prevArrow' => $prevUrl,
            'nextArrow' => $nextUrl,
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        $view->registerCss($this->getCss());
        $view->registerJs($this->getJs(), \yii\web\View::POS_READY);
    }

    protected function getCss()
    {
        return <<<CSS

    #{$this->carouselId} {
        position: relative;
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        overflow: hidden;
    }

    #{$this->carouselId} .carousel-container {
        position: relative;
        width: 100%;
        height: calc({$this->cardHeight}px + 70px);
    }

    #{$this->carouselId} .carousel-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: visible;
    }

    #{$this->carouselId} .carousel-track {
        display: flex;
        gap: {$this->cardGap}rem;
        position: absolute;
        left: 0;
        top: 20px;
        transition: transform 0.3s ease-out;
        will-change: transform;
    }

    #{$this->carouselId} .carousel-track.no-transition {
        transition: none !important;
    }

    #{$this->carouselId} .carousel-card {
        flex: 0 0 {$this->cardWidth}px;
        min-width: {$this->cardWidth}px;
        height: {$this->cardHeight}px;
    }

    #{$this->carouselId} .carousel-card .card {
        text-decoration: none;
        color: inherit;
        display: block;
        border-radius: 0;
        overflow: hidden;
        height: 100%;
        width: 100%;
        position: relative;
        background: white;
        border: none;
        outline: none;
        transition: all 0.3s ease;
        transform-origin: center center;
    }

    #{$this->carouselId} .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border: none;
        outline: none;
    }

    /* caption overlay */
    #{$this->carouselId} .card-caption {
        position: absolute;
        left: 12px;
        bottom: 10px;
        right: 12px;
        color: #ffffff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        pointer-events: none;
    }

    #{$this->carouselId} .card-caption .title {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
    }

    #{$this->carouselId} .card-caption .sub {
        font-size: 0.9rem;
        margin: 2px 0 0;
        opacity: 0.95;
    }

    #{$this->carouselId} .carousel-card .card:hover {
        transform: scale(1.03);
        box-shadow: 0 2px 8px rgba(46, 90, 172, 0.2);
        z-index: 5;
    }

    #{$this->carouselId} .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        user-select: none;
        padding: 0;
    }

    #{$this->carouselId} .carousel-nav img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: none;
    }

    #{$this->carouselId} .carousel-nav.prev {
        left: 12px;
    }

    #{$this->carouselId} .carousel-nav.next {
        right: 12px;
    }

    @media (max-width: 768px) {
        #{$this->carouselId} .carousel-card {
            flex: 0 0 300px;
            min-width: 300px;
        }

        #{$this->carouselId} .carousel-nav {
            width: 50px;
            height: 50px;
        }
    }
CSS;
    }


    protected function getJs()
    {
        $cardGapPx = $this->cardGap * 16;
        $cardWidthTotal = $this->cardWidth + $cardGapPx;

        return <<<JS
    (function() {
        const carousel = document.getElementById('{$this->carouselId}');
        if (!carousel) return;

        const wrapper = carousel.querySelector('.carousel-wrapper');
        const track = carousel.querySelector('.carousel-track');
        const originalCards = Array.from(track.querySelectorAll('.carousel-card'));
        const prevBtn = carousel.querySelector('.carousel-nav.prev');
        const nextBtn = carousel.querySelector('.carousel-nav.next');

        const totalOriginalCards = originalCards.length;
        const cardWidth = {$cardWidthTotal};
        const cloneMultiplier = 3;

        let currentIndex = totalOriginalCards * cloneMultiplier;
        let isAnimating = false;

        function initInfiniteCarousel() {
            track.innerHTML = '';

            for (let i = 0; i < cloneMultiplier; i++) {
                originalCards.forEach(card => {
                    const clone = card.cloneNode(true);
                    track.appendChild(clone);
                });
            }

            originalCards.forEach(card => {
                track.appendChild(card);
            });

            for (let i = 0; i < cloneMultiplier; i++) {
                originalCards.forEach(card => {
                    const clone = card.cloneNode(true);
                    track.appendChild(clone);
                });
            }

            updatePosition(false);
        }

        function updatePosition(animate = true) {
            const offset = -(currentIndex * cardWidth) + (window.innerWidth / 2) - (cardWidth / 2);

            if (!animate) {
                track.classList.add('no-transition');
                track.style.transform = 'translateX(' + offset + 'px)';
                void track.offsetWidth;
                requestAnimationFrame(() => {
                    track.classList.remove('no-transition');
                });
            } else {
                track.style.transform = 'translateX(' + offset + 'px)';
            }
        }

        function checkLoop() {
            const maxIndex = totalOriginalCards * (cloneMultiplier * 2 + 1);
            const minIndex = totalOriginalCards * cloneMultiplier;

            if (currentIndex >= maxIndex - totalOriginalCards) {
                currentIndex = totalOriginalCards * cloneMultiplier + (currentIndex % totalOriginalCards);
                updatePosition(false);
            } else if (currentIndex < minIndex) {
                currentIndex = totalOriginalCards * (cloneMultiplier + 1) - totalOriginalCards + (currentIndex % totalOriginalCards);
                updatePosition(false);
            }
        }

        function next() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex++;
            updatePosition(true);
            setTimeout(() => {
                checkLoop();
                isAnimating = false;
            }, 350);
        }

        function prev() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex--;
            updatePosition(true);
            setTimeout(() => {
                checkLoop();
                isAnimating = false;
            }, 350);
        }

        if (nextBtn) nextBtn.addEventListener('click', next);
        if (prevBtn) prevBtn.addEventListener('click', prev);

        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                updatePosition(false);
            }, 100);
        });

        initInfiniteCarousel();
    })();
JS;
    }

    protected function getDefaultItems()
    {
        return [
            ['image' => "@web/images/hero-background.jpg", 'title' => '1', 'distrito' => 'A'],
            ['image' => "@web/images/hero-background.jpg", 'title' => '2', 'distrito' => 'B'],
            ['image' => "@web/images/hero-background.jpg", 'title' => '3', 'distrito' => 'C'],
            ['image' => "@web/images/hero-background.jpg", 'title' => '4', 'distrito' => 'D'],
            ['image' => "@web/images/hero-background.jpg", 'title' => '5', 'distrito' => 'E'],
            ['image' => "@web/images/hero-background.jpg", 'title' => '6', 'distrito' => 'F'],
        ];
    }
}