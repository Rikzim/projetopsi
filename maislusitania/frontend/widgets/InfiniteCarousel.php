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
    public $cardWidth = 300;
    
    /**
     * @var int Altura do card em pixels
     */
    public $cardHeight = 500;
    
    /**
     * @var int Gap entre cards em rem
     */
    public $cardGap = 1.5;
    
    /**
     * @var string ID único do carrossel
     */
    public $carouselId;

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
            border-radius: 15px;
            overflow: hidden;
            height: {$this->cardHeight}px;
            width: {$this->cardWidth}px;
            position: relative;
            user-select: none;
        }
        
        #{$this->carouselId} .card-img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            filter: brightness(0.7);
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        #{$this->carouselId} .carousel-card .card:hover .card-img {
            transform: scale(1.05);
            filter: brightness(0.5);
        }
        
        #{$this->carouselId} .card-img-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
            padding: 2rem;
            pointer-events: none;
        }
        
        #{$this->carouselId} .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        #{$this->carouselId} .card-text {
            font-size: 1rem;
            font-weight: 300;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        #{$this->carouselId} {
            position: relative;
            padding-top: 80px;
            padding-bottom: 30px;
            overflow: visible;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            padding-left: 0;
            padding-right: 0;
        }
        
        #{$this->carouselId} .carousel-wrapper {
            overflow: hidden;
            width: 100%;
            cursor: grab;
        }
        
        #{$this->carouselId} .carousel-wrapper.grabbing {
            cursor: grabbing;
        }
        
        #{$this->carouselId} .carousel-track {
            display: flex;
            gap: {$this->cardGap}rem;
            transition: transform 0.3s ease;
            padding: 0 50px;
            will-change: transform;
        }
        
        #{$this->carouselId} .carousel-track.no-transition {
            transition: none;
        }
        
        #{$this->carouselId} .carousel-track .carousel-card {
            flex: 0 0 {$this->cardWidth}px;
            min-width: {$this->cardWidth}px;
        }

        @media (max-width: 768px) {
            #{$this->carouselId} .carousel-track {
                padding: 0 30px;
            }
        }

        @media (max-width: 576px) {
            #{$this->carouselId} .carousel-track {
                padding: 0 20px;
            }
        }
CSS;
    }

    protected function getJs()
    {
        $cardGapPx = $this->cardGap * 16; // Converter rem para px (assumindo 1rem = 16px)
        $cardWidthTotal = $this->cardWidth + $cardGapPx;
        
        return <<<JS
        (function() {
            const wrapper = document.getElementById('{$this->carouselId}').querySelector('.carousel-wrapper');
            const track = document.getElementById('{$this->carouselId}').querySelector('.carousel-track');
            const cards = Array.from(track.children);
            const totalCards = cards.length;
            const cardWidth = {$cardWidthTotal};

            let isDragging = false;
            let startX = 0;
            let currentTranslate = 0;
            let prevTranslate = 0;
            let animationID;

            function initInfiniteCarousel() {
                cards.forEach(card => {
                    const clone = card.cloneNode(true);
                    track.appendChild(clone);
                });
                
                cards.forEach(card => {
                    const clone = card.cloneNode(true);
                    track.insertBefore(clone, track.firstChild);
                });
                
                currentTranslate = -(totalCards * cardWidth);
                prevTranslate = currentTranslate;
                setSliderPosition();
            }

            function setSliderPosition() {
                track.style.transform = 'translateX(' + currentTranslate + 'px)';
            }

            function checkInfiniteLoop() {
                const maxTranslate = -(totalCards * 2 * cardWidth);
                const minTranslate = -(totalCards * cardWidth * 0.5);
                
                if (currentTranslate <= maxTranslate + cardWidth) {
                    track.style.transition = 'none';
                    currentTranslate = -(totalCards * cardWidth) + (currentTranslate - maxTranslate);
                    prevTranslate = currentTranslate;
                    setSliderPosition();
                    setTimeout(function() {
                        track.style.transition = 'transform 0.3s ease';
                    }, 10);
                }
                
                if (currentTranslate >= minTranslate) {
                    track.style.transition = 'none';
                    currentTranslate = -(totalCards * cardWidth) - (minTranslate - currentTranslate);
                    prevTranslate = currentTranslate;
                    setSliderPosition();
                    setTimeout(function() {
                        track.style.transition = 'transform 0.3s ease';
                    }, 10);
                }
            }

            function touchStart(event) {
                isDragging = true;
                startX = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
                wrapper.classList.add('grabbing');
                track.classList.add('no-transition');
                animationID = requestAnimationFrame(animation);
            }

            function touchMove(event) {
                if (isDragging) {
                    const currentX = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
                    const diff = currentX - startX;
                    currentTranslate = prevTranslate + diff;
                }
            }

            function touchEnd() {
                isDragging = false;
                wrapper.classList.remove('grabbing');
                track.classList.remove('no-transition');
                cancelAnimationFrame(animationID);
                
                prevTranslate = currentTranslate;
                checkInfiniteLoop();
            }

            function animation() {
                setSliderPosition();
                if (isDragging) requestAnimationFrame(animation);
            }

            function handleWheel(event) {
                event.preventDefault();
                
                const delta = event.deltaY || event.deltaX;
                const scrollAmount = delta * 2;
                
                currentTranslate -= scrollAmount;
                prevTranslate = currentTranslate;
                
                setSliderPosition();
                checkInfiniteLoop();
            }

            wrapper.addEventListener('mousedown', touchStart);
            wrapper.addEventListener('mousemove', touchMove);
            wrapper.addEventListener('mouseup', touchEnd);
            wrapper.addEventListener('mouseleave', touchEnd);

            wrapper.addEventListener('touchstart', touchStart);
            wrapper.addEventListener('touchmove', touchMove);
            wrapper.addEventListener('touchend', touchEnd);

            wrapper.addEventListener('wheel', handleWheel, { passive: false });

            wrapper.addEventListener('dragstart', function(e) { e.preventDefault(); });

            initInfiniteCarousel();
        })();
JS;
    }

    protected function getDefaultItems()
    {
        return [
            ['image' => 'https://picsum.photos/id/21/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
            ['image' => 'https://picsum.photos/id/242/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
            ['image' => 'https://picsum.photos/id/533/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
            ['image' => 'https://picsum.photos/id/119/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
            ['image' => 'https://picsum.photos/id/180/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
            ['image' => 'https://picsum.photos/id/201/400/600.jpg', 'title' => 'Working Spaces', 'subtitle' => 'for Startups Freelancer'],
        ];
    }
}