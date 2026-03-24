<?php
/**
 * Grand Mall de Conakry — Admin Paramètres
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();
if (!Auth::isAdmin()) { flash('error', 'Accès réservé aux administrateurs.'); redirect(SITE_URL . '/admin/'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/parametres.php'); }

    $settings = ['site_name','site_tagline','site_email','site_phone','site_address','facebook_url','instagram_url','whatsapp_number','youtube_url','meta_description','google_analytics'];
    foreach ($settings as $key) {
        $value = input($key, '');
        setSetting($key, $value);
    }

    // Logo upload
    if (!empty($_FILES['site_logo']['name'])) {
        $logo = uploadImage($_FILES['site_logo'], '');
        if ($logo) setSetting('site_logo', $logo);
    }

    flash('success', 'Paramètres mis à jour.');
    redirect(SITE_URL . '/admin/parametres.php');
}

// Charger les paramètres actuels
$s = [];
$allSettings = Database::fetchAll("SELECT * FROM settings");
foreach ($allSettings as $row) $s[$row['setting_key']] = $row['setting_value'];

$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Paramètres — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar"><button class="menu-btn" id="menu-btn">☰</button><h1>Paramètres généraux</h1><div class="user-info"></div></header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <form method="POST" enctype="multipart/form-data">
                <?= Auth::csrfField() ?>

                <div class="section-card">
                    <h2>🏬 Informations du site</h2>
                    <div class="form-row">
                        <div class="form-group" style="flex:1"><label>Nom du site</label><input type="text" name="site_name" class="form-control" value="<?= e($s['site_name'] ?? '') ?>"></div>
                        <div class="form-group" style="flex:1"><label>Slogan</label><input type="text" name="site_tagline" class="form-control" value="<?= e($s['site_tagline'] ?? '') ?>"></div>
                    </div>
                    <div class="form-group"><label>Description SEO</label><textarea name="meta_description" class="form-control" rows="2"><?= e($s['meta_description'] ?? '') ?></textarea></div>
                    <div class="form-group"><label>Logo</label><input type="file" name="site_logo" class="form-control" accept="image/*">
                        <?php if (!empty($s['site_logo'])): ?><img src="<?= upload($s['site_logo']) ?>" alt="Logo" style="max-width:120px;margin-top:0.5rem;"><?php endif; ?>
                    </div>
                </div>

                <div class="section-card">
                    <h2>📞 Contact</h2>
                    <div class="form-row">
                        <div class="form-group" style="flex:1"><label>Email</label><input type="email" name="site_email" class="form-control" value="<?= e($s['site_email'] ?? '') ?>"></div>
                        <div class="form-group" style="flex:1"><label>Téléphone</label><input type="text" name="site_phone" class="form-control" value="<?= e($s['site_phone'] ?? '') ?>"></div>
                    </div>
                    <div class="form-group"><label>Adresse</label><input type="text" name="site_address" class="form-control" value="<?= e($s['site_address'] ?? '') ?>"></div>
                </div>

                <div class="section-card">
                    <h2>🌐 Réseaux sociaux</h2>
                    <div class="form-row">
                        <div class="form-group" style="flex:1"><label>Facebook URL</label><input type="url" name="facebook_url" class="form-control" value="<?= e($s['facebook_url'] ?? '') ?>"></div>
                        <div class="form-group" style="flex:1"><label>Instagram URL</label><input type="url" name="instagram_url" class="form-control" value="<?= e($s['instagram_url'] ?? '') ?>"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="flex:1"><label>WhatsApp N°</label><input type="text" name="whatsapp_number" class="form-control" value="<?= e($s['whatsapp_number'] ?? '') ?>" placeholder="224612345678"></div>
                        <div class="form-group" style="flex:1"><label>YouTube URL</label><input type="url" name="youtube_url" class="form-control" value="<?= e($s['youtube_url'] ?? '') ?>"></div>
                    </div>
                </div>

                <div class="section-card">
                    <h2>📊 Analytics</h2>
                    <div class="form-group"><label>Google Analytics ID</label><input type="text" name="google_analytics" class="form-control" value="<?= e($s['google_analytics'] ?? '') ?>" placeholder="G-XXXXXXXXXX"></div>
                </div>

                <button type="submit" class="btn btn-gold btn-lg" style="margin-top:1rem;">💾 Enregistrer les paramètres</button>
            </form>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
</body></html>
