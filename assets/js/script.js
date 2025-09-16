/**
 * Elementor Özel Tasarım Widget'ları - Ana JavaScript Dosyası
 */

(function($) {
    'use strict';

    // DOM yüklendiğinde çalışacak fonksiyonlar
    $(document).ready(function() {
        initLightbox();
        initAnimations();
        initHoverEffects();
    });

    /**
     * Lightbox işlevselliği
     */
    function initLightbox() {
        // Lightbox overlay oluştur
        if ($('.lightbox-overlay').length === 0) {
            $('body').append(`
                <div class="lightbox-overlay">
                    <div class="lightbox-content">
                        <img src="" alt="">
                        <button class="lightbox-close">&times;</button>
                    </div>
                </div>
            `);
        }

        // Lightbox açma
        $(document).on('click', '[data-lightbox]', function(e) {
            e.preventDefault();
            const imageSrc = $(this).attr('href');
            const imageAlt = $(this).find('img').attr('alt') || '';
            
            $('.lightbox-overlay img').attr('src', imageSrc).attr('alt', imageAlt);
            $('.lightbox-overlay').fadeIn(300);
            $('body').css('overflow', 'hidden');
        });

        // Lightbox kapatma
        $(document).on('click', '.lightbox-close, .lightbox-overlay', function(e) {
            if (e.target === this) {
                $('.lightbox-overlay').fadeOut(300);
                $('body').css('overflow', 'auto');
            }
        });

        // ESC tuşu ile kapatma
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $('.lightbox-overlay').is(':visible')) {
                $('.lightbox-overlay').fadeOut(300);
                $('body').css('overflow', 'auto');
            }
        });
    }

    /**
     * Animasyon işlevselliği
     */
    function initAnimations() {
        // Scroll animasyonları
        $(window).on('scroll', function() {
            $('.ozel-kart, .ozel-blog-item, .ozel-portfolio-item, .ozel-testimonial-item').each(function() {
                const elementTop = $(this).offset().top;
                const elementBottom = elementTop + $(this).outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();

                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animate-in');
                }
            });
        });

        // İlk yüklemede animasyonları tetikle
        $(window).trigger('scroll');
    }

    /**
     * Hover efektleri
     */
    function initHoverEffects() {
        // Kart hover efektleri
        $('.ozel-kart').hover(
            function() {
                $(this).addClass('hover-active');
            },
            function() {
                $(this).removeClass('hover-active');
            }
        );

        // Portfolio hover efektleri
        $('.ozel-portfolio-item').hover(
            function() {
                $(this).find('.ozel-portfolio-overlay').addClass('active');
            },
            function() {
                $(this).find('.ozel-portfolio-overlay').removeClass('active');
            }
        );

        // Testimonial hover efektleri
        $('.ozel-testimonial-item').hover(
            function() {
                $(this).addClass('testimonial-hover');
            },
            function() {
                $(this).removeClass('testimonial-hover');
            }
        );
    }

    /**
     * Smooth scroll işlevselliği
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
            }
        });
    }

    /**
     * Lazy loading işlevselliği
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        // WebP desteği kontrolü
                        if (img.dataset.webp && supportsWebP()) {
                            img.src = img.dataset.webp;
                        } else if (img.dataset.src) {
                            img.src = img.dataset.src;
                        } else if (img.src) {
                            // Zaten src varsa kullan
                            img.classList.remove('lazy');
                        }
                        
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

            document.querySelectorAll('img[data-src], img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * WebP desteği kontrolü
     */
    function supportsWebP() {
        const webP = new Image();
        webP.onload = webP.onerror = function() {
            return webP.height === 2;
        };
        webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
        return false; // Varsayılan olarak false döndür
    }

    /**
     * Resim optimizasyonu
     */
    function initImageOptimization() {
        // Resim yükleme hatalarını yakala
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG') {
                const img = e.target;
                
                // Fallback resim yükle
                if (img.dataset.fallback) {
                    img.src = img.dataset.fallback;
                } else {
                    // Placeholder resim
                    img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjBmMGYwIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlPC90ZXh0Pjwvc3ZnPg==';
                }
            }
        }, true);

        // Resim yükleme başarılı olduğunda
        document.addEventListener('load', function(e) {
            if (e.target.tagName === 'IMG') {
                const img = e.target;
                img.classList.add('loaded');
            }
        }, true);
    }

    /**
     * Resim boyutlandırma
     */
    function initImageResizing() {
        // Resim boyutlarını otomatik ayarla
        document.querySelectorAll('.ozel-link-meta-resim img').forEach(img => {
            img.addEventListener('load', function() {
                const container = this.closest('.ozel-link-meta-resim');
                if (container) {
                    const aspectRatio = this.naturalWidth / this.naturalHeight;
                    const containerWidth = container.offsetWidth;
                    const optimalHeight = containerWidth / aspectRatio;
                    
                    if (optimalHeight < container.offsetHeight) {
                        container.style.height = optimalHeight + 'px';
                    }
                }
            });
        });
    }

    /**
     * Responsive grid düzenleme
     */
    function initResponsiveGrid() {
        function adjustGrid() {
            const windowWidth = $(window).width();
            
            // Portfolio grid düzenleme
            $('.ozel-portfolio-grid').each(function() {
                const $grid = $(this);
                const columns = $grid.data('columns') || 3;
                
                if (windowWidth < 768) {
                    $grid.css('grid-template-columns', '1fr');
                } else if (windowWidth < 1024) {
                    $grid.css('grid-template-columns', `repeat(${Math.min(columns, 2)}, 1fr)`);
                } else {
                    $grid.css('grid-template-columns', `repeat(${columns}, 1fr)`);
                }
            });

            // Blog grid düzenleme
            $('.ozel-blog-grid').each(function() {
                const $grid = $(this);
                
                if (windowWidth < 768) {
                    $grid.css('grid-template-columns', '1fr');
                } else if (windowWidth < 1024) {
                    $grid.css('grid-template-columns', 'repeat(2, 1fr)');
                } else {
                    $grid.css('grid-template-columns', 'repeat(3, 1fr)');
                }
            });

            // Testimonial grid düzenleme
            $('.ozel-testimonial-grid').each(function() {
                const $grid = $(this);
                const columns = $grid.data('columns') || 3;
                
                if (windowWidth < 768) {
                    $grid.css('grid-template-columns', '1fr');
                } else if (windowWidth < 1024) {
                    $grid.css('grid-template-columns', `repeat(${Math.min(columns, 2)}, 1fr)`);
                } else {
                    $grid.css('grid-template-columns', `repeat(${columns}, 1fr)`);
                }
            });
        }

        // İlk yüklemede ve pencere boyutu değiştiğinde çalıştır
        adjustGrid();
        $(window).on('resize', adjustGrid);
    }

    /**
     * Parallax efekti
     */
    function initParallax() {
        $(window).on('scroll', function() {
            const scrolled = $(window).scrollTop();
            const parallaxElements = $('.parallax-element');
            
            parallaxElements.each(function() {
                const $element = $(this);
                const speed = $element.data('speed') || 0.5;
                const yPos = -(scrolled * speed);
                $element.css('transform', `translateY(${yPos}px)`);
            });
        });
    }

    /**
     * Counter animasyonu
     */
    function initCounterAnimation() {
        $('.counter').each(function() {
            const $counter = $(this);
            const target = parseInt($counter.text());
            const duration = 2000; // 2 saniye
            const increment = target / (duration / 16); // 60 FPS
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                $counter.text(Math.floor(current));
            }, 16);
        });
    }

    /**
     * Tabs işlevselliği
     */
    function initTabs() {
        $('.tab-trigger').on('click', function(e) {
            e.preventDefault();
            const target = $(this).data('target');
            
            // Aktif tab'ı değiştir
            $('.tab-trigger').removeClass('active');
            $(this).addClass('active');
            
            // İçeriği değiştir
            $('.tab-content').removeClass('active');
            $(target).addClass('active');
        });
    }

    /**
     * Accordion işlevselliği
     */
    function initAccordion() {
        $('.accordion-trigger').on('click', function() {
            const $trigger = $(this);
            const $content = $trigger.next('.accordion-content');
            const $accordion = $trigger.closest('.accordion');
            
            // Diğer accordion'ları kapat
            $accordion.find('.accordion-content').not($content).slideUp();
            $accordion.find('.accordion-trigger').not($trigger).removeClass('active');
            
            // Bu accordion'u aç/kapat
            $content.slideToggle();
            $trigger.toggleClass('active');
        });
    }

    /**
     * Modal işlevselliği
     */
    function initModal() {
        // Modal açma
        $('.modal-trigger').on('click', function(e) {
            e.preventDefault();
            const target = $(this).data('target');
            $(target).fadeIn(300);
            $('body').css('overflow', 'hidden');
        });

        // Modal kapatma
        $('.modal-close, .modal-overlay').on('click', function(e) {
            if (e.target === this) {
                $('.modal').fadeOut(300);
                $('body').css('overflow', 'auto');
            }
        });

        // ESC tuşu ile modal kapatma
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $('.modal:visible').length) {
                $('.modal').fadeOut(300);
                $('body').css('overflow', 'auto');
            }
        });
    }

    /**
     * Form validasyonu
     */
    function initFormValidation() {
        $('.ozel-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            let isValid = true;
            
            // Gerekli alanları kontrol et
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (!value) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }
            });
            
            // Email validasyonu
            $form.find('input[type="email"]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (value && !emailRegex.test(value)) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }
            });
            
            if (isValid) {
                // Form gönderimi
                console.log('Form geçerli, gönderiliyor...');
                // Burada AJAX ile form gönderimi yapılabilir
            }
        });
    }

    // Tüm işlevleri başlat
    $(document).ready(function() {
        initSmoothScroll();
        initLazyLoading();
        initImageOptimization();
        initImageResizing();
        initResponsiveGrid();
        initParallax();
        initCounterAnimation();
        initTabs();
        initAccordion();
        initModal();
        initFormValidation();
    });

    // Window resize olayı
    $(window).on('resize', function() {
        // Responsive grid'i yeniden hesapla
        initResponsiveGrid();
    });

    // Window scroll olayı
    $(window).on('scroll', function() {
        // Parallax efektini güncelle
        initParallax();
    });

})(jQuery);
