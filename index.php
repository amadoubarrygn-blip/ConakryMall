<?php
/**
 * Grand Mall de Conakry — Page d'accueil
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

// Données dynamiques
$services = Database::fetchAll("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");
$latestNews = Database::fetchAll("SELECT * FROM articles WHERE status = 'published' ORDER BY created_at DESC LIMIT 3");
$sliders = Database::fetchAll("SELECT * FROM sliders WHERE status = 'active' ORDER BY sort_order ASC");

$pageTitle = null; // Utilise SITE_NAME par défaut
$pageDescription = SITE_DESCRIPTION;

require_once INCLUDES_PATH . 'header.php';
?>

    <!-- ======= HERO ======= -->
    <section class="hero" id="accueil">
        <div class="container">
            <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Un projet Kakandé Immo — Groupe Guicopres
                </div>

                <h1>
                    <span class="thin">Le plus grand</span><br>
                    <span class="gold">Centre Commercial</span><br>
                    de Guinée
                </h1>

                <p class="hero-desc">
                    83 000 m² d'expérience shopping, divertissement et bien-être 
                    sur le plateau de Koloma, au cœur de Conakry. Un projet d'envergure 
                    internationale pour la Guinée.
                </p>

                <div class="hero-buttons">
                    <a href="<?= SITE_URL ?>/le-projet.php" class="btn btn-gold btn-lg">
                        Découvrir le projet →
                    </a>
                    <a href="<?= SITE_URL ?>/contact.php" class="btn btn-outline btn-lg">
                        📍 Nous contacter
                    </a>
                </div>
            </div>

            <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="hero-card">
                    <span class="hero-card-badge">En construction</span>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="hero-stat-num" data-count="83000" data-suffix=" m²">0</div>
                            <div class="hero-stat-label">Superficie totale</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-num" data-count="51000" data-suffix=" m²">0</div>
                            <div class="hero-stat-label">Infrastructure</div>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-num" data-count="20">0</div>
                            <div class="hero-stat-label">Escalators</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-num" data-count="9">0</div>
                            <div class="hero-stat-label">Ascenseurs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= SERVICES ======= -->
    <section class="section section-dark" id="services">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Nos Espaces</span>
                <h2 class="section-title">Tout sous un même toit</h2>
                <p class="section-desc">Un centre commercial pensé pour offrir une expérience complète : shopping, loisirs, gastronomie et bien-être.</p>
            </div>

            <div class="services-grid">
                <?php foreach ($services as $i => $service): ?>
                <div class="service-card" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
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
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Chiffres Clés</span>
                <h2 class="section-title">Le Grand Mall en chiffres</h2>
            </div>

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

    <!-- ======= PROJET ======= -->
    <section class="section" id="projet">
        <div class="container">
            <div class="project-content">
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
                    <p>
                        Ce projet marque un tournant pour l'urbanisation de Conakry et témoigne de 
                        l'engagement à favoriser des investissements d'envergure pour le développement 
                        économique et touristique de la Guinée.
                    </p>
                    <a href="<?= SITE_URL ?>/le-projet.php" class="btn btn-outline" style="margin-top: 1.5rem;">
                        En savoir plus →
                    </a>
                </div>
                <div class="project-visual" data-aos="fade-left">
                    🏗️
                </div>
            </div>
        </div>
    </section>

    <!-- ======= ACTUALITÉS ======= -->
    <?php if (!empty($latestNews)): ?>
    <section class="section section-dark" id="actualites">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Actualités</span>
                <h2 class="section-title">Dernières nouvelles</h2>
                <p class="section-desc">Suivez l'avancement du projet et les dernières actualités du Grand Mall.</p>
            </div>

            <div class="news-grid">
                <?php foreach ($latestNews as $i => $article): ?>
                <div class="news-card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <div class="news-img">
                        <?php if ($article['image']): ?>
                            <img src="<?= upload($article['image']) ?>" alt="<?= e($article['title']) ?>" loading="lazy">
                        <?php else: ?>
                            📰
                        <?php endif; ?>
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
                <a href="<?= SITE_URL ?>/actualites.php" class="btn btn-outline">
                    Toutes les actualités →
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ======= CTA ======= -->
    <section class="cta-section" id="contact-cta">
        <div class="container" data-aos="fade-up">
            <span class="section-label">Contact</span>
            <h2>Intéressé par le Grand Mall ?</h2>
            <p>Investisseurs, enseignes, partenaires — rejoignez le plus grand projet commercial de Guinée.</p>
            <div class="hero-buttons" style="justify-content: center;">
                <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-lg">
                    ✉️ Nous contacter
                </a>
                <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-outline btn-lg">
                    📸 Voir la galerie
                </a>
            </div>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
