<?php
/**
 * Grand Mall de Conakry — Actualités
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$slug = input('slug');

// Article unique
if ($slug) {
    $article = Database::fetch("SELECT * FROM articles WHERE slug = ? AND status = 'published'", [$slug]);
    if (!$article) { header('HTTP/1.0 404 Not Found'); $article = null; }

    $pageTitle = $article ? $article['title'] : 'Article introuvable';
    $pageDescription = $article ? excerpt($article['excerpt'] ?: $article['content'], 160) : '';
    require_once INCLUDES_PATH . 'header.php';

    if ($article): ?>
    <section class="page-hero page-hero-sm">
        <div class="container">
            <span class="section-label"><?= e($article['category']) ?></span>
            <h1><?= e($article['title']) ?></h1>
            <p><?= dateFormatFr($article['created_at']) ?></p>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <article class="article-content" data-aos="fade-up">
                <?php if ($article['image']): ?>
                    <img src="<?= upload($article['image']) ?>" alt="<?= e($article['title']) ?>" class="article-hero-img">
                <?php endif; ?>
                <div class="article-body"><?= nl2br(e($article['content'])) ?></div>
                <a href="<?= SITE_URL ?>/actualites.php" class="btn btn-outline" style="margin-top:2rem;">← Retour aux actualités</a>
            </article>
        </div>
    </section>
    <?php else: ?>
    <section class="section"><div class="container"><div class="empty-state-public"><div class="empty-icon">📰</div><h3>Article introuvable</h3><p><a href="<?= SITE_URL ?>/actualites.php">Voir toutes les actualités</a></p></div></div></section>
    <?php endif;

    require_once INCLUDES_PATH . 'footer.php';
    exit;
}

// Liste des articles
$page = max(1, (int) input('page', 1));
$perPage = 9;
$total = Database::count('articles', "status = 'published'");
$pag = paginate($total, $perPage, $page);
$articles = Database::fetchAll("SELECT * FROM articles WHERE status = 'published' ORDER BY created_at DESC LIMIT ? OFFSET ?", [$pag['per_page'], $pag['offset']]);

$pageTitle = 'Actualités';
$pageDescription = 'Suivez les dernières actualités du Grand Mall de Conakry.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <span class="section-label" data-aos="fade-up">Blog</span>
            <h1 data-aos="fade-up" data-aos-delay="100"><span class="gold">Actualités</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Suivez l'avancement du projet et nos dernières nouvelles</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php if (empty($articles)): ?>
                <div class="empty-state-public" data-aos="fade-up">
                    <div class="empty-icon">📰</div>
                    <h3>Pas d'actualités pour le moment</h3>
                    <p>Revenez bientôt pour découvrir les dernières nouvelles du Grand Mall.</p>
                </div>
            <?php else: ?>
            <div class="news-grid">
                <?php foreach ($articles as $i => $a): ?>
                <div class="news-card" data-aos="fade-up" data-aos-delay="<?= min($i * 80, 240) ?>">
                    <div class="news-img">
                        <?php if ($a['image']): ?>
                            <img src="<?= upload($a['image']) ?>" alt="<?= e($a['title']) ?>" loading="lazy">
                        <?php else: ?>📰<?php endif; ?>
                    </div>
                    <div class="news-body">
                        <div class="news-date"><?= dateFormatFr($a['created_at']) ?></div>
                        <h3><a href="<?= SITE_URL ?>/actualites.php?slug=<?= e($a['slug']) ?>"><?= e($a['title']) ?></a></h3>
                        <p class="news-excerpt"><?= excerpt($a['excerpt'] ?: $a['content'], 120) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($pag['pages'] > 1): ?>
            <div class="pagination" data-aos="fade-up">
                <?php if ($pag['has_prev']): ?><a href="?page=<?= $pag['current'] - 1 ?>" class="pagination-link">← Précédent</a><?php endif; ?>
                <?php for ($i = 1; $i <= $pag['pages']; $i++): ?>
                    <a href="?page=<?= $i ?>" class="pagination-link <?= $i === $pag['current'] ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($pag['has_next']): ?><a href="?page=<?= $pag['current'] + 1 ?>" class="pagination-link">Suivant →</a><?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
