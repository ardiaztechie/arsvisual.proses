// ==================== INITIALIZATION ====================
$(document).ready(function() {
    'use strict';

    // ==================== VARIABLES ====================
    const $window = $(window);
    const $document = $(document);
    const $nav = $('nav');
    const $tombolMenu = $('.tombol-menu');
    const $menu = $('nav .menu');
    const $menuLinks = $('nav .menu ul li a');
    
    // ==================== MOBILE MENU ====================
    function initMobileMenu() {
        $tombolMenu.off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $menu.toggleClass('active');
            $(this).toggleClass('active');
            
            // Animate hamburger menu
            if ($(this).hasClass('active')) {
                $(this).find('.garis').eq(0).css('transform', 'rotate(45deg) translateY(10px)');
                $(this).find('.garis').eq(1).css('opacity', '0');
                $(this).find('.garis').eq(2).css('transform', 'rotate(-45deg) translateY(-10px)');
            } else {
                $(this).find('.garis').css({
                    'transform': 'none',
                    'opacity': '1'
                });
            }
        });

        // Close menu when clicking on links
        $menuLinks.on('click', function() {
            if ($window.width() < 992) {
                $menu.removeClass('active');
                $tombolMenu.removeClass('active');
                $tombolMenu.find('.garis').css({
                    'transform': 'none',
                    'opacity': '1'
                });
            }
        });

        // Close menu when clicking outside
        $document.on('click', function(e) {
            if (!$(e.target).closest('.menu, .tombol-menu').length) {
                $menu.removeClass('active');
                $tombolMenu.removeClass('active');
                $tombolMenu.find('.garis').css({
                    'transform': 'none',
                    'opacity': '1'
                });
            }
        });
    }

    // ==================== STICKY NAVIGATION ====================
    function initStickyNav() {
        let lastScroll = 0;
        const navHeight = $nav.outerHeight();
        
        $window.on('scroll', function() {
            const currentScroll = $window.scrollTop();
            
            // Add/Remove white background
            if (currentScroll > 50) {
                $nav.addClass('putih');
            } else {
                $nav.removeClass('putih');
            }
            
            // Hide/Show nav on scroll (optional)
            if (currentScroll > lastScroll && currentScroll > navHeight) {
                // Scrolling down
                $nav.css('transform', 'translateY(-100%)');
            } else {
                // Scrolling up
                $nav.css('transform', 'translateY(0)');
            }
            
            lastScroll = currentScroll;
        });
    }

    // ==================== SMOOTH SCROLL ====================
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this).attr('href');
            
            if (target !== '#' && $(target).length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 80
                }, 800, 'easeInOutCubic');
            }
        });
    }

    // ==================== PORTFOLIO FILTER ====================
    function initPortfolioFilter() {
        const $filterBtns = $('.filter-btn');
        const $galleryItems = $('.gallery-item');
        
        $filterBtns.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            $filterBtns.removeClass('active');
            $(this).addClass('active');
            
            // Filter items with animation
            $galleryItems.fadeOut(300, function() {
                if (filter === 'all') {
                    $galleryItems.fadeIn(400);
                } else {
                    $galleryItems.each(function() {
                        if ($(this).data('category') === filter) {
                            $(this).fadeIn(400);
                        }
                    });
                }
            });
        });
    }

    // ==================== SCROLL REVEAL ANIMATION ====================
    function initScrollReveal() {
        const reveals = document.querySelectorAll('.service-card, .team-member, .blog-card, .stat-item, .support > div');
        
        function reveal() {
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('reveal', 'active');
                }
            });
        }
        
        window.addEventListener('scroll', reveal);
        reveal(); // Initial check
    }

    // ==================== COUNTER ANIMATION ====================
    function initCounters() {
        let hasAnimated = false;
        
        function animateCounters() {
            if (hasAnimated) return;
            
            const statsSection = document.querySelector('.stats');
            if (!statsSection) return;
            
            const rect = statsSection.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;
            
            if (isVisible) {
                hasAnimated = true;
                
                $('.stat-item h2').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text().replace(/\D/g, ''));
                    const suffix = $this.text().replace(/[0-9]/g, '');
                    
                    $({ countNum: 0 }).animate({
                        countNum: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum) + suffix);
                        },
                        complete: function() {
                            $this.text(countTo + suffix);
                        }
                    });
                });
            }
        }
        
        $(window).on('scroll', animateCounters);
        animateCounters(); // Initial check
    }

    // ==================== TESTIMONIAL SLIDER ====================
    function initTestimonialSlider() {
        const testimonials = [
            {
                text: "ARS Visual berhasil mengabadikan hari pernikahan kami dengan sempurna. Hasilnya melebihi ekspektasi!",
                author: "Rina & Dimas, Jakarta"
            },
            {
                text: "Profesional, kreatif, dan hasil foto produk kami jadi sangat menarik. Penjualan meningkat drastis!",
                author: "Budi Santoso, Owner Toko Online"
            },
            {
                text: "Video company profile yang dibuat ARS Visual sangat memukau. Klien kami terkesan!",
                author: "PT. Maju Jaya, Surabaya"
            },
            {
                text: "Dokumentasi event kami sangat profesional. Setiap momen penting terabadikan dengan sempurna.",
                author: "Maya Kartika, Event Organizer"
            }
        ];
        
        let currentIndex = 0;
        const $testimonialText = $('.testimonial-text');
        const $testimonialAuthor = $('.testimonial-author');
        
        function showTestimonial(index) {
            $testimonialText.fadeOut(300, function() {
                $(this).text('"' + testimonials[index].text + '"').fadeIn(300);
            });
            
            $testimonialAuthor.fadeOut(300, function() {
                $(this).text('- ' + testimonials[index].author).fadeIn(300);
            });
        }
        
        // Auto rotate testimonials
        setInterval(function() {
            currentIndex = (currentIndex + 1) % testimonials.length;
            showTestimonial(currentIndex);
        }, 5000);
    }

    // ==================== PARALLAX EFFECT ====================
    function initParallax() {
        $window.on('scroll', function() {
            const scrolled = $window.scrollTop();
            
            // Hero video parallax
            $('header video').css('transform', 'translate(-50%, ' + (-50 + scrolled * 0.5) + '%)');
            
            // Quote section parallax
            $('.quote').css('background-position', 'center ' + (scrolled * 0.5) + 'px');
        });
    }

    // ==================== FORM VALIDATION ====================
    function initFormValidation() {
        $('.contact-form form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalText = $submitBtn.text();
            
            // Simple validation
            let isValid = true;
            
            $form.find('input[required], textarea[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).css('border-color', '#00c2ccff');
                    
                    setTimeout(() => {
                        $(this).css('border-color', '#e0e0e0');
                    }, 3000);
                }
            });
            
            if (!isValid) {
                alert('Mohon lengkapi semua field yang diperlukan!');
                return false;
            }
            
            // Simulate form submission
            $submitBtn.text('Sending...').prop('disabled', true);
            
            setTimeout(function() {
                $submitBtn.text('Message Sent! ✓').css('background', '#27ae60');
                
                setTimeout(function() {
                    $form[0].reset();
                    $submitBtn.text(originalText).css('background', '').prop('disabled', false);
                    alert('Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
                }, 2000);
            }, 1500);
        });
        
        // Real-time validation feedback
        $('.contact-form input, .contact-form textarea, .contact-form select').on('focus', function() {
            $(this).css('border-color', '#01a3bbff');
        }).on('blur', function() {
            if ($(this).val()) {
                $(this).css('border-color', '#27ae60');
            } else {
                $(this).css('border-color', '#e0e0e0');
            }
        });
    }

    // ==================== LAZY LOADING IMAGES ====================
    function initLazyLoad() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }

    // ==================== GALLERY LIGHTBOX ====================
    function initGalleryLightbox() {
        const $galleryItems = $('.gallery-item');
        
        // Create lightbox HTML
        if (!$('#lightbox').length) {
            $('body').append(`
                <div id="lightbox" class="lightbox">
                    <span class="lightbox-close">&times;</span>
                    <span class="lightbox-prev">&#10094;</span>
                    <span class="lightbox-next">&#10095;</span>
                    <img class="lightbox-img" src="" alt="">
                    <div class="lightbox-caption"></div>
                </div>
            `);
        }
        
        const $lightbox = $('#lightbox');
        const $lightboxImg = $('.lightbox-img');
        const $lightboxCaption = $('.lightbox-caption');
        let currentImageIndex = 0;
        
        // Open lightbox
        $galleryItems.on('click', function() {
            currentImageIndex = $galleryItems.index(this);
            showLightboxImage(currentImageIndex);
            $lightbox.fadeIn(300);
            $('body').css('overflow', 'hidden');
        });
        
        // Close lightbox
        $('.lightbox-close').on('click', function() {
            $lightbox.fadeOut(300);
            $('body').css('overflow', '');
        });
        
        // Navigate lightbox
        $('.lightbox-prev').on('click', function() {
            currentImageIndex = (currentImageIndex - 1 + $galleryItems.length) % $galleryItems.length;
            showLightboxImage(currentImageIndex);
        });
        
        $('.lightbox-next').on('click', function() {
            currentImageIndex = (currentImageIndex + 1) % $galleryItems.length;
            showLightboxImage(currentImageIndex);
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($lightbox.is(':visible')) {
                if (e.key === 'Escape') {
                    $lightbox.fadeOut(300);
                    $('body').css('overflow', '');
                } else if (e.key === 'ArrowLeft') {
                    $('.lightbox-prev').click();
                } else if (e.key === 'ArrowRight') {
                    $('.lightbox-next').click();
                }
            }
        });
        
        function showLightboxImage(index) {
            const $item = $galleryItems.eq(index);
            const imgSrc = $item.find('img').attr('src');
            const title = $item.find('.gallery-overlay h5').text();
            const category = $item.find('.gallery-overlay p').text();
            
            $lightboxImg.attr('src', imgSrc);
            $lightboxCaption.html(`<h4>${title}</h4><p>${category}</p>`);
        }
    }

    // ==================== PAGE LOADER ====================

    function initPageLoader() {
        // Create loader HTML
        if (!$('#page-loader').length) {
            $('body').prepend(`
                <div id="page-loader">
                    <div class="loader-content">
                        <div class="loader-spinner"></div>
                        <p>Loading ARS Visual...</p>
                    </div>
                </div>
            `);
        }
        
        $(window).on('load', function() {
            $('#page-loader').fadeOut(600, function() {
                $(this).remove();
            });
        });
    }

    

    // ==================== TYPING EFFECT ====================

    function initTypingEffect() {
        const $heroTitle = $('header .intro h1');
        if (!$heroTitle.length) return;
        
        const originalText = $heroTitle.text();
        $heroTitle.text('');
        
        let charIndex = 0;
        
        function typeWriter() {
            if (charIndex < originalText.length) {
                $heroTitle.text($heroTitle.text() + originalText.charAt(charIndex));
                charIndex++;
                setTimeout(typeWriter, 80);
            }
        }
        
        setTimeout(typeWriter, 500);
    }

    // ==================== ACTIVE SECTION HIGHLIGHT ====================

    function initActiveSection() {
        const sections = document.querySelectorAll('section[id]');
        
        function highlightNav() {
            const scrollY = window.pageYOffset;
            
            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    $('nav .menu ul li a').removeClass('active');
                    $('nav .menu ul li a[href="#' + sectionId + '"]').addClass('active');
                }
            });
        }
        
        window.addEventListener('scroll', highlightNav);
    }

    // ==================== ADD CUSTOM EASING ====================

    $.easing.easeInOutCubic = function(x) {
        return x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2;
    };

    // ==================== INITIALIZE ALL FUNCTIONS ====================

    function init() {
        initMobileMenu();
        initStickyNav();
        initSmoothScroll();
        initPortfolioFilter();
        initScrollReveal();
        initCounters();
        initTestimonialSlider();
        initParallax();
        initFormValidation();
        initLazyLoad();
        initGalleryLightbox();
        initPageLoader();
        initScrollToTop();
        initTypingEffect();
        initCustomCursor();
        initActiveSection();
    }

    // Run initialization
    init();

    // ==================== WINDOW RESIZE HANDLER ====================

    let resizeTimer;
    $window.on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Reinitialize mobile menu if needed
            if ($window.width() >= 992) {
                $menu.removeClass('active');
                $tombolMenu.removeClass('active');
            }
        }, 250);
    });

    // ==================== PERFORMANCE OPTIMIZATION ====================
    
    // Debounce scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Log page load time (for development)
    window.addEventListener('load', function() {
        const loadTime = window.performance.timing.domContentLoadedEventEnd - 
                        window.performance.timing.navigationStart;
        console.log('Page loaded in ' + loadTime + 'ms');
    });
});

