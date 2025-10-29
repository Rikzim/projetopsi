<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class InfiniteCarousel extends Widget
{
    /**
     * @var array Lista de items do carrossel
     * Formato: [
     *     ['image' => 'url', 'title' => 'Título', 'subtitle' => 'Subtítulo'],
     *     ...
     * ]
     */
    public $items = [];
    
    /**
     * @var int Largura do card em pixels
     */
    public $cardWidth = 400;
    
    /**
     * @var int Altura do card em pixels
     */
    public $cardHeight = 250;
    
    /**
     * @var int Gap entre cards em rem
     */
    public $cardGap = 1;
    
    /**
     * @var string ID único do carrossel
     */
    public $carouselId;
    
    /**
     * @var string Cor de fundo do carrossel
     */
    public $backgroundColor = '#3498db';

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
        return $this->render('infinite-carousel', [
            'items' => $this->items,
            'cardWidth' => $this->cardWidth,
            'cardHeight' => $this->cardHeight,
            'cardGap' => $this->cardGap,
            'carouselId' => $this->carouselId,
            'backgroundColor' => $this->backgroundColor,
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->getView();
        
        // CSS
        $css = $this->getCss();
        $view->registerCss($css);
        
        // JavaScript
        $js = $this->getJs();
        $view->registerJs($js, \yii\web\View::POS_READY);
    }

protected function getCss()
{
    return <<<CSS
    
    #{$this->carouselId} .carousel-card .card {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    #{$this->carouselId} .carousel-card a.card {
        cursor: pointer;
    }
    
    #{$this->carouselId} {
        position: relative;
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        background: {$this->backgroundColor};
        padding: 80px 0;
        overflow: hidden;
    }
    
    #{$this->carouselId} .carousel-container {
        position: relative;
        width: 100%;
        height: calc({$this->cardHeight}px + 40px);
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
        border-radius: 25px;
        overflow: hidden;
        height: 100%;
        width: 100%;
        position: relative;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        transform-origin: center center;
    }
    
    #{$this->carouselId} .carousel-card .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        z-index: 5;
    }
    
    #{$this->carouselId} .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    #{$this->carouselId} .card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
        padding: 20px;
        color: white;
    }
    
    #{$this->carouselId} .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 0 5px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    }
    
    #{$this->carouselId} .card-subtitle {
        font-size: 1rem;
        margin: 0;
        opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
    }
    
    #{$this->carouselId} .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        user-select: none;
    }
    
    #{$this->carouselId} .carousel-nav:hover {
        background: #f0f0f0;
        transform: translateY(-50%) scale(1.1);
    }
    
    #{$this->carouselId} .carousel-nav.prev {
        left: 20px;
    }
    
    #{$this->carouselId} .carousel-nav.next {
        right: 20px;
    }
    
    #{$this->carouselId} .carousel-nav svg {
        width: 24px;
        height: 24px;
        fill: #3498db;
    }
    
    @media (max-width: 768px) {
        #{$this->carouselId} .carousel-card {
            flex: 0 0 300px;
            min-width: 300px;
        }
        
        #{$this->carouselId} .carousel-nav {
            width: 40px;
            height: 40px;
        }
        
        #{$this->carouselId} .card-title {
            font-size: 1.2rem;
        }
        
        #{$this->carouselId} .card-subtitle {
            font-size: 0.9rem;
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
            let wheelTimeout;
            
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
            
            wrapper.addEventListener('wheel', function(e) {
                e.preventDefault();
                clearTimeout(wheelTimeout);
                wheelTimeout = setTimeout(() => {
                    if (e.deltaY > 0) {
                        next();
                    } else {
                        prev();
                    }
                }, 50);
            }, { passive: false });
            
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
            ['content' => '1'],
            ['content' => '2'],
            ['content' => '3'],
            ['content' => '4'],
            ['content' => '5'],
            ['content' => '6'],
        ];
    }
}