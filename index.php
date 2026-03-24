<?php
/**
 * Grand Mall de Conakry — Page d'accueil
 * Version 2.0 — Hero Slider + Design Premium
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$services = Database::fetchAll("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");
$latestNews = Database::fetchAll("SELECT * FROM articles WHERE status = 'published' ORDER BY created_at DESC LIMIT 3");
$sliders = Database::fetchAll("SELECT * FROM sliders WHERE status = 'active' ORDER BY sort_order ASC");

$pageTitle = null;
$pageDescription = SITE_DESCRIPTION;

require_once INCLUDES_PATH . 'header.php';
?>

    <!-- ======= HERO SLIDER FULLSCREEN ======= -->
    <section class="hero-slider" id="accueil">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-slide-bg" style="background-image: url('<?= asset('img/project/entree-principale.jpg') ?>')"></div>
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content container">
                        <div class="hero-badge" data-swiper-parallax="-200">
                            <span class="dot"></span> Un projet Kakandé Immo — Groupe Guicopres
                        </div>
                        <h1 data-swiper-parallax="-300">
                            <span class="reveal-text"><span><span class="thin">Bienvenue au</span></span></span><br>
                            <span class="reveal-text" style="animation-delay: 0.1s"><span><span class="gold">Conakry Mall</span></span></span>
                        </h1>
                        <p data-swiper-parallax="-400">Le plus grand centre commercial de Guinée — 83 000 m² d'expérience shopping, divertissement et bien-être.</p>
                        <div class="hero-buttons" data-swiper-parallax="-500">
                            <a href="<?= SITE_URL ?>/le-projet.php" class="btn btn-gold btn-lg magnetic-btn">Découvrir le projet →</a>
                            <a href="<?= SITE_URL ?>/contact.php" class="btn btn-outline btn-lg magnetic-btn">📍 Nous contacter</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-slide-bg" style="background-image: url('<?= asset('img/project/vue-aerienne.jpg') ?>')"></div>
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content container">
                        <div class="hero-badge" data-swiper-parallax="-200">
                            <span class="dot"></span> Architecture d'exception
                        </div>
                        <h1 data-swiper-parallax="-300">
                            <span class="reveal-text"><span><span class="thin">Une envergure</span></span></span><br>
                            <span class="reveal-text" style="animation-delay: 0.1s"><span><span class="gold">Internationale</span></span></span>
                        </h1>
                        <p data-swiper-parallax="-400">83 000 m² de superficie, 51 000 m² d'infrastructure, 20 escalators, 9 ascenseurs — un projet sans précédent en Afrique de l'Ouest.</p>
                        <div class="hero-buttons" data-swiper-parallax="-500">
                            <a href="<?= SITE_URL ?>/espaces-services.php" class="btn btn-gold btn-lg magnetic-btn">Nos espaces →</a>
                            <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-outline btn-lg magnetic-btn">📸 La galerie</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-slide-bg" style="background-image: url('<?= asset('img/project/galerie-marchande.jpg') ?>')"></div>
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content container">
                        <div class="hero-badge" data-swiper-parallax="-200">
                            <span class="dot"></span> Shopping Premium
                        </div>
                        <h1 data-swiper-parallax="-300">
                            <span class="thin">L'expérience</span><br>
                            <span class="gold">Shopping Ultime</span>
                        </h1>
                        <p data-swiper-parallax="-400">Des boutiques de luxe, une galerie marchande moderne et un espace conçu pour une expérience premium et inoubliable.</p>
                        <div class="hero-buttons" data-swiper-parallax="-500">
                            <a href="<?= SITE_URL ?>/boutiques.php" class="btn btn-gold btn-lg">Les boutiques →</a>
                            <a href="<?= SITE_URL ?>/actualites.php" class="btn btn-outline btn-lg">📰 Actualités</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-slide-bg" style="background-image: url('<?= asset('img/project/cinema-route.jpg') ?>')"></div>
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content container">
                        <div class="hero-badge" data-swiper-parallax="-200">
                            <span class="dot"></span> Loisirs & Divertissement
                        </div>
                        <h1 data-swiper-parallax="-300">
                            <span class="thin">Cinéma, Aquarium</span><br>
                            <span class="gold">& Bien-être</span>
                        </h1>
                        <p data-swiper-parallax="-400">Un univers complet de divertissement : cinéma dernière génération, aquarium, espaces de jeux et centre de bien-être.</p>
                        <div class="hero-buttons" data-swiper-parallax="-500">
                            <a href="<?= SITE_URL ?>/espaces-services.php" class="btn btn-gold btn-lg">Découvrir →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination hero-pagination"></div>
            <div class="hero-nav">
                <button class="hero-btn-prev">‹</button>
                <button class="hero-btn-next">›</button>
            </div>
            <!-- Scroll indicator -->
            <div class="scroll-indicator">
                <span>Scroll</span>
                <div class="scroll-line"></div>
            </div>
        </div>
    </section>

    <!-- ======= SERVICES ======= -->
    <section class="section section-dark" id="services">
        <div class="bg-blob gold"></div>
        <div class="bg-blob blue"></div>
        <div class="container" style="position:relative;z-index:2;">
            <div class="section-bg-number">01</div>
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Nos Espaces</span>
                <h2 class="section-title">Tout sous un même toit</h2>
                <p class="section-desc">Un centre commercial pensé pour offrir une expérience complète : shopping, loisirs, gastronomie et bien-être.</p>
            </div>

            <div class="services-grid">
                <?php foreach ($services as $i => $service): ?>
                <div class="service-card tilt-card" data-aos="fade-up" data-aos-delay="<?= min($i * 80, 320) ?>">
                    <div class="service-icon"><?= e($service['icon']) ?></div>
                    <h3><?= e($service['name']) ?></h3>
                    <p><?= e($service['short_description']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ======= CHIFFRES CLÉS ======= -->
    <section class="section stats-section" id="chiffres">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-aos="fade-up">
                    <div class="stat-number" data-count="83000">0</div>
                    <div class="stat-unit">m²</div>
                    <div class="stat-label">Superficie totale</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number" data-count="4">0</div>
                    <div class="stat-unit">niveaux</div>
                    <div class="stat-label">2 sous-sols + RDC + étage</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number" data-count="20">0</div>
                    <div class="stat-unit">escalators</div>
                    <div class="stat-label">Circulation verticale</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number" data-count="9">0</div>
                    <div class="stat-unit">ascenseurs</div>
                    <div class="stat-label">Accessibilité totale</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= PROJET avec images ======= -->
    <section class="section" id="projet">
        <div class="container">
            <div class="section-bg-number" style="left:auto;right:0;transform:translateY(-40%)">02</div>
            <div class="project-content" style="position:relative;z-index:2;">
                <div class="project-text" data-aos="fade-right">
                    <span class="section-label">Le Projet</span>
                    <h2>Un tournant pour Conakry</h2>
                    <p>
                        Porté par <strong>Kakandé Immo</strong>, filiale du <strong>Groupe Guicopres</strong>, 
                        le Grand Mall de Conakry est un projet ambitieux qui s'étend sur une superficie 
                        impressionnante de <strong>83 000 m²</strong>.
                    </p>
                    <p>
                        L'infrastructure, qui s'élèvera sur <strong>51 000 m²</strong>, comportera deux niveaux 
                        de sous-sol, un rez-de-chaussée et un étage, avec <strong>20 escalators</strong> et 
                        <strong>9 ascenseurs</strong> pour faciliter la circulation des visiteurs.
                    </p>
                    <a href="<?= SITE_URL ?>/le-projet.php" class="btn btn-outline" style="margin-top: 1.5rem;">
                        En savoir plus →
                    </a>
                </div>
                <div class="project-visual" data-aos="fade-left">
                    <div class="swiper project-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="<?= asset('img/project/esplanade-fontaines.jpg') ?>" alt="Esplanade du Conakry Mall" loading="lazy"></div>
                            <div class="swiper-slide"><img src="<?= asset('img/project/facade-boutiques.jpg') ?>" alt="Façade boutiques" loading="lazy"></div>
                            <div class="swiper-slide"><img src="<?= asset('img/project/vue-arriere-drapeaux.jpg') ?>" alt="Vue arrière" loading="lazy"></div>
                            <div class="swiper-slide"><img src="<?= asset('img/project/esplanade-cinema.jpg') ?>" alt="Esplanade cinéma" loading="lazy"></div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= GALERIE IMAGES ======= -->
    <section class="section section-dark" id="galerie-preview">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">En Images</span>
                <h2 class="section-title">Découvrez le Grand Mall</h2>
            </div>
            <div class="gallery-preview">
                <div class="gallery-preview-item gallery-large" data-aos="fade-up">
                    <img src="<?= asset('img/project/vue-satellite.jpg') ?>" alt="Vue aérienne Conakry Mall" loading="lazy">
                    <div class="gallery-caption">Vue aérienne complète</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="100">
                    <img src="<?= asset('img/project/entree-principale.jpg') ?>" alt="Entrée principale" loading="lazy">
                    <div class="gallery-caption">Entrée principale</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="200">
                    <img src="<?= asset('img/project/esplanade-cinema.jpg') ?>" alt="Esplanade Cinéma" loading="lazy">
                    <div class="gallery-caption">Esplanade & Cinéma</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="300">
                    <img src="<?= asset('img/project/facade-boutiques.jpg') ?>" alt="Galerie marchande" loading="lazy">
                    <div class="gallery-caption">Galerie marchande</div>
                </div>
            </div>
            <div style="text-align:center;margin-top:2.5rem" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-gold">📸 Voir toute la galerie</a>
            </div>
        </div>
    </section>

    <!-- ======= ACTUALITÉS ======= -->
    <?php if (!empty($latestNews)): ?>
    <section class="section" id="actualites">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Actualités</span>
                <h2 class="section-title">Dernières nouvelles</h2>
            </div>
            <div class="news-grid">
                <?php foreach ($latestNews as $i => $article): ?>
                <div class="news-card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <div class="news-img">
                        <?php if ($article['image']): ?>
                            <img src="<?= upload($article['image']) ?>" alt="<?= e($article['title']) ?>" loading="lazy">
                        <?php else: ?>📰<?php endif; ?>
                    </div>
                    <div class="news-body">
                        <div class="news-date"><?= dateFormatFr($article['created_at']) ?></div>
                        <h3><a href="<?= SITE_URL ?>/actualites.php?slug=<?= e($article['slug']) ?>"><?= e($article['title']) ?></a></h3>
                        <p class="news-excerpt"><?= excerpt($article['excerpt'] ?: $article['content'], 120) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 2.5rem;" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/actualites.php" class="btn btn-outline">Toutes les actualités →</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ======= CTA avec image ======= -->
    <section class="cta-section cta-image" id="contact-cta">
        <div class="cta-bg" style="background-image: url('<?= asset('img/project/vue-aerienne.jpg') ?>')"></div>
        <div class="cta-overlay"></div>
        <div class="container" data-aos="fade-up" style="position:relative;z-index:2;">
            <span class="section-label">Contact</span>
            <h2>Intéressé par le Grand Mall ?</h2>
            <p>Investisseurs, enseignes, partenaires — rejoignez le plus grand projet commercial de Guinée.</p>
            <div class="hero-buttons" style="justify-content: center;">
                <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-lg magnetic-btn">✉️ Nous contacter</a>
                <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-outline btn-lg magnetic-btn">📸 Voir la galerie</a>
            </div>
        </div>
    </section>

    <!-- Custom cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="custom-cursor-follower" id="cursor-follower"></div>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
