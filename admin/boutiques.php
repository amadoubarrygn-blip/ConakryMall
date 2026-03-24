<?php
/**
 * Grand Mall de Conakry — Admin Boutiques CRUD
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/boutiques.php'); }
    $postAction = input('post_action');

    if ($postAction === 'save') {
        $id = (int) input('id', 0);
        $data = [
            'name' => input('name'),
            'slug' => slugify(input('name')),
            'category' => input('category'),
            'floor' => input('floor'),
            'description' => $_POST['description'] ?? '',
            'website' => input('website'),
            'phone' => input('phone'),
            'status' => input('status', 'coming_soon'),
            'sort_order' => (int) input('sort_order', 0),
        ];
        if (!empty($_FILES['logo']['name'])) {
            $img = uploadImage($_FILES['logo'], 'boutiques');
            if ($img) $data['logo'] = $img;
        }
        if ($id > 0) { Database::update('boutiques', $data, 'id = ?', [$id]); flash('success', 'Boutique mise à jour.'); }
        else { Database::insert('boutiques', $data); flash('success', 'Boutique créée.'); }
        redirect(SITE_URL . '/admin/boutiques.php');
    }
    if ($postAction === 'delete') {
        Database::delete('boutiques', 'id = ?', [(int) input('id')]);
        flash('success', 'Boutique supprimée.');
        redirect(SITE_URL . '/admin/boutiques.php');
    }
}

$boutique = null;
if (($action === 'edit' || $action === 'new') && (int) input('id', 0) > 0) {
    $boutique = Database::fetch("SELECT * FROM boutiques WHERE id = ?", [(int) input('id')]);
}
$boutiques = Database::fetchAll("SELECT * FROM boutiques ORDER BY sort_order ASC, name ASC");
$flashes = getFlashes();
$categories = ['mode','electronique','alimentation','restauration','beaute','sport','loisirs','services','autre'];
$floors = ['Sous-sol 2','Sous-sol 1','Rez-de-chaussée','Étage 1'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Boutiques — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <button class="menu-btn" id="menu-btn">☰</button>
            <h1><?= ($action === 'new' || $action === 'edit') ? ($boutique ? 'Modifier' : 'Nouvelle boutique') : 'Boutiques' ?></h1>
            <div class="user-info">
                <?php if ($action === 'list'): ?><a href="?action=new" class="btn btn-gold">➕ Nouvelle boutique</a>
                <?php else: ?><a href="<?= SITE_URL ?>/admin/boutiques.php" class="btn btn-outline">← Retour</a><?php endif; ?>
            </div>
        </header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
            <form method="POST" enctype="multipart/form-data" class="section-card">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= $boutique['id'] ?? 0 ?>">
                <?= Auth::csrfField() ?>
                <div class="form-row">
                    <div class="form-group" style="flex:2"><label>Nom</label><input type="text" name="name" class="form-control" required value="<?= e($boutique['name'] ?? '') ?>"></div>
                    <div class="form-group" style="flex:1"><label>Catégorie</label>
                        <select name="category" class="form-control"><?php foreach ($categories as $c): ?>
                            <option value="<?= $c ?>" <?= ($boutique['category'] ?? '') === $c ? 'selected' : '' ?>><?= ucfirst($c) ?></option>
                        <?php endforeach; ?></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex:1"><label>Étage</label>
                        <select name="floor" class="form-control"><?php foreach ($floors as $f): ?>
                            <option value="<?= $f ?>" <?= ($boutique['floor'] ?? '') === $f ? 'selected' : '' ?>><?= $f ?></option>
                        <?php endforeach; ?></select>
                    </div>
                    <div class="form-group" style="flex:1"><label>Statut</label>
                        <select name="status" class="form-control">
                            <option value="coming_soon" <?= ($boutique['status'] ?? '') === 'coming_soon' ? 'selected' : '' ?>>Bientôt</option>
                            <option value="active" <?= ($boutique['status'] ?? '') === 'active' ? 'selected' : '' ?>>Actif</option>
                            <option value="inactive" <?= ($boutique['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1"><label>Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= $boutique['sort_order'] ?? 0 ?>"></div>
                </div>
                <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="4"><?= e($boutique['description'] ?? '') ?></textarea></div>
                <div class="form-row">
                    <div class="form-group" style="flex:1"><label>Site web</label><input type="url" name="website" class="form-control" value="<?= e($boutique['website'] ?? '') ?>"></div>
                    <div class="form-group" style="flex:1"><label>Téléphone</label><input type="text" name="phone" class="form-control" value="<?= e($boutique['phone'] ?? '') ?>"></div>
                </div>
                <div class="form-group"><label>Logo</label><input type="file" name="logo" class="form-control" accept="image/*">
                    <?php if (!empty($boutique['logo'])): ?><img src="<?= upload($boutique['logo']) ?>" alt="" style="max-width:100px;margin-top:0.5rem;border-radius:8px;"><?php endif; ?>
                </div>
                <div class="btn-group" style="margin-top:1rem;"><button type="submit" class="btn btn-gold">💾 Enregistrer</button><a href="<?= SITE_URL ?>/admin/boutiques.php" class="btn btn-outline">Annuler</a></div>
            </form>
            <?php else: ?>
            <div class="section-card">
                <?php if (empty($boutiques)): ?><p class="empty-state">Aucune boutique. <a href="?action=new">Ajouter →</a></p>
                <?php else: ?>
                <table class="data-table"><thead><tr><th>Nom</th><th>Catégorie</th><th>Étage</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
                    <?php foreach ($boutiques as $b): ?><tr>
                        <td><a href="?action=edit&id=<?= $b['id'] ?>"><?= e($b['name']) ?></a></td>
                        <td><?= e($b['category']) ?></td><td><?= e($b['floor']) ?></td>
                        <td><span class="badge badge-<?= $b['status'] ?>"><?= $b['status'] === 'active' ? 'Actif' : ($b['status'] === 'coming_soon' ? 'Bientôt' : 'Inactif') ?></span></td>
                        <td><div class="btn-group"><a href="?action=edit&id=<?= $b['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.75rem;">✏️</a>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')"><input type="hidden" name="post_action" value="delete"><input type="hidden" name="id" value="<?= $b['id'] ?>"><?= Auth::csrfField() ?><button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.75rem;">🗑️</button></form></div></td>
                    </tr><?php endforeach; ?></tbody></table>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
</body></html>
