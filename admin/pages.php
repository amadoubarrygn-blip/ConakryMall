<?php
/**
 * Grand Mall de Conakry — Admin Pages
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) { flash('error', 'Token invalide.'); redirect(SITE_URL . '/admin/pages.php'); }
    $postAction = input('post_action');

    if ($postAction === 'save') {
        $id = (int) input('id', 0);
        $data = [
            'title' => input('title'),
            'slug' => slugify(input('title')),
            'content' => $_POST['content'] ?? '',
            'meta_description' => input('meta_description'),
            'meta_keywords' => input('meta_keywords'),
            'status' => input('status', 'active'),
        ];
        if ($id > 0) { Database::update('pages', $data, 'id = ?', [$id]); flash('success', 'Page mise à jour.'); }
        else { Database::insert('pages', $data); flash('success', 'Page créée.'); }
        redirect(SITE_URL . '/admin/pages.php');
    }
    if ($postAction === 'delete') {
        Database::delete('pages', 'id = ?', [(int) input('id')]);
        flash('success', 'Page supprimée.');
        redirect(SITE_URL . '/admin/pages.php');
    }
}

$page = null;
if (($action === 'edit') && (int) input('id', 0) > 0) {
    $page = Database::fetch("SELECT * FROM pages WHERE id = ?", [(int) input('id')]);
}
$pages = Database::fetchAll("SELECT * FROM pages ORDER BY title ASC");
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Pages — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar"><button class="menu-btn" id="menu-btn">☰</button>
            <h1><?= ($action === 'new' || $action === 'edit') ? ($page ? 'Modifier la page' : 'Nouvelle page') : 'Pages' ?></h1>
            <div class="user-info">
                <?php if ($action === 'list'): ?><a href="?action=new" class="btn btn-gold">➕ Nouvelle page</a>
                <?php else: ?><a href="<?= SITE_URL ?>/admin/pages.php" class="btn btn-outline">← Retour</a><?php endif; ?>
            </div>
        </header>
        <div class="content">
            <?php foreach ($flashes as $f): ?><div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
            <form method="POST" class="section-card">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= $page['id'] ?? 0 ?>">
                <?= Auth::csrfField() ?>
                <div class="form-row">
                    <div class="form-group" style="flex:2"><label>Titre</label><input type="text" name="title" class="form-control" required value="<?= e($page['title'] ?? '') ?>"></div>
                    <div class="form-group" style="flex:1"><label>Statut</label>
                        <select name="status" class="form-control"><option value="active" <?= ($page['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Actif</option><option value="draft" <?= ($page['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Brouillon</option></select>
                    </div>
                </div>
                <div class="form-group"><label>Contenu</label><textarea name="content" class="form-control" rows="15"><?= e($page['content'] ?? '') ?></textarea></div>
                <div class="form-row">
                    <div class="form-group" style="flex:1"><label>Meta description (SEO)</label><textarea name="meta_description" class="form-control" rows="2"><?= e($page['meta_description'] ?? '') ?></textarea></div>
                    <div class="form-group" style="flex:1"><label>Mots-clés (SEO)</label><input type="text" name="meta_keywords" class="form-control" value="<?= e($page['meta_keywords'] ?? '') ?>" placeholder="mot-clé1, mot-clé2"></div>
                </div>
                <div class="btn-group" style="margin-top:1rem;"><button type="submit" class="btn btn-gold">💾 Enregistrer</button><a href="<?= SITE_URL ?>/admin/pages.php" class="btn btn-outline">Annuler</a></div>
            </form>
            <?php else: ?>
            <div class="section-card">
                <?php if (empty($pages)): ?><p class="empty-state">Aucune page. <a href="?action=new">Créer →</a></p>
                <?php else: ?>
                <table class="data-table"><thead><tr><th>Titre</th><th>Slug</th><th>Statut</th><th>Dernière modification</th><th>Actions</th></tr></thead><tbody>
                    <?php foreach ($pages as $p): ?><tr>
                        <td><a href="?action=edit&id=<?= $p['id'] ?>"><?= e($p['title']) ?></a></td>
                        <td><code><?= e($p['slug']) ?></code></td>
                        <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] === 'active' ? 'Actif' : 'Brouillon' ?></span></td>
                        <td><?= $p['updated_at'] ? dateFormatFr($p['updated_at']) : '—' ?></td>
                        <td><div class="btn-group"><a href="?action=edit&id=<?= $p['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.75rem;">✏️</a>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')"><input type="hidden" name="post_action" value="delete"><input type="hidden" name="id" value="<?= $p['id'] ?>"><?= Auth::csrfField() ?><button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.75rem;">🗑️</button></form></div></td>
                    </tr><?php endforeach; ?></tbody></table>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>document.getElementById('menu-btn')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));</script>
</body></html>
