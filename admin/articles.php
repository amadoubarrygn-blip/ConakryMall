<?php
/**
 * Grand Mall de Conakry — Admin Articles CRUD
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::requireLogin();

$action = input('action', 'list');
$user = Auth::currentUser();

// === TRAITEMENT DES ACTIONS POST ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Auth::verifyCSRF(input('csrf_token', ''))) {
        flash('error', 'Token de sécurité invalide.');
        redirect(SITE_URL . '/admin/articles.php');
    }

    $postAction = input('post_action');

    if ($postAction === 'save') {
        $id = (int) input('id', 0);
        $data = [
            'title' => input('title'),
            'slug' => slugify(input('title')),
            'content' => $_POST['content'] ?? '',
            'excerpt' => input('excerpt'),
            'category' => input('category', 'general'),
            'status' => input('status', 'draft'),
            'author_id' => $user['id'],
        ];

        // Upload image
        if (!empty($_FILES['image']['name'])) {
            $img = uploadImage($_FILES['image'], 'articles');
            if ($img) $data['image'] = $img;
        }

        if ($id > 0) {
            Database::update('articles', $data, 'id = ?', [$id]);
            flash('success', 'Article mis à jour.');
        } else {
            Database::insert('articles', $data);
            flash('success', 'Article créé.');
        }
        redirect(SITE_URL . '/admin/articles.php');
    }

    if ($postAction === 'delete') {
        $id = (int) input('id');
        Database::delete('articles', 'id = ?', [$id]);
        flash('success', 'Article supprimé.');
        redirect(SITE_URL . '/admin/articles.php');
    }
}

// === DONNÉES ===
$article = null;
if ($action === 'edit' || $action === 'new') {
    $id = (int) input('id', 0);
    if ($id > 0) {
        $article = Database::fetch("SELECT * FROM articles WHERE id = ?", [$id]);
    }
}

$articles = Database::fetchAll("SELECT * FROM articles ORDER BY created_at DESC");
$flashes = getFlashes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Articles — <?= e(SITE_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <button class="menu-btn" id="menu-btn">☰</button>
            <h1><?= ($action === 'new' || $action === 'edit') ? ($article ? 'Modifier l\'article' : 'Nouvel article') : 'Articles' ?></h1>
            <div class="user-info">
                <?php if ($action === 'list'): ?>
                    <a href="?action=new" class="btn btn-gold">➕ Nouvel article</a>
                <?php else: ?>
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="btn btn-outline">← Retour</a>
                <?php endif; ?>
            </div>
        </header>

        <div class="content">
            <?php foreach ($flashes as $f): ?>
                <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
            <?php endforeach; ?>

            <?php if ($action === 'new' || $action === 'edit'): ?>
            <!-- === FORMULAIRE === -->
            <form method="POST" enctype="multipart/form-data" class="section-card">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= $article['id'] ?? 0 ?>">
                <?= Auth::csrfField() ?>

                <div class="form-row">
                    <div class="form-group" style="flex:2">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" required value="<?= e($article['title'] ?? '') ?>" placeholder="Titre de l'article">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label for="category">Catégorie</label>
                        <select id="category" name="category" class="form-control">
                            <option value="general" <?= ($article['category'] ?? '') === 'general' ? 'selected' : '' ?>>Général</option>
                            <option value="chantier" <?= ($article['category'] ?? '') === 'chantier' ? 'selected' : '' ?>>Chantier</option>
                            <option value="evenement" <?= ($article['category'] ?? '') === 'evenement' ? 'selected' : '' ?>>Événement</option>
                            <option value="partenariat" <?= ($article['category'] ?? '') === 'partenariat' ? 'selected' : '' ?>>Partenariat</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="excerpt">Résumé (affiché dans les listes)</label>
                    <textarea id="excerpt" name="excerpt" class="form-control" rows="3" placeholder="Résumé court de l'article..."><?= e($article['excerpt'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" class="form-control" rows="12" placeholder="Contenu complet de l'article..."><?= e($article['content'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex:1">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <?php if (!empty($article['image'])): ?>
                            <img src="<?= upload($article['image']) ?>" alt="" style="max-width:200px;margin-top:0.5rem;border-radius:8px;">
                        <?php endif; ?>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label for="status">Statut</label>
                        <select id="status" name="status" class="form-control">
                            <option value="draft" <?= ($article['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="published" <?= ($article['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publié</option>
                        </select>
                    </div>
                </div>

                <div class="btn-group" style="margin-top:1rem;">
                    <button type="submit" class="btn btn-gold">💾 Enregistrer</button>
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="btn btn-outline">Annuler</a>
                </div>
            </form>

            <?php else: ?>
            <!-- === LISTE === -->
            <div class="section-card">
                <?php if (empty($articles)): ?>
                    <p class="empty-state">Aucun article. <a href="?action=new">Créer le premier →</a></p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $a): ?>
                            <tr>
                                <td><a href="?action=edit&id=<?= $a['id'] ?>"><?= e($a['title']) ?></a></td>
                                <td><?= e($a['category']) ?></td>
                                <td><span class="badge badge-<?= $a['status'] ?>"><?= $a['status'] === 'published' ? 'Publié' : 'Brouillon' ?></span></td>
                                <td><?= dateFormatFr($a['created_at']) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="?action=edit&id=<?= $a['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.75rem;">✏️</a>
                                        <form method="POST" style="display:inline" onsubmit="return confirm('Supprimer cet article ?')">
                                            <input type="hidden" name="post_action" value="delete">
                                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                            <?= Auth::csrfField() ?>
                                            <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.75rem;">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>
    document.getElementById('menu-btn')?.addEventListener('click', () => document.getElementById('sidebar').classList.toggle('open'));
</script>
</body>
</html>
