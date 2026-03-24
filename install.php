<?php
/**
 * Grand Mall de Conakry — Installation
 * 
 * Ce script crée les tables et le compte admin initial.
 * À supprimer après la première installation.
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$messages = [];

try {
    $pdo = Database::getInstance();

    // === CRÉER LES TABLES ===
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            content TEXT,
            excerpt TEXT,
            image VARCHAR(255),
            category VARCHAR(100) DEFAULT 'general',
            status ENUM('draft','published') DEFAULT 'draft',
            author_id INT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_slug (slug),
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table articles créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS boutiques (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            category VARCHAR(100),
            floor VARCHAR(50),
            logo VARCHAR(255),
            description TEXT,
            website VARCHAR(255),
            phone VARCHAR(50),
            status ENUM('active','coming_soon','inactive') DEFAULT 'coming_soon',
            sort_order INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_category (category)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table boutiques créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS medias (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL,
            original_name VARCHAR(255),
            alt_text VARCHAR(255),
            type ENUM('image','video') DEFAULT 'image',
            category VARCHAR(100) DEFAULT 'general',
            size INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_type (type),
            INDEX idx_category (category)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table medias créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slug VARCHAR(100) UNIQUE NOT NULL,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            meta_description TEXT,
            meta_keywords VARCHAR(255),
            status ENUM('active','draft') DEFAULT 'active',
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_slug (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table pages créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS settings (
            setting_key VARCHAR(100) PRIMARY KEY,
            setting_value TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table settings créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) UNIQUE NOT NULL,
            email VARCHAR(255),
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('admin','editor') DEFAULT 'editor',
            last_login DATETIME,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_username (username)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table users créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS sliders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            subtitle TEXT,
            image VARCHAR(255) NOT NULL,
            button_text VARCHAR(100),
            button_url VARCHAR(255),
            sort_order INT DEFAULT 0,
            status ENUM('active','inactive') DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_status_order (status, sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table sliders créée'];

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS services (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            icon VARCHAR(100),
            short_description TEXT,
            description TEXT,
            image VARCHAR(255),
            sort_order INT DEFAULT 0,
            status ENUM('active','inactive') DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    $messages[] = ['success', '✅ Table services créée'];

    // === COMPTE ADMIN PAR DÉFAUT ===
    $existing = Database::fetch("SELECT id FROM users WHERE username = 'admin'");
    if (!$existing) {
        $hash = Auth::hashPassword('GrandMall@2026');
        Database::insert('users', [
            'username' => 'admin',
            'email' => 'admin@grandmall.gn',
            'password_hash' => $hash,
            'role' => 'admin'
        ]);
        $messages[] = ['success', '✅ Compte admin créé — Login: admin / Mot de passe: GrandMall@2026'];
    } else {
        $messages[] = ['info', 'ℹ️ Compte admin existe déjà'];
    }

    // === PARAMÈTRES PAR DÉFAUT ===
    $defaults = [
        'site_name' => 'Grand Mall de Conakry',
        'site_tagline' => "L'expérience shopping réinventée",
        'site_email' => 'contact@grandmall.gn',
        'site_phone' => '+224 000 000 000',
        'site_address' => 'Plateau de Koloma, Conakry, Guinée',
        'facebook_url' => '',
        'instagram_url' => '',
        'whatsapp_number' => '',
        'youtube_url' => '',
    ];

    foreach ($defaults as $key => $value) {
        $existing = Database::fetch("SELECT setting_key FROM settings WHERE setting_key = ?", [$key]);
        if (!$existing) {
            Database::insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
    }
    $messages[] = ['success', '✅ Paramètres par défaut configurés'];

    // === SERVICES PAR DÉFAUT ===
    $services = [
        ['Hypermarché', 'hypermarche', '🛒', 'Un supermarché moderne pour tous vos besoins quotidiens.'],
        ['Espace Bien-être', 'bien-etre', '💆', 'Spa, fitness et détente dans un cadre luxueux.'],
        ['Cinéma', 'cinema', '🎬', 'Salles de cinéma dernière génération avec son immersif.'],
        ['Aquarium', 'aquarium', '🐠', 'Un aquarium spectaculaire au cœur du mall.'],
        ['Espaces de Jeux', 'jeux', '🎮', 'Divertissement pour toute la famille.'],
        ['Magasins', 'magasins', '🛍️', 'Des boutiques modulables pour toutes les enseignes.'],
        ['Salles d\'Exposition', 'expositions', '🎨', 'Espaces événementiels pour salons et expositions.'],
        ['Pôle de Services', 'services', '🏢', 'Banques, assurances, coworking et services professionnels.'],
    ];

    foreach ($services as $i => $s) {
        $existing = Database::fetch("SELECT id FROM services WHERE slug = ?", [$s[1]]);
        if (!$existing) {
            Database::insert('services', [
                'name' => $s[0], 'slug' => $s[1], 'icon' => $s[2],
                'short_description' => $s[3], 'sort_order' => $i + 1, 'status' => 'active'
            ]);
        }
    }
    $messages[] = ['success', '✅ 8 services initiaux créés'];

} catch (Exception $e) {
    $messages[] = ['error', '❌ Erreur : ' . $e->getMessage()];
}

// === CRÉER LE DOSSIER UPLOADS ===
$uploadDirs = ['uploads', 'uploads/articles', 'uploads/boutiques', 'uploads/gallery', 'uploads/sliders'];
foreach ($uploadDirs as $dir) {
    $path = ASSETS_PATH . $dir;
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        $messages[] = ['success', "✅ Dossier $dir créé"];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Installation — Grand Mall de Conakry</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0A1628; color: #e2e8f0; font-family: 'Inter', sans-serif; padding: 2rem; }
        .container { max-width: 700px; margin: 0 auto; }
        h1 { color: #C9A351; font-size: 1.8rem; margin-bottom: 1.5rem; text-align: center; }
        .msg { padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; font-size: 0.9rem; }
        .msg.success { background: rgba(0,150,57,0.15); border: 1px solid #009639; }
        .msg.error { background: rgba(206,17,38,0.15); border: 1px solid #CE1126; }
        .msg.info { background: rgba(201,163,81,0.15); border: 1px solid #C9A351; }
        .warning { background: rgba(206,17,38,0.2); border: 2px solid #CE1126; padding: 1.5rem; border-radius: 12px; margin-top: 1.5rem; text-align: center; }
        .warning h3 { color: #CE1126; margin-bottom: 0.5rem; }
        a { color: #C9A351; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏗️ Installation — Grand Mall de Conakry</h1>
        <?php foreach ($messages as $m): ?>
            <div class="msg <?= $m[0] ?>"><?= $m[1] ?></div>
        <?php endforeach; ?>
        
        <div class="warning">
            <h3>⚠️ Sécurité</h3>
            <p>Supprimez ce fichier après installation :<br><code>install.php</code></p>
            <p style="margin-top: 1rem;">
                <a href="<?= SITE_URL ?>/admin/login.php">→ Accéder au panel admin</a>
            </p>
        </div>
    </div>
</body>
</html>
