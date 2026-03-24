<?php
/**
 * Grand Mall de Conakry — Admin Dashboard
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$user = Auth::currentUser();

// Statistiques
$stats = [
    'articles' => Database::count('articles'),
    'articles_published' => Database::count('articles', "status = 'published'"),
    'boutiques' => Database::count('boutiques'),
    'medias' => Database::count('medias'),
    'services' => Database::count('services'),
    'sliders' => Database::count('sliders'),
];

// Derniers articles
$latestArticles = Database::fetchAll("SELECT * FROM articles ORDER BY created_at DESC LIMIT 5");

// Flashes
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard — <?= e(SITE_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="main-content">
            <header class="topbar">
                <button class="menu-btn" id="menu-btn">☰</button>
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>👤 <?= e($user['username']) ?></span>
                </div>
            </header>

            <div class="content">
                <?php foreach ($flashes as $f): ?>
                    <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
                <?php endforeach; ?>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📝</div>
                        <div class="stat-info">
                            <span class="stat-number"><?= $stats['articles'] ?></span>
                            <span class="stat-label">Articles</span>
                        </div>
                        <span class="stat-detail"><?= $stats['articles_published'] ?> publiés</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🛍️</div>
                        <div class="stat-info">
                            <span class="stat-number"><?= $stats['boutiques'] ?></span>
                            <span class="stat-label">Boutiques</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📸</div>
                        <div class="stat-info">
                            <span class="stat-number"><?= $stats['medias'] ?></span>
                            <span class="stat-label">Médias</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🖼️</div>
                        <div class="stat-info">
                            <span class="stat-number"><?= $stats['sliders'] ?></span>
                            <span class="stat-label">Sliders</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="section-card">
                    <h2>Actions rapides</h2>
                    <div class="quick-actions">
                        <a href="<?= SITE_URL ?>/admin/articles.php?action=new" class="quick-btn">
                            ➕ Nouvel article
                        </a>
                        <a href="<?= SITE_URL ?>/admin/boutiques.php?action=new" class="quick-btn">
                            🏪 Nouvelle boutique
                        </a>
                        <a href="<?= SITE_URL ?>/admin/galerie.php?action=upload" class="quick-btn">
                            📤 Uploader média
                        </a>
                        <a href="<?= SITE_URL ?>/admin/sliders.php?action=new" class="quick-btn">
                            🖼️ Nouveau slide
                        </a>
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="section-card">
                    <h2>Derniers articles</h2>
                    <?php if (empty($latestArticles)): ?>
                        <p class="empty-state">Aucun article pour l'instant. <a href="<?= SITE_URL ?>/admin/articles.php?action=new">Créer le premier</a></p>
                    <?php else: ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestArticles as $a): ?>
                                <tr>
                                    <td><a href="<?= SITE_URL ?>/admin/articles.php?action=edit&id=<?= $a['id'] ?>"><?= e($a['title']) ?></a></td>
                                    <td><span class="badge badge-<?= $a['status'] ?>"><?= $a['status'] === 'published' ? 'Publié' : 'Brouillon' ?></span></td>
                                    <td><?= dateFormatFr($a['created_at']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>
