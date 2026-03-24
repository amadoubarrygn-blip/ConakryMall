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
    <meta property="og:image" content="<?= asset('img/logo-dark.png') ?>">

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
    <link rel="icon" type="image/png" href="<?= asset('img/logo-dark.png') ?>">
    <link rel="apple-touch-icon" href="<?= asset('img/logo-dark.png') ?>">

    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>

    <!-- Splash Screen — auto-hides via CSS even if JS fails -->
    <div id="splash-screen" style="position:fixed;inset:0;z-index:9999999;background:#0A1628;display:flex;flex-direction:column;align-items:center;justify-content:center;animation:splashOut 0.5s ease 1.5s forwards;">
        <img src="<?= asset('img/logo-white.png') ?>" alt="" style="width:100px;margin-bottom:1.5rem;animation:splashP 1.2s ease-in-out infinite;">
        <div style="width:180px;height:3px;background:rgba(255,255,255,0.1);border-radius:2px;overflow:hidden;"><div style="height:100%;width:0;background:linear-gradient(90deg,#C9A351,#E8D48B);border-radius:2px;animation:splashF 1.2s ease-out forwards;"></div></div>
    </div>
    <style>
    @keyframes splashP{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}
    @keyframes splashF{0%{width:0}100%{width:100%}}
    @keyframes splashOut{to{opacity:0;visibility:hidden;pointer-events:none}}
    </style>
    <script>if(sessionStorage.getItem('gcm_s')){document.getElementById('splash-screen').remove();}else{sessionStorage.setItem('gcm_s','1');}</script>

    <!-- ======= HEADER ======= -->
    <header class="header" id="header">
        <div class="container">
            <a href="<?= SITE_URL ?>/" class="logo">
                <img src="<?= asset('img/logo-white.png') ?>" alt="Conakry Mall" class="logo-img">
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
