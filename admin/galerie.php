<?php
/**
 * Grand Mall de Conakry — Admin Galerie
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/galerie.php'); }
    $postAction = input('post_action');

    if ($postAction === 'upload') {
        $category = input('category', 'general');
        $uploaded = 0;
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $i => $name) {
                $file = [
                    'name' => $_FILES['images']['name'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'error' => $_FILES['images']['error'][$i],
                    'size' => $_FILES['images']['size'][$i],
                ];
                $img = uploadImage($file, 'gallery');
                if ($img) {
                    Database::insert('medias', [
                        'filename' => $img,
                        'original_name' => $name,
                        'alt_text' => pathinfo($name, PATHINFO_FILENAME),
                        'type' => 'image',
                        'category' => $category,
                        'size' => $file['size'],
                    ]);
                    $uploaded++;
                }
            }
        }
        flash('success', "$uploaded image(s) uploadée(s).");
        redirect(SITE_URL . '/admin/galerie.php');
    }
    if ($postAction === 'delete') {
        $media = Database::fetch("SELECT * FROM medias WHERE id = ?", [(int) input('id')]);
        if ($media) {
            $path = UPLOADS_PATH . $media['filename'];
            if (file_exists($path)) unlink($path);
            Database::delete('medias', 'id = ?', [$media['id']]);
            flash('success', 'Média supprimé.');
        }
        redirect(SITE_URL . '/admin/galerie.php');
    }
    if ($postAction === 'update_alt') {
        Database::update('medias', ['alt_text' => input('alt_text')], 'id = ?', [(int) input('id')]);
        flash('success', 'Texte alt mis à jour.');
        redirect(SITE_URL . '/admin/galerie.php');
    }
}

$filter = input('filter', '');
$where = $filter ? "category = ?" : "1";
$params = $filter ? [$filter] : [];
$medias = Database::fetchAll("SELECT * FROM medias WHERE $where ORDER BY created_at DESC", $params);
$categories = Database::fetchAll("SELECT DISTINCT category FROM medias ORDER BY category");
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Galerie — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar"><button class="menu-btn" id="menu-btn">☰</button><h1>Galerie (<?= count($medias) ?>)</h1>
            <div class="user-info"><button class="btn btn-gold" onclick="document.getElementById('upload-form').style.display=document.getElementById('upload-form').style.display==='none'?'block':'none'">📤 Uploader</button></div>
        </header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <!-- Upload Form -->
            <div id="upload-form" class="section-card" style="display:<?= $action === 'upload' ? 'block' : 'none' ?>">
                <h2>Uploader des images</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="post_action" value="upload">
                    <?= Auth::csrfField() ?>
                    <div class="form-row">
                        <div class="form-group" style="flex:2"><label>Images (plusieurs possibles)</label><input type="file" name="images[]" class="form-control" accept="image/*" multiple required></div>
                        <div class="form-group" style="flex:1"><label>Catégorie</label>
                            <select name="category" class="form-control"><option value="general">Général</option><option value="chantier">Chantier</option><option value="rendu3d">Rendus 3D</option><option value="evenement">Événement</option><option value="interieur">Intérieur</option></select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold">📤 Envoyer</button>
                </form>
            </div>

            <!-- Filter -->
            <?php if (!empty($categories)): ?>
            <div style="margin-bottom:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
                <a href="?filter=" class="btn <?= !$filter ? 'btn-gold' : 'btn-outline' ?>" style="padding:0.3rem 0.8rem;font-size:0.8rem;">Tous</a>
                <?php foreach ($categories as $c): ?>
                    <a href="?filter=<?= e($c['category']) ?>" class="btn <?= $filter === $c['category'] ? 'btn-gold' : 'btn-outline' ?>" style="padding:0.3rem 0.8rem;font-size:0.8rem;"><?= ucfirst(e($c['category'])) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Gallery Grid -->
            <div class="gallery-admin-grid">
                <?php if (empty($medias)): ?><p class="empty-state">Aucun média. Cliquez sur Uploader pour commencer.</p>
                <?php else: foreach ($medias as $m): ?>
                <div class="gallery-item">
                    <img src="<?= upload($m['filename']) ?>" alt="<?= e($m['alt_text']) ?>" loading="lazy">
                    <div class="gallery-info">
                        <small><?= e($m['category']) ?> • <?= round($m['size']/1024) ?> Ko</small>
                        <div class="btn-group" style="margin-top:0.3rem;">
                            <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')"><input type="hidden" name="post_action" value="delete"><input type="hidden" name="id" value="<?= $m['id'] ?>"><?= Auth::csrfField() ?>
                                <button type="submit" class="btn btn-danger" style="padding:0.2rem 0.5rem;font-size:0.7rem;">🗑️</button></form>
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
<style>.gallery-admin-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;}.gallery-item{background:var(--admin-card,rgba(255,255,255,0.04));border:1px solid var(--admin-border,rgba(255,255,255,0.08));border-radius:10px;overflow:hidden;}.gallery-item img{width:100%;height:160px;object-fit:cover;}.gallery-info{padding:0.5rem 0.75rem;font-size:0.75rem;color:var(--admin-text-muted,#94a3b8);}</style>
</body></html>
