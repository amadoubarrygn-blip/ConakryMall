<?php
/**
 * Grand Mall de Conakry — Admin Services
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/services.php'); }
    $postAction = input('post_action');

    if ($postAction === 'save') {
        $id = (int) input('id', 0);
        $data = [
            'name' => input('name'),
            'slug' => slugify(input('name')),
            'icon' => input('icon'),
            'short_description' => input('short_description'),
            'description' => $_POST['description'] ?? '',
            'sort_order' => (int) input('sort_order', 0),
            'status' => input('status', 'active'),
        ];
        if (!empty($_FILES['image']['name'])) {
            $img = uploadImage($_FILES['image'], 'services');
            if ($img) $data['image'] = $img;
        }
        if ($id > 0) { Database::update('services', $data, 'id = ?', [$id]); flash('success', 'Service mis à jour.'); }
        else { Database::insert('services', $data); flash('success', 'Service créé.'); }
        redirect(SITE_URL . '/admin/services.php');
    }
    if ($postAction === 'delete') {
        Database::delete('services', 'id = ?', [(int) input('id')]);
        flash('success', 'Service supprimé.');
        redirect(SITE_URL . '/admin/services.php');
    }
}

$service = null;
if (($action === 'edit') && (int) input('id', 0) > 0) {
    $service = Database::fetch("SELECT * FROM services WHERE id = ?", [(int) input('id')]);
}
$services = Database::fetchAll("SELECT * FROM services ORDER BY sort_order ASC");
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Services — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar"><button class="menu-btn" id="menu-btn">☰</button>
            <h1><?= ($action === 'new' || $action === 'edit') ? ($service ? 'Modifier' : 'Nouveau service') : 'Services' ?></h1>
            <div class="user-info">
                <?php if ($action === 'list'): ?><a href="?action=new" class="btn btn-gold">➕ Nouveau service</a>
                <?php else: ?><a href="<?= SITE_URL ?>/admin/services.php" class="btn btn-outline">← Retour</a><?php endif; ?>
            </div>
        </header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
            <form method="POST" enctype="multipart/form-data" class="section-card">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= $service['id'] ?? 0 ?>">
                <?= Auth::csrfField() ?>
                <div class="form-row">
                    <div class="form-group" style="flex:2"><label>Nom</label><input type="text" name="name" class="form-control" required value="<?= e($service['name'] ?? '') ?>"></div>
                    <div class="form-group" style="flex:1"><label>Icône (emoji)</label><input type="text" name="icon" class="form-control" value="<?= e($service['icon'] ?? '') ?>" placeholder="🛒"></div>
                    <div class="form-group" style="flex:1"><label>Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= $service['sort_order'] ?? 0 ?>"></div>
                </div>
                <div class="form-group"><label>Description courte</label><input type="text" name="short_description" class="form-control" value="<?= e($service['short_description'] ?? '') ?>"></div>
                <div class="form-group"><label>Description complète</label><textarea name="description" class="form-control" rows="6"><?= e($service['description'] ?? '') ?></textarea></div>
                <div class="form-row">
                    <div class="form-group" style="flex:1"><label>Image</label><input type="file" name="image" class="form-control" accept="image/*">
                        <?php if (!empty($service['image'])): ?><img src="<?= upload($service['image']) ?>" alt="" style="max-width:200px;margin-top:0.5rem;border-radius:8px;"><?php endif; ?>
                    </div>
                    <div class="form-group" style="flex:1"><label>Statut</label>
                        <select name="status" class="form-control"><option value="active" <?= ($service['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Actif</option><option value="inactive" <?= ($service['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactif</option></select>
                    </div>
                </div>
                <div class="btn-group" style="margin-top:1rem;"><button type="submit" class="btn btn-gold">💾 Enregistrer</button><a href="<?= SITE_URL ?>/admin/services.php" class="btn btn-outline">Annuler</a></div>
            </form>
            <?php else: ?>
            <div class="section-card">
                <table class="data-table"><thead><tr><th>Icône</th><th>Nom</th><th>Description</th><th>Ordre</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
                    <?php foreach ($services as $s): ?><tr>
                        <td style="font-size:1.5rem;"><?= e($s['icon']) ?></td>
                        <td><a href="?action=edit&id=<?= $s['id'] ?>"><?= e($s['name']) ?></a></td>
                        <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= e($s['short_description']) ?></td>
                        <td><?= $s['sort_order'] ?></td>
                        <td><span class="badge badge-<?= $s['status'] ?>"><?= $s['status'] === 'active' ? 'Actif' : 'Inactif' ?></span></td>
                        <td><div class="btn-group"><a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.75rem;">✏️</a>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')"><input type="hidden" name="post_action" value="delete"><input type="hidden" name="id" value="<?= $s['id'] ?>"><?= Auth::csrfField() ?><button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.75rem;">🗑️</button></form></div></td>
                    </tr><?php endforeach; ?></tbody></table>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
</body></html>
