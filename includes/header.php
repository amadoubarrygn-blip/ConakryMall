<?php
/**
 * Grand Mall de Conakry — Header partagé
 */

// Récupérer les infos du site depuis la config ou la DB
$siteName = SITE_NAME;
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="<?= SITE_LANG ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($pageDescription ?? SITE_DESCRIPTION) ?>">
    <meta name="theme-color" content="#0A1628">
    <meta property="og:title" content="<?= e($pageTitle ?? $siteName) ?>">
    <meta property="og:description" content="<?= e($pageDescription ?? SITE_DESCRIPTION) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL ?>">

    <title><?= e(isset($pageTitle) ? "$pageTitle — $siteName" : $siteName) ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏬</text></svg>">

    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>

    <!-- ======= HEADER ======= -->
    <header class="header" id="header">
        <div class="container">
            <a href="<?= SITE_URL ?>/" class="logo">
                <div class="logo-icon">🏬</div>
                <div class="logo-text">
                    <span class="logo-name">Grand Mall</span>
                    <span class="logo-sub">de Conakry</span>
                </div>
            </a>

            <nav class="nav" id="navbar">
                <ul class="nav-links" id="nav-links">
                    <li><a href="<?= SITE_URL ?>/" class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>">Accueil</a></li>
                    <li><a href="<?= SITE_URL ?>/le-projet.php" class="nav-link <?= $currentPage === 'le-projet' ? 'active' : '' ?>">Le Projet</a></li>
                    <li><a href="<?= SITE_URL ?>/espaces-services.php" class="nav-link <?= $currentPage === 'espaces-services' ? 'active' : '' ?>">Espaces</a></li>
                    <li><a href="<?= SITE_URL ?>/boutiques.php" class="nav-link <?= $currentPage === 'boutiques' ? 'active' : '' ?>">Boutiques</a></li>
                    <li><a href="<?= SITE_URL ?>/actualites.php" class="nav-link <?= $currentPage === 'actualites' ? 'active' : '' ?>">Actualités</a></li>
                    <li><a href="<?= SITE_URL ?>/galerie.php" class="nav-link <?= $currentPage === 'galerie' ? 'active' : '' ?>">Galerie</a></li>
                </ul>

                <a href="<?= SITE_URL ?>/contact.php" class="btn btn-gold btn-nav" id="cta-header">
                    <span>Nous Contacter</span>
                </a>

                <button class="menu-toggle" id="menu-toggle" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </nav>
        </div>
    </header>
