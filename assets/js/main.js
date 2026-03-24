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

    // === CUSTOM CURSOR ===
    const cursor = document.getElementById('cursor');
    const follower = document.getElementById('cursor-follower');
    if (cursor && follower && window.innerWidth > 1024) {
        let mouseX = 0, mouseY = 0, cursorX = 0, cursorY = 0, followerX = 0, followerY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursor.classList.add('active');
            follower.classList.add('active');
        });

        document.addEventListener('mouseleave', () => {
            cursor.classList.remove('active');
            follower.classList.remove('active');
        });

        // Hover effect on interactive elements
        const hoverTargets = document.querySelectorAll('a, button, .service-card, .news-card, .boutique-card, .gallery-preview-item, .gallery-item');
        hoverTargets.forEach(el => {
            el.addEventListener('mouseenter', () => follower.classList.add('hovering'));
            el.addEventListener('mouseleave', () => follower.classList.remove('hovering'));
        });

        function animateCursor() {
            cursorX += (mouseX - cursorX) * 0.2;
            cursorY += (mouseY - cursorY) * 0.2;
            followerX += (mouseX - followerX) * 0.08;
            followerY += (mouseY - followerY) * 0.08;

            cursor.style.transform = `translate(${cursorX - 4}px, ${cursorY - 4}px)`;
            follower.style.transform = `translate(${followerX - 18}px, ${followerY - 18}px)`;
            requestAnimationFrame(animateCursor);
        }
        animateCursor();
        document.body.style.cursor = 'none';
        document.querySelectorAll('a, button').forEach(el => el.style.cursor = 'none');
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
});
