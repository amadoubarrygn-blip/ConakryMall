<?php
/**
 * Grand Mall de Conakry — Espaces & Services
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$services = Database::fetchAll("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");

$pageTitle = 'Espaces & Services';
$pageDescription = 'Découvrez les espaces du Grand Mall : hypermarché, cinéma, aquarium, bien-être, jeux et plus encore.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <span class="section-label" data-aos="fade-up">Nos Espaces</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Espaces &<br><span class="gold">Services</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Tout ce dont vous avez besoin, sous un même toit</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php foreach ($services as $i => $s): ?>
            <div class="service-detail <?= $i % 2 ? 'reverse' : '' ?>" id="<?= e($s['slug']) ?>" data-aos="fade-up">
                <div class="service-detail-content">
                    <div class="service-detail-icon"><?= e($s['icon']) ?></div>
                    <h2><?= e($s['name']) ?></h2>
                    <p><?= e($s['description'] ?: $s['short_description']) ?></p>
                    <?php if (!empty($s['image'])): ?>
                        <a href="<?= SITE_URL ?>/galerie.php" class="btn btn-outline" style="margin-top:1rem;">📸 Voir les photos</a>
                    <?php endif; ?>
                </div>
                <div class="service-detail-visual">
                    <?php if (!empty($s['image'])): ?>
                        <img src="<?= upload($s['image']) ?>" alt="<?= e($s['name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="service-placeholder"><?= e($s['icon']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($i < count($services) - 1): ?><hr class="service-divider"><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="cta-section">
        <div class="container" data-aos="fade-up">
            <h2>Un espace pour chaque envie</h2>
            <p>Shopping, détente, loisirs — le Grand Mall redéfinit l'expérience commerciale en Guinée.</p>
            <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-lg">✉️ Nous contacter</a>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
