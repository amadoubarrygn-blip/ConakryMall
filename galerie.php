<?php
/**
 * Grand Mall de Conakry — Galerie Immersive
 * Version 2.0 — Masonry, Lightbox avec navigation, filtrage
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$filter = input('cat', '');

// Images statiques du projet (toujours disponibles)
$projectImages = [
    ['src' => 'project/entree-principale.jpg', 'alt' => 'Entrée principale du Grand Mall', 'cat' => 'rendus'],
    ['src' => 'project/vue-aerienne.jpg', 'alt' => 'Vue aérienne complète', 'cat' => 'rendus'],
    ['src' => 'project/facade-boutiques.jpg', 'alt' => 'Façade des boutiques', 'cat' => 'rendus'],
    ['src' => 'project/galerie-marchande.jpg', 'alt' => 'Galerie marchande intérieure', 'cat' => 'rendus'],
    ['src' => 'project/esplanade-fontaines.jpg', 'alt' => 'Esplanade & fontaines', 'cat' => 'rendus'],
    ['src' => 'project/esplanade-cinema.jpg', 'alt' => 'Esplanade côté cinéma', 'cat' => 'rendus'],
    ['src' => 'project/cinema-route.jpg', 'alt' => 'Vue du cinéma depuis la route', 'cat' => 'rendus'],
    ['src' => 'project/vue-arriere-drapeaux.jpg', 'alt' => 'Vue arrière avec drapeaux', 'cat' => 'rendus'],
    ['src' => 'project/vue-satellite.jpg', 'alt' => 'Vue satellite du projet', 'cat' => 'rendus'],
    ['src' => 'services/service_hypermarche_v2.png', 'alt' => 'Hypermarché de luxe', 'cat' => 'espaces'],
    ['src' => 'services/service_bien_etre_v2.png', 'alt' => 'Espace Bien-être & Spa', 'cat' => 'espaces'],
    ['src' => 'services/service_cinema_v2.png', 'alt' => 'Cinéma VIP', 'cat' => 'espaces'],
    ['src' => 'services/service_aquarium_v2.png', 'alt' => 'Aquarium géant', 'cat' => 'espaces'],
    ['src' => 'services/service_jeux_v2.png', 'alt' => 'Espace de jeux', 'cat' => 'espaces'],
    ['src' => 'services/service_magasins_v2.png', 'alt' => 'Galerie marchande', 'cat' => 'espaces'],
    ['src' => 'services/service_salles_expo_v2.png', 'alt' => 'Salle d\'exposition', 'cat' => 'espaces'],
    ['src' => 'services/service_pole_services_v2.png', 'alt' => 'Pôle de services VIP', 'cat' => 'espaces'],
    ['src' => 'lifestyle/shopping-girl-bag.png', 'alt' => 'Shopping lifestyle', 'cat' => 'lifestyle'],
    ['src' => 'lifestyle/fashion-man.png', 'alt' => 'Mode masculine', 'cat' => 'lifestyle'],
    ['src' => 'lifestyle/shopping-girl-afro.png', 'alt' => 'Shopping lifestyle', 'cat' => 'lifestyle'],
];

// Filtrer si un filtre est actif
if ($filter) {
    $projectImages = array_filter($projectImages, fn($img) => $img['cat'] === $filter);
}

// Ajouter les medias depuis la DB
$dbMedias = Database::fetchAll("SELECT * FROM medias ORDER BY created_at DESC");

$pageTitle = 'Galerie';
$pageDescription = 'Découvrez le Grand Mall de Conakry en images : rendus 3D, espaces intérieurs et lifestyle.';
require_once INCLUDES_PATH . 'header.php';
?>

    <!-- ======= HERO ======= -->
    <section class="page-hero page-hero-image">
        <div class="page-hero-bg" style="background-image: url('<?= asset('img/project/vue-aerienne.jpg') ?>')"></div>
        <div class="page-hero-overlay"></div>
        <div class="container" style="position:relative;z-index:2;">
            <span class="section-label" data-aos="fade-up">Photos & Vidéos</span>
            <h1 data-aos="fade-up" data-aos-delay="100"><span class="gold">Galerie</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Le Grand Mall en images — <?= count($projectImages) + count($dbMedias) ?> visuels</p>
        </div>
    </section>

    <!-- ======= GALERIE ======= -->
    <section class="section">
        <div class="container">
            <!-- Filtres -->
            <div class="filter-bar" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/galerie.php" class="filter-tag <?= !$filter ? 'active' : '' ?>">Tous</a>
                <a href="?cat=rendus" class="filter-tag <?= $filter === 'rendus' ? 'active' : '' ?>">🏗️ Rendus 3D</a>
                <a href="?cat=espaces" class="filter-tag <?= $filter === 'espaces' ? 'active' : '' ?>">🏢 Espaces</a>
                <a href="?cat=lifestyle" class="filter-tag <?= $filter === 'lifestyle' ? 'active' : '' ?>">👗 Lifestyle</a>
            </div>

            <!-- Grille Masonry -->
            <div class="gallery-masonry" id="gallery">
                <?php foreach ($projectImages as $i => $img): ?>
                <div class="gallery-masonry-item <?= $i % 5 === 0 ? 'tall' : ($i % 7 === 0 ? 'wide' : '') ?>" data-aos="fade-up" data-aos-delay="<?= min($i * 40, 200) ?>">
                    <img src="<?= asset('img/' . $img['src']) ?>" alt="<?= e($img['alt']) ?>" loading="lazy" data-index="<?= $i ?>">
                    <div class="gallery-masonry-overlay">
                        <span class="gallery-masonry-caption"><?= e($img['alt']) ?></span>
                        <span class="gallery-masonry-zoom">🔍</span>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php foreach ($dbMedias as $j => $m): ?>
                <div class="gallery-masonry-item" data-aos="fade-up">
                    <img src="<?= upload($m['filename']) ?>" alt="<?= e($m['alt_text']) ?>" loading="lazy" data-index="<?= count($projectImages) + $j ?>">
                    <div class="gallery-masonry-overlay">
                        <span class="gallery-masonry-caption"><?= e($m['alt_text']) ?></span>
                        <span class="gallery-masonry-zoom">🔍</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ======= LIGHTBOX AVEC NAVIGATION ======= -->
    <div class="lightbox-v2" id="lightbox">
        <div class="lightbox-v2-backdrop" onclick="closeLB()"></div>
        <button class="lightbox-v2-close" onclick="closeLB()">✕</button>
        <button class="lightbox-v2-prev" onclick="navLB(-1)">‹</button>
        <button class="lightbox-v2-next" onclick="navLB(1)">›</button>
        <div class="lightbox-v2-content">
            <img id="lb-img" src="" alt="">
            <div class="lightbox-v2-caption" id="lb-caption"></div>
            <div class="lightbox-v2-counter" id="lb-counter"></div>
        </div>
    </div>

<?php
$extraScripts = '<script>
const lbImages = [];
document.querySelectorAll("#gallery img").forEach(img => {
    lbImages.push({ src: img.src, alt: img.alt });
    img.addEventListener("click", function() { openLB(parseInt(this.dataset.index)); });
});

let currentIdx = 0;
function openLB(idx) {
    currentIdx = idx;
    updateLB();
    document.getElementById("lightbox").classList.add("active");
    document.body.style.overflow = "hidden";
}
function closeLB() {
    document.getElementById("lightbox").classList.remove("active");
    document.body.style.overflow = "";
}
function navLB(dir) {
    currentIdx = (currentIdx + dir + lbImages.length) % lbImages.length;
    updateLB();
}
function updateLB() {
    if (!lbImages[currentIdx]) return;
    document.getElementById("lb-img").src = lbImages[currentIdx].src;
    document.getElementById("lb-caption").textContent = lbImages[currentIdx].alt;
    document.getElementById("lb-counter").textContent = (currentIdx + 1) + " / " + lbImages.length;
}
document.addEventListener("keydown", e => {
    if (e.key === "Escape") closeLB();
    if (e.key === "ArrowLeft") navLB(-1);
    if (e.key === "ArrowRight") navLB(1);
});
</script>';
require_once INCLUDES_PATH . 'footer.php';
?>
