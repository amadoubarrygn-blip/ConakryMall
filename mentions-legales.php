<?php
/**
 * Grand Mall de Conakry — Mentions Légales
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$pageTitle = 'Mentions Légales';
$pageDescription = 'Mentions légales du Grand Mall de Conakry.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero page-hero-sm">
        <div class="container">
            <h1 data-aos="fade-up">Mentions <span class="gold">Légales</span></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="legal-content" data-aos="fade-up">
                <h2>Éditeur du site</h2>
                <p>
                    <strong>Kakandé Immo SA</strong><br>
                    Filiale du Groupe Guicopres<br>
                    Adresse : <?= e(getSetting('site_address', 'Plateau de Koloma, Conakry, Guinée')) ?><br>
                    Email : <?= e(getSetting('site_email', 'contact@grandmall.gn')) ?><br>
                    Téléphone : <?= e(getSetting('site_phone', '+224 000 000 000')) ?>
                </p>

                <h2>Hébergement</h2>
                <p>Ce site est hébergé par un prestataire professionnel assurant la sécurité et la disponibilité des données.</p>

                <h2>Propriété intellectuelle</h2>
                <p>L'ensemble du contenu de ce site (textes, images, logos, vidéos, marques) est protégé par le droit de la propriété intellectuelle. Toute reproduction, même partielle, est interdite sans autorisation préalable.</p>

                <h2>Protection des données</h2>
                <p>Les informations collectées via le formulaire de contact sont destinées exclusivement au traitement de votre demande. Elles ne seront ni vendues, ni partagées avec des tiers. Conformément à la réglementation en vigueur, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles.</p>

                <h2>Cookies</h2>
                <p>Ce site utilise des cookies techniques nécessaires à son fonctionnement. Aucun cookie de pistage ou publicitaire n'est déposé sans votre consentement.</p>

                <h2>Responsabilité</h2>
                <p>L'éditeur met tout en œuvre pour assurer l'exactitude des informations publiées. Toutefois, il ne saurait être tenu responsable des erreurs ou omissions, ni des résultats obtenus suite à l'utilisation de ces informations.</p>
            </div>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
