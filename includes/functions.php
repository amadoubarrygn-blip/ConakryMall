<?php
/**
 * Grand Mall de Conakry — Fonctions utilitaires
 */

/**
 * Charger la config + classes de base
 */
function bootstrap(): void {
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/db.php';
    require_once __DIR__ . '/auth.php';
}

/**
 * Échapper du HTML (prévention XSS)
 */
function e(?string $str): string {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Générer un slug URL-friendly
 */
function slugify(string $text): string {
    $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Rediriger proprement
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Message flash (stocké en session)
 */
function flash(string $type, string $message): void {
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function getFlashes(): array {
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

/**
 * Récupérer un paramètre GET/POST nettoyé
 */
function input(string $key, $default = null) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : 
           (isset($_GET[$key]) ? trim($_GET[$key]) : $default);
}

/**
 * Formater une date en français
 */
function dateFormatFr(string $date): string {
    $mois = ['janvier','février','mars','avril','mai','juin',
             'juillet','août','septembre','octobre','novembre','décembre'];
    $d = new DateTime($date);
    return $d->format('j') . ' ' . $mois[(int)$d->format('n')-1] . ' ' . $d->format('Y');
}

/**
 * Tronquer un texte
 */
function excerpt(string $text, int $length = 200): string {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '…';
}

/**
 * Uploader une image avec redimensionnement
 */
function uploadImage(array $file, string $subdir = ''): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > MAX_UPLOAD_SIZE) return null;
    
    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, ALLOWED_IMAGE_TYPES)) return null;

    $ext = match($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/svg+xml' => 'svg',
        default => 'jpg'
    };

    $filename = uniqid('img_', true) . '.' . $ext;
    $uploadDir = UPLOADS_PATH . ($subdir ? $subdir . '/' : '');
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $dest = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        // Redimensionner si c'est pas un SVG
        if ($ext !== 'svg') {
            resizeImage($dest, 1920, 1080);
        }
        return ($subdir ? $subdir . '/' : '') . $filename;
    }
    return null;
}

/**
 * Redimensionner une image (garder les proportions)
 */
function resizeImage(string $path, int $maxW, int $maxH): void {
    $info = getimagesize($path);
    if (!$info) return;

    [$origW, $origH] = $info;
    if ($origW <= $maxW && $origH <= $maxH) return;

    $ratio = min($maxW / $origW, $maxH / $origH);
    $newW = (int)($origW * $ratio);
    $newH = (int)($origH * $ratio);

    $src = match($info['mime']) {
        'image/jpeg' => imagecreatefromjpeg($path),
        'image/png'  => imagecreatefrompng($path),
        'image/webp' => imagecreatefromwebp($path),
        default => null
    };
    if (!$src) return;

    $dst = imagecreatetruecolor($newW, $newH);
    
    // Préserver la transparence pour PNG/WebP
    if ($info['mime'] !== 'image/jpeg') {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

    match($info['mime']) {
        'image/jpeg' => imagejpeg($dst, $path, 85),
        'image/png'  => imagepng($dst, $path, 8),
        'image/webp' => imagewebp($dst, $path, 85),
        default => null
    };

    imagedestroy($src);
    imagedestroy($dst);
}

/**
 * Obtenir un paramètre du site depuis la table settings
 */
function getSetting(string $key, string $default = ''): string {
    try {
        $row = Database::fetch("SELECT setting_value FROM settings WHERE setting_key = ?", [$key]);
        return $row ? $row['setting_value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Définir un paramètre
 */
function setSetting(string $key, string $value): void {
    $existing = Database::fetch("SELECT setting_key FROM settings WHERE setting_key = ?", [$key]);
    if ($existing) {
        Database::update('settings', ['setting_value' => $value], 'setting_key = ?', [$key]);
    } else {
        Database::insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
    }
}

/**
 * URL assets avec cache busting
 */
function asset(string $path): string {
    $file = ASSETS_PATH . $path;
    $version = file_exists($file) ? filemtime($file) : SITE_VERSION;
    return ASSETS_URL . '/' . $path . '?v=' . $version;
}

/**
 * URL uploads
 */
function upload(string $path): string {
    return UPLOADS_URL . '/' . $path;
}

/**
 * Page active pour la navigation
 */
function isActivePage(string $page): string {
    $current = basename($_SERVER['PHP_SELF'], '.php');
    return ($current === $page) ? 'active' : '';
}

/**
 * Pagination
 */
function paginate(int $total, int $perPage, int $current): array {
    $pages = max(1, (int) ceil($total / $perPage));
    $current = max(1, min($current, $pages));
    return [
        'total' => $total,
        'per_page' => $perPage,
        'current' => $current,
        'pages' => $pages,
        'offset' => ($current - 1) * $perPage,
        'has_prev' => $current > 1,
        'has_next' => $current < $pages,
    ];
}
