/**
 * Grand Mall de Conakry — Main JavaScript
 * Version 2.0 — Enhanced with slider, cursor, parallax
 */

document.addEventListener('DOMContentLoaded', () => {
    // === AOS Init ===
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
            disable: window.innerWidth < 768 ? 'mobile' : false
        });
    }

    // === Header Scroll ===
    const header = document.getElementById('header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            header.classList.toggle('scrolled', y > 50);
            // Hide on scroll down, show on scroll up
            if (y > 300) {
                header.style.transform = y > lastScroll ? 'translateY(-100%)' : 'translateY(0)';
            } else {
                header.style.transform = 'translateY(0)';
            }
            lastScroll = y;
        }, { passive: true });
        header.style.transition = 'transform 0.35s ease, background 0.35s ease, box-shadow 0.35s ease';
    }

    // === Mobile Menu ===
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
        navLinks.querySelectorAll('.nav-link').forEach(link =>
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.style.overflow = '';
            })
        );
    }

    // === HERO SWIPER ===
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 1200,
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            parallax: true,
            pagination: {
                el: '.hero-pagination',
                clickable: true
            },
            navigation: {
                prevEl: '.hero-btn-prev',
                nextEl: '.hero-btn-next'
            },
            on: {
                slideChange: function () {
                    // Reset and re-trigger animations on slide change
                    const activeSlide = this.slides[this.activeIndex];
                    const bg = activeSlide.querySelector('.hero-slide-bg');
                    if (bg) {
                        bg.style.animation = 'none';
                        bg.offsetHeight; // trigger reflow
                        bg.style.animation = '';
                    }
                }
            }
        });
    }

    // === PROJECT SWIPER ===
    if (document.querySelector('.project-swiper')) {
        new Swiper('.project-swiper', {
            effect: 'slide',
            speed: 800,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.project-swiper .swiper-pagination', clickable: true },
            grabCursor: true
        });
    }

    // === COUNT-UP ANIMATION ===
    const countElements = document.querySelectorAll('[data-count]');
    if (countElements.length) {
        const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    animateCount(entry.target);
                }
            });
        }, { threshold: 0.3 });
        countElements.forEach(el => countObserver.observe(el));
    }

    function animateCount(el) {
        const target = parseInt(el.dataset.count, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 2500;
        const startTime = performance.now();

        function easeOutExpo(t) {
            return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
        }

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeOutExpo(progress);
            const current = Math.floor(easedProgress * target);
            el.textContent = current.toLocaleString('fr-FR') + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }

    // === ADVANCED MOUSE TRAIL CURSOR ===
    const isDesktop = window.innerWidth > 1024;
    // Remove old cursor elements if any (fallback handling)
    const oldCursor = document.getElementById('cursor');
    const oldFollower = document.getElementById('cursor-follower');
    if (oldCursor) oldCursor.remove();
    if (oldFollower) oldFollower.remove();

    if (isDesktop) {
        // Create new trail elements
        const trailElements = [];
        const numDots = 12;
        for (let i = 0; i < numDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'cursor-trail-dot';
            document.body.appendChild(dot);
            trailElements.push({
                element: dot,
                x: window.innerWidth / 2,
                y: window.innerHeight / 2
            });
        }

        let mouseX = window.innerWidth / 2;
        let mouseY = window.innerHeight / 2;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            trailElements.forEach(item => item.element.style.opacity = '1');
        });

        document.addEventListener('mouseleave', () => {
            trailElements.forEach(item => item.element.style.opacity = '0');
        });

        // Hover effect for links
        let isHovering = false;
        const interactionTargets = document.querySelectorAll('a, button, .service-card, .news-card, .boutique-card, .gallery-preview-item');
        interactionTargets.forEach(el => {
            el.addEventListener('mouseenter', () => isHovering = true);
            el.addEventListener('mouseleave', () => isHovering = false);
        });

        function animateTrail() {
            let x = mouseX;
            let y = mouseY;

            trailElements.forEach((item, index) => {
                // Ease towards the target (the previous dot or mouse)
                item.x += (x - item.x) * 0.3;
                item.y += (y - item.y) * 0.3;

                // Set scale based on hover and index
                const scale = isHovering && index === 0 ? 3 : (1 - index / numDots);
                const opacity = isHovering && index > 0 ? 0 : (1 - index / numDots);

                item.element.style.transform = `translate(${item.x}px, ${item.y}px) scale(${scale})`;
                if (!isHovering) item.element.style.opacity = opacity;

                // Update target for the next dot to be the current dot's position
                x = item.x;
                y = item.y;
            });

            requestAnimationFrame(animateTrail);
        }
        animateTrail();

        // Hide default cursor
        document.body.style.cursor = 'none';
        document.querySelectorAll('a, button, input, select, textarea').forEach(el => {
            el.style.cursor = 'none';
        });
    }

    // === PARALLAX ON SCROLL ===
    const parallaxElements = document.querySelectorAll('.cta-bg');
    if (parallaxElements.length && window.innerWidth > 768) {
        window.addEventListener('scroll', () => {
            parallaxElements.forEach(el => {
                const rect = el.parentElement.getBoundingClientRect();
                const speed = 0.3;
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const offset = (rect.top - window.innerHeight / 2) * speed;
                    el.style.transform = `translateY(${offset}px)`;
                }
            });
        }, { passive: true });
    }

    // === SMOOTH SCROLL ===
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // === REVEAL ANIMATION (stagger) ===
    const revealCards = document.querySelectorAll('.service-card, .stat-item, .news-card');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    revealCards.forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${i * 0.08}s, transform 0.6s ease ${i * 0.08}s`;
        revealObserver.observe(card);
    });

    // === MAGNETIC BUTTONS ===
    const magneticButtons = document.querySelectorAll('.magnetic-btn');
    magneticButtons.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translate(0px, 0px)';
        });
    });

    // === 3D TILT HOVER CARDS ===
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -10; // Max 10 deg
            const rotateY = ((x - centerX) / centerX) * 10;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });

    // === TEXT REVEAL ON SCROLL ===
    const revealTexts = document.querySelectorAll('.reveal-text');
    const textObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.5 });
    
    // Auto-trigger for elements already in viewport on load (like hero)
    setTimeout(() => {
        revealTexts.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('active');
            } else {
                textObserver.observe(el);
            }
        });
    }, 100);

    // === PAGE TRANSITIONS ===
    const ptOverlay = document.getElementById('page-transition');
    if (ptOverlay) {
        // Fade out on page load
        ptOverlay.classList.remove('active');

        // Intercept internal link clicks for smooth transition
        document.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:') || link.target === '_blank' || href.startsWith('http') && !href.includes(window.location.hostname)) return;
            link.addEventListener('click', function(e) {
                e.preventDefault();
                ptOverlay.classList.add('active');
                setTimeout(() => { window.location.href = href; }, 400);
            });
        });
    }

});
