<?php
/**
 * Grand Mall de Conakry — Espaces & Services
 * Version 2.0 — Premium Design avec images générées
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$services = Database::fetchAll("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");

// Mapping des images générées par service
$serviceImages = [
    'Hypermarché' => 'service_hypermarche_v2.png',
    'Espace Bien-être' => 'service_bien_etre_v2.png',
    'Cinéma' => 'service_cinema_v2.png',
    'Aquarium' => 'service_aquarium_v2.png',
    'Espaces de Jeux' => 'service_jeux_v2.png',
    'Magasins' => 'service_magasins_v2.png',
    'Salles d\'Exposition' => 'service_salles_expo_v2.png',
    'Pôle de Services' => 'service_pole_services_v2.png'
];

$pageTitle = 'Espaces & Services';
$pageDescription = 'Découvrez les espaces du Grand Mall : hypermarché, cinéma, aquarium, bien-être, jeux et plus encore.';
require_once INCLUDES_PATH . 'header.php';
?>

    <!-- ======= HERO avec image de fond ======= -->
    <section class="page-hero page-hero-image">
        <div class="page-hero-bg" style="background-image: url('<?= asset('img/project/galerie-marchande.jpg') ?>')"></div>
        <div class="page-hero-overlay"></div>
        <div class="container" style="position:relative;z-index:2;">
            <span class="section-label" data-aos="fade-up">Nos Espaces</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Espaces &<br><span class="gold">Services</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Tout ce dont vous avez besoin, sous un même toit — shopping, détente, loisirs et culture.</p>
        </div>
    </section>

    <!-- ======= SERVICES DÉTAILLÉS ======= -->
    <section class="section">
        <div class="container">
            <?php foreach ($services as $i => $s): 
                $imgName = $serviceImages[$s['name']] ?? 'service_magasins_v2.png';
                $imgUrl = asset('img/services/' . $imgName);
            ?>
            <div class="service-detail <?= $i % 2 ? 'reverse' : '' ?>" id="<?= e($s['slug']) ?>" data-aos="fade-up">
                <div class="service-detail-content">
                    <span class="service-detail-number"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                    <div class="service-detail-icon"><?= e($s['icon']) ?></div>
                    <h2><?= e($s['name']) ?></h2>
                    <p><?= e($s['description'] ?: $s['short_description']) ?></p>
                    <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-outline magnetic-btn" style="margin-top:1.5rem;">📸 Voir les photos</a>
                </div>
                <div class="service-detail-visual">
                    <img src="<?= $imgUrl ?>" alt="<?= e($s['name']) ?> — Grand Mall de Conakry" loading="lazy">
                </div>
            </div>
            <?php if ($i < count($services) - 1): ?><hr class="service-divider"><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ======= CTA ======= -->
    <section class="cta-section cta-image">
        <div class="cta-bg" style="background-image: url('<?= asset('img/project/vue-aerienne.jpg') ?>')"></div>
        <div class="cta-overlay"></div>
        <div class="container" data-aos="fade-up" style="position:relative;z-index:2;">
            <span class="section-label">Contact</span>
            <h2>Un espace pour chaque envie</h2>
            <p>Shopping, détente, loisirs — le Grand Mall redéfinit l'expérience commerciale en Guinée.</p>
            <div class="hero-buttons" style="justify-content: center;">
                <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-lg magnetic-btn">✉️ Nous contacter</a>
                <a href="<?= SITE_URL ?>/boutiques.php" class="btn btn-outline btn-lg magnetic-btn">🛍️ Les boutiques</a>
            </div>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
