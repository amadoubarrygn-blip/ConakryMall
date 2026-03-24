<?php
/**
 * Grand Mall de Conakry — Admin Sidebar (shared)
 */
$currentAdminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">🏬</div>
        <div>
            <h2>Grand Mall</h2>
            <span class="sidebar-badge">Admin</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= SITE_URL ?>/admin/" class="nav-item <?= $currentAdminPage === 'index' ? 'active' : '' ?>"><span class="nav-icon">📊</span> Dashboard</a>
        <a href="<?= SITE_URL ?>/admin/articles.php" class="nav-item <?= $currentAdminPage === 'articles' ? 'active' : '' ?>"><span class="nav-icon">📝</span> Articles</a>
        <a href="<?= SITE_URL ?>/admin/boutiques.php" class="nav-item <?= $currentAdminPage === 'boutiques' ? 'active' : '' ?>"><span class="nav-icon">🛍️</span> Boutiques</a>
        <a href="<?= SITE_URL ?>/admin/sliders.php" class="nav-item <?= $currentAdminPage === 'sliders' ? 'active' : '' ?>"><span class="nav-icon">🖼️</span> Sliders</a>
        <a href="<?= SITE_URL ?>/admin/galerie.php" class="nav-item <?= $currentAdminPage === 'galerie' ? 'active' : '' ?>"><span class="nav-icon">📸</span> Galerie</a>
        <a href="<?= SITE_URL ?>/admin/services.php" class="nav-item <?= $currentAdminPage === 'services' ? 'active' : '' ?>"><span class="nav-icon">⚙️</span> Services</a>
        <a href="<?= SITE_URL ?>/admin/pages.php" class="nav-item <?= $currentAdminPage === 'pages' ? 'active' : '' ?>"><span class="nav-icon">📄</span> Pages</a>
        <a href="<?= SITE_URL ?>/admin/parametres.php" class="nav-item <?= $currentAdminPage === 'parametres' ? 'active' : '' ?>"><span class="nav-icon">🔧</span> Paramètres</a>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= SITE_URL ?>/" class="nav-item" target="_blank"><span class="nav-icon">🌐</span> Voir le site</a>
        <a href="<?= SITE_URL ?>/admin/logout.php" class="nav-item logout"><span class="nav-icon">🚪</span> Déconnexion</a>
    </div>
</aside>
