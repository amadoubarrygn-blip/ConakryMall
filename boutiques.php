<?php
/**
 * Grand Mall de Conakry — Boutiques
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$filter = input('cat', '');
$where = $filter ? "status != 'inactive' AND category = ?" : "status != 'inactive'";
$params = $filter ? [$filter] : [];
$boutiques = Database::fetchAll("SELECT * FROM boutiques WHERE $where ORDER BY sort_order ASC, name ASC", $params);
$categories = Database::fetchAll("SELECT DISTINCT category FROM boutiques WHERE status != 'inactive' ORDER BY category");

$pageTitle = 'Boutiques';
$pageDescription = 'Découvrez les boutiques et enseignes du Grand Mall de Conakry.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <span class="section-label" data-aos="fade-up">Nos Enseignes</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Les <span class="gold">Boutiques</span></h1>
            <p data-aos="fade-up" data-aos-delay="200"><?= count($boutiques) ?> enseigne<?= count($boutiques) > 1 ? 's' : '' ?> pour tous vos besoins</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <!-- Filtres -->
            <?php if (!empty($categories)): ?>
            <div class="filter-bar" data-aos="fade-up">
                <a href="<?= SITE_URL ?>/boutiques.php" class="filter-tag <?= !$filter ? 'active' : '' ?>">Tous</a>
                <?php foreach ($categories as $c): ?>
                    <a href="?cat=<?= e($c['category']) ?>" class="filter-tag <?= $filter === $c['category'] ? 'active' : '' ?>"><?= ucfirst(e($c['category'])) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($boutiques)): ?>
                <div class="empty-state-public" data-aos="fade-up">
                    <div class="empty-icon">🏪</div>
                    <h3>Bientôt disponible</h3>
                    <p>Les boutiques seront annoncées prochainement. Restez connectés !</p>
                </div>
            <?php else: ?>
            <div class="boutiques-grid">
                <?php foreach ($boutiques as $i => $b): ?>
                <div class="boutique-card" data-aos="fade-up" data-aos-delay="<?= min($i * 60, 300) ?>">
                    <div class="boutique-logo">
                        <?php if (!empty($b['logo'])): ?>
                            <img src="<?= upload($b['logo']) ?>" alt="<?= e($b['name']) ?>">
                        <?php else: ?>
                            <span>🏪</span>
                        <?php endif; ?>
                    </div>
                    <div class="boutique-info">
                        <h3><?= e($b['name']) ?></h3>
                        <?php if ($b['category']): ?><span class="boutique-cat"><?= ucfirst(e($b['category'])) ?></span><?php endif; ?>
                        <?php if ($b['floor']): ?><span class="boutique-floor">📍 <?= e($b['floor']) ?></span><?php endif; ?>
                        <?php if ($b['description']): ?><p><?= excerpt($b['description'], 100) ?></p><?php endif; ?>
                    </div>
                    <span class="badge badge-<?= $b['status'] ?>"><?= $b['status'] === 'active' ? 'Ouvert' : 'Bientôt' ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
