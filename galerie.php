<?php
/**
 * Grand Mall de Conakry — Galerie
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$filter = input('cat', '');
$where = $filter ? "category = ?" : "1";
$params = $filter ? [$filter] : [];
$medias = Database::fetchAll("SELECT * FROM medias WHERE $where ORDER BY created_at DESC", $params);
$categories = Database::fetchAll("SELECT DISTINCT category FROM medias ORDER BY category");

$pageTitle = 'Galerie';
$pageDescription = 'Découvrez le Grand Mall de Conakry en images : rendus 3D, photos du chantier et événements.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <span class="section-label" data-aos="fade-up">Photos & Vidéos</span>
            <h1 data-aos="fade-up" data-aos-delay="100"><span class="gold">Galerie</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Le Grand Mall en images</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if (!empty($categories)): ?>
            <div class="filter-bar" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/galerie.php" class="filter-tag <?= !$filter ? 'active' : '' ?>">Tous</a>
                <?php foreach ($categories as $c): ?>
                    <a href="?cat=<?= e($c['category']) ?>" class="filter-tag <?= $filter === $c['category'] ? 'active' : '' ?>"><?= ucfirst(e($c['category'])) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($medias)): ?>
                <div class="empty-state-public" data-aos="fade-up">
                    <div class="empty-icon">📸</div>
                    <h3>Galerie en préparation</h3>
                    <p>Les photos et vidéos seront bientôt disponibles.</p>
                </div>
            <?php else: ?>
            <div class="gallery-grid" id="gallery">
                <?php foreach ($medias as $i => $m): ?>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="<?= min($i * 50, 200) ?>">
                    <img src="<?= upload($m['filename']) ?>" alt="<?= e($m['alt_text']) ?>" loading="lazy" onclick="openLightbox(this.src, '<?= e(addslashes($m['alt_text'])) ?>')">
                    <?php if ($m['alt_text']): ?><div class="gallery-caption"><?= e($m['alt_text']) ?></div><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">✕</button>
        <img id="lightbox-img" src="" alt="">
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>

<?php
$extraScripts = '<script>
function openLightbox(src, alt) {
    document.getElementById("lightbox-img").src = src;
    document.getElementById("lightbox-caption").textContent = alt;
    document.getElementById("lightbox").classList.add("active");
    document.body.style.overflow = "hidden";
}
function closeLightbox() {
    document.getElementById("lightbox").classList.remove("active");
    document.body.style.overflow = "";
}
document.addEventListener("keydown", e => { if (e.key === "Escape") closeLightbox(); });
</script>';
require_once INCLUDES_PATH . 'footer.php';
?>
