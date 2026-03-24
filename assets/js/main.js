/**
 * Grand Mall de Conakry — Main JavaScript
 * Version: 1.0.0
 */

document.addEventListener('DOMContentLoaded', () => {
  initAOS();
  initHeader();
  initMobileMenu();
  initCountUp();
  initSwipers();
});

/* === AOS (Animate On Scroll) === */
function initAOS() {
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 60,
      disable: window.innerWidth < 768 ? 'phone' : false
    });
  }
}

/* === Header scroll effect === */
function initHeader() {
  const header = document.getElementById('header');
  if (!header) return;
  const check = () => header.classList.toggle('scrolled', window.scrollY > 60);
  window.addEventListener('scroll', check, { passive: true });
  check();
}

/* === Mobile menu === */
function initMobileMenu() {
  const toggle = document.getElementById('menu-toggle');
  const nav = document.getElementById('nav-links');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    nav.classList.toggle('active');
    document.body.style.overflow = nav.classList.contains('active') ? 'hidden' : '';
  });

  nav.querySelectorAll('.nav-link').forEach(link =>
    link.addEventListener('click', () => {
      toggle.classList.remove('active');
      nav.classList.remove('active');
      document.body.style.overflow = '';
    })
  );

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && nav.classList.contains('active')) {
      toggle.classList.remove('active');
      nav.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
}

/* === Count-up animation === */
function initCountUp() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCount(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(el => observer.observe(el));
}

function animateCount(el) {
  const target = parseInt(el.dataset.count, 10);
  const suffix = el.dataset.suffix || '';
  const prefix = el.dataset.prefix || '';
  const duration = 2000;
  const start = performance.now();

  function update(now) {
    const elapsed = now - start;
    const progress = Math.min(elapsed / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    const current = Math.round(target * ease);

    el.textContent = prefix + current.toLocaleString('fr-FR') + suffix;
    if (progress < 1) requestAnimationFrame(update);
  }
  requestAnimationFrame(update);
}

/* === Swiper sliders === */
function initSwipers() {
  if (typeof Swiper === 'undefined') return;

  // Hero slider
  if (document.querySelector('.hero-swiper')) {
    new Swiper('.hero-swiper', {
      loop: true,
      speed: 1200,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: { delay: 5000, disableOnInteraction: false },
      pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
    });
  }

  // News slider (mobile)
  if (document.querySelector('.news-swiper')) {
    new Swiper('.news-swiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      pagination: { el: '.news-swiper .swiper-pagination', clickable: true },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      }
    });
  }

  // Gallery swiper
  if (document.querySelector('.gallery-swiper')) {
    new Swiper('.gallery-swiper', {
      slidesPerView: 1,
      spaceBetween: 16,
      loop: true,
      autoplay: { delay: 3000 },
      pagination: { el: '.gallery-swiper .swiper-pagination', clickable: true },
      breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1280: { slidesPerView: 4 },
      }
    });
  }
}

/* === Smooth scroll for anchor links === */
document.addEventListener('click', e => {
  const link = e.target.closest('a[href^="#"]');
  if (!link) return;
  e.preventDefault();
  const target = document.querySelector(link.getAttribute('href'));
  if (target) {
    const offset = document.getElementById('header')?.offsetHeight || 0;
    window.scrollTo({
      top: target.getBoundingClientRect().top + window.scrollY - offset,
      behavior: 'smooth'
    });
  }
});