// ==================== ADD STYLES FOR CUSTOM ELEMENTS ====================
$(document).ready(function() {
    const customStyles = `
        <style>
            /* Lightbox Styles */
            .lightbox {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.95);
                z-index: 9999;
                justify-content: center;
                align-items: center;
            }
            
            .lightbox-img {
                max-width: 90%;
                max-height: 80vh;
                object-fit: contain;
                animation: zoomIn 0.3s ease;
            }
            
            .lightbox-close {
                position: absolute;
                top: 20px;
                right: 40px;
                font-size: 50px;
                color: white;
                cursor: pointer;
                transition: all 0.3s;
            }
            
            .lightbox-close:hover {
                transform: rotate(90deg);
                color: #c86b85;
            }
            
            .lightbox-prev,
            .lightbox-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                font-size: 40px;
                color: white;
                cursor: pointer;
                padding: 20px;
                user-select: none;
                transition: all 0.3s;
            }
            
            .lightbox-prev:hover,
            .lightbox-next:hover {
                color: #c86b85;
                transform: translateY(-50%) scale(1.2);
            }
            
            .lightbox-prev { left: 20px; }
            .lightbox-next { right: 20px; }
            
            .lightbox-caption {
                position: absolute;
                bottom: 40px;
                text-align: center;
                color: white;
                width: 100%;
            }
            
            .lightbox-caption h4 {
                font-size: 24px;
                margin-bottom: 10px;
            }
            
            /* Page Loader */
            #page-loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: white;
                z-index: 99999;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            .loader-content {
                text-align: center;
            }
            
            .loader-spinner {
                width: 60px;
                height: 60px;
                border: 5px solid #f3f3f3;
                border-top: 5px solid #c86b85;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            /* Scroll to Top Button */
            #scroll-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, #c86b85, #e74c3c);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
                z-index: 1000;
                box-shadow: 0 5px 20px rgba(200,107,133,0.4);
            }
            
            #scroll-top.show {
                opacity: 1;
                visibility: visible;
            }
            
            #scroll-top:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 30px rgba(200,107,133,0.6);
            }
            
            #scroll-top span {
                font-size: 24px;
                font-weight: bold;
            }
            
            /* Custom Cursor */
            .custom-cursor {
                width: 30px;
                height: 30px;
                border: 2px solid #c86b85;
                border-radius: 50%;
                position: fixed;
                pointer-events: none;
                z-index: 10000;
                transition: all 0.1s ease;
                transform: translate(-50%, -50%);
            }
            
            .custom-cursor.expand {
                width: 50px;
                height: 50px;
                background: rgba(200,107,133,0.1);
            }
            
            .custom-cursor-dot {
                width: 5px;
                height: 5px;
                background: #00cafdff;
                border-radius: 50%;
                position: fixed;
                pointer-events: none;
                z-index: 10001;
                transform: translate(-50%, -50%);
            }
            
            /* Active Nav Link */
            nav .menu ul li a.active {
                color: #c86b85;
            }
            
            nav .menu ul li a.active::after {
                width: 100%;
            }
            
            @keyframes zoomIn {
                from {
                    transform: scale(0.8);
                    opacity: 0;
                }
                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }
            
            /* Mobile Responsiveness */
            @media screen and (max-width: 768px) {
                .lightbox-prev,
                .lightbox-next {
                    font-size: 30px;
                    padding: 10px;
                }
                
                .lightbox-close {
                    font-size: 40px;
                    right: 20px;
                }
                
                .custom-cursor,
                .custom-cursor-dot {
                    display: none;
                }
            }
        </style>
    `;
    
    $('head').append(customStyles);
});