<?php
/**
 * Grand Mall de Conakry — Admin Sliders CRUD
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/sliders.php'); }
    $postAction = input('post_action');

    if ($postAction === 'save') {
        $id = (int) input('id', 0);
        $data = [
            'title' => input('title'),
            'subtitle' => input('subtitle'),
            'button_text' => input('button_text'),
            'button_url' => input('button_url'),
            'sort_order' => (int) input('sort_order', 0),
            'status' => input('status', 'active'),
        ];
        if (!empty($_FILES['image']['name'])) {
            $img = uploadImage($_FILES['image'], 'sliders');
            if ($img) $data['image'] = $img;
        } elseif ($id === 0) {
            flash('error', 'Une image est requise pour un nouveau slide.');
            redirect(SITE_URL . '/admin/sliders.php?action=new');
        }
        if ($id > 0) { Database::update('sliders', $data, 'id = ?', [$id]); flash('success', 'Slide mis à jour.'); }
        else { Database::insert('sliders', $data); flash('success', 'Slide créé.'); }
        redirect(SITE_URL . '/admin/sliders.php');
    }
    if ($postAction === 'delete') {
        Database::delete('sliders', 'id = ?', [(int) input('id')]);
        flash('success', 'Slide supprimé.');
        redirect(SITE_URL . '/admin/sliders.php');
    }
}

$slider = null;
if (($action === 'edit') && (int) input('id', 0) > 0) {
    $slider = Database::fetch("SELECT * FROM sliders WHERE id = ?", [(int) input('id')]);
}
$sliders = Database::fetchAll("SELECT * FROM sliders ORDER BY sort_order ASC");
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Sliders — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <button class="menu-btn" id="menu-btn">☰</button>
            <h1><?= ($action === 'new' || $action === 'edit') ? ($slider ? 'Modifier le slide' : 'Nouveau slide') : 'Sliders' ?></h1>
            <div class="user-info">
                <?php if ($action === 'list'): ?><a href="?action=new" class="btn btn-gold">➕ Nouveau slide</a>
                <?php else: ?><a href="<?= SITE_URL ?>/admin/sliders.php" class="btn btn-outline">← Retour</a><?php endif; ?>
            </div>
        </header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
            <form method="POST" enctype="multipart/form-data" class="section-card">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= $slider['id'] ?? 0 ?>">
                <?= Auth::csrfField() ?>
                <div class="form-group"><label>Titre</label><input type="text" name="title" class="form-control" value="<?= e($slider['title'] ?? '') ?>" placeholder="Titre du slide"></div>
                <div class="form-group"><label>Sous-titre</label><textarea name="subtitle" class="form-control" rows="2" placeholder="Texte descriptif..."><?= e($slider['subtitle'] ?? '') ?></textarea></div>
                <div class="form-row">
                    <div class="form-group" style="flex:1"><label>Texte du bouton</label><input type="text" name="button_text" class="form-control" value="<?= e($slider['button_text'] ?? '') ?>" placeholder="Ex: Découvrir"></div>
                    <div class="form-group" style="flex:1"><label>URL du bouton</label><input type="text" name="button_url" class="form-control" value="<?= e($slider['button_url'] ?? '') ?>" placeholder="/le-projet.php"></div>
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex:2"><label>Image (1920×800 recommandé)</label><input type="file" name="image" class="form-control" accept="image/*" <?= empty($slider) ? 'required' : '' ?>>
                        <?php if (!empty($slider['image'])): ?><img src="<?= upload($slider['image']) ?>" alt="" style="max-width:300px;margin-top:0.5rem;border-radius:8px;"><?php endif; ?>
                    </div>
                    <div class="form-group" style="flex:1"><label>Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= $slider['sort_order'] ?? 0 ?>"></div>
                    <div class="form-group" style="flex:1"><label>Statut</label>
                        <select name="status" class="form-control"><option value="active" <?= ($slider['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Actif</option><option value="inactive" <?= ($slider['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactif</option></select>
                    </div>
                </div>
                <div class="btn-group" style="margin-top:1rem;"><button type="submit" class="btn btn-gold">💾 Enregistrer</button><a href="<?= SITE_URL ?>/admin/sliders.php" class="btn btn-outline">Annuler</a></div>
            </form>
            <?php else: ?>
            <div class="section-card">
                <?php if (empty($sliders)): ?><p class="empty-state">Aucun slide. <a href="?action=new">Ajouter →</a></p>
                <?php else: ?>
                <div class="slider-grid">
                    <?php foreach ($sliders as $s): ?>
                    <div class="slider-card">
                        <img src="<?= upload($s['image']) ?>" alt="<?= e($s['title']) ?>" style="width:100%;height:150px;object-fit:cover;border-radius:8px;">
                        <div style="padding:0.75rem 0;">
                            <strong><?= e($s['title'] ?: 'Sans titre') ?></strong>
                            <span class="badge badge-<?= $s['status'] ?>" style="margin-left:0.5rem;"><?= $s['status'] === 'active' ? 'Actif' : 'Inactif' ?></span>
                        </div>
                        <div class="btn-group"><a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.75rem;">✏️ Modifier</a>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer ce slide ?')"><input type="hidden" name="post_action" value="delete"><input type="hidden" name="id" value="<?= $s['id'] ?>"><?= Auth::csrfField() ?><button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.75rem;">🗑️</button></form></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
<style>.slider-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;}.slider-card{background:var(--admin-card,rgba(255,255,255,0.04));border:1px solid var(--admin-border,rgba(255,255,255,0.08));border-radius:12px;padding:1rem;}</style>
</body></html>
