<?php
/**
 * Grand Mall de Conakry — Le Projet
 * Version 2.0 — Enhanced with hero image, timeline, gallery
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$pageTitle = 'Le Projet';
$pageDescription = 'Découvrez le Grand Mall de Conakry — un projet de 83 000 m² porté par Kakandé Immo, filiale du Groupe Guicopres.';

require_once INCLUDES_PATH . 'header.php';
?>

    <!-- ======= HERO avec image de fond ======= -->
    <section class="page-hero page-hero-image">
        <div class="page-hero-bg" style="background-image: url('<?= asset('img/project/entree-principale.jpg') ?>')"></div>
        <div class="page-hero-overlay"></div>
        <div class="container" style="position:relative;z-index:2;">
            <span class="section-label" data-aos="fade-up">Notre Vision</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Le Grand Mall<br><span class="gold">de Conakry</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Un projet d'envergure internationale pour la Guinée</p>
        </div>
    </section>

    <!-- ======= PRÉSENTATION ======= -->
    <section class="section">
        <div class="container">
            <div class="project-content">
                <div class="project-text" data-aos="fade-right">
                    <span class="section-label">Le Projet</span>
                    <h2>Un tournant pour l'urbanisation de Conakry</h2>
                    <p>
                        Porté par <strong>Kakandé Immo</strong>, filiale du <strong>Groupe Guicopres</strong>,
                        ce projet ambitieux s'étend sur une superficie impressionnante de <strong>83 000 m²</strong>,
                        soit plus de huit hectares. Il vise à enrichir l'offre touristique et commerciale du pays
                        en proposant un espace moderne et attractif.
                    </p>
                    <p>
                        L'infrastructure, qui s'élèvera sur <strong>51 000 m²</strong>, comportera deux niveaux
                        de sous-sol, un rez-de-chaussée et un étage, avec <strong>20 escalators</strong> et
                        <strong>9 ascenseurs</strong> pour faciliter la circulation des visiteurs.
                    </p>
                    <p>
                        Avec cette réalisation, la Guinée veut se doter d'un centre commercial moderne,
                        comparable aux grandes infrastructures commerciales internationales. Ce projet marque
                        un tournant pour l'urbanisation de Conakry et témoigne de l'engagement du gouvernement
                        à favoriser des investissements d'envergure pour le développement économique et
                        touristique du pays.
                    </p>
                </div>
                <div class="project-visual" data-aos="fade-left">
                    <img src="<?= asset('img/project/entree-principale.jpg') ?>" alt="Grand Mall de Conakry — Entrée principale" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ======= TIMELINE INTERACTIVE ======= -->
    <section class="section section-dark">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Chronologie</span>
                <h2 class="section-title">Les étapes du projet</h2>
            </div>
            <div class="timeline">
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Phase 1</span>
                        <h3>Conception & Design</h3>
                        <p>Études architecturales, design du centre commercial par des experts internationaux. Validation des plans et obtention des permis.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="timeline-dot active"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Phase 2 — En cours</span>
                        <h3>Construction</h3>
                        <p>Travaux de construction sur le plateau de Koloma. Infrastructure de 51 000 m² avec 2 sous-sols, RDC et étage.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Phase 3</span>
                        <h3>Aménagement intérieur</h3>
                        <p>Installation des 20 escalators, 9 ascenseurs, finitions des espaces commerciaux et des zones de divertissement.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Phase 4</span>
                        <h3>Inauguration</h3>
                        <p>Ouverture officielle du plus grand centre commercial de Guinée et de l'Afrique de l'Ouest.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= CHIFFRES CLÉS ======= -->
    <section class="section stats-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up" style="margin-bottom:2rem;">
                <span class="section-label">En chiffres</span>
                <h2 class="section-title">L'ampleur du projet</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-item" data-aos="fade-up">
                    <div class="stat-number" data-count="83000" data-suffix=" m²">0</div>
                    <div class="stat-label">Superficie totale</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number" data-count="51000" data-suffix=" m²">0</div>
                    <div class="stat-label">Infrastructure</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number" data-count="20" data-suffix=" escalators">0</div>
                    <div class="stat-label">Circulation verticale</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number" data-count="9" data-suffix=" ascenseurs">0</div>
                    <div class="stat-label">Accessibilité</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= GALERIE D'IMAGES ======= -->
    <section class="section section-dark">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">En Images</span>
                <h2 class="section-title">Vues du projet</h2>
            </div>
            <div class="gallery-preview">
                <div class="gallery-preview-item gallery-large" data-aos="fade-up">
                    <img src="<?= asset('img/project/vue-aerienne.jpg') ?>" alt="Vue aérienne" loading="lazy">
                    <div class="gallery-caption">Vue aérienne complète</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="100">
                    <img src="<?= asset('img/project/facade-boutiques.jpg') ?>" alt="Façade boutiques" loading="lazy">
                    <div class="gallery-caption">Façade des boutiques</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="200">
                    <img src="<?= asset('img/project/esplanade-fontaines.jpg') ?>" alt="Esplanade" loading="lazy">
                    <div class="gallery-caption">Esplanade & fontaines</div>
                </div>
                <div class="gallery-preview-item" data-aos="fade-up" data-aos-delay="300">
                    <img src="<?= asset('img/project/cinema-route.jpg') ?>" alt="Cinéma" loading="lazy">
                    <div class="gallery-caption">Espace Cinéma</div>
                </div>
            </div>
            <div style="text-align:center;margin-top:2.5rem" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-gold magnetic-btn">📸 Voir toute la galerie</a>
            </div>
        </div>
    </section>

    <!-- ======= PROMOTEURS ======= -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label">Les Promoteurs</span>
                <h2 class="section-title">Porteurs du projet</h2>
            </div>
            <div class="promoters-grid">
                <div class="promoter-card" data-aos="fade-up">
                    <div class="promoter-icon">🏢</div>
                    <h3>Groupe Guicopres</h3>
                    <p>Fondé en 1998 par Kerfalla Person Camara, le Groupe Guicopres est un groupe industriel guinéen diversifié présent dans la construction, l'immobilier, la distribution et l'import-export.</p>
                </div>
                <div class="promoter-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="promoter-icon">🏠</div>
                    <h3>Kakandé Immo</h3>
                    <p>Filiale du Groupe Guicopres créée en 2010, Kakandé Immo est spécialisée dans la construction de logements et d'infrastructures, contribuant à l'amélioration du cadre de vie en Guinée.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= CTA ======= -->
    <section class="cta-section cta-image">
        <div class="cta-bg" style="background-image: url('<?= asset('img/project/vue-arriere-drapeaux.jpg') ?>')"></div>
        <div class="cta-overlay"></div>
        <div class="container" data-aos="fade-up" style="position:relative;z-index:2;">
            <span class="section-label">Rejoignez-nous</span>
            <h2>Rejoignez le Grand Mall</h2>
            <p>Investisseurs et enseignes, participez au plus grand projet commercial de Guinée.</p>
            <div class="hero-buttons" style="justify-content: center;">
                <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-lg magnetic-btn">✉️ Nous contacter</a>
                <a href="<?= SITE_URL ?>/espaces-services.php" class="btn btn-outline btn-lg magnetic-btn">🏢 Les espaces</a>
            </div>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
