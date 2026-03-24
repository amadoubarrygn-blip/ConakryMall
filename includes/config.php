<?php
/**
 * Grand Mall de Conakry — Configuration
 * 
 * Ce fichier centralise TOUTE la configuration.
 * Changer de domaine = modifier SITE_URL ici.
 */

// === MODE DEBUG (désactiver en production) ===
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// === BASE DE DONNÉES ===
define('DB_HOST', 'localhost');
define('DB_NAME', 'conakrymall_grandmall');
define('DB_USER', 'conakrymall_admin');
define('DB_PASS', 'GMall_2026$ecure!');
define('DB_CHARSET', 'utf8mb4');

// === CHEMINS ===
define('ROOT_PATH', dirname(__DIR__) . '/');
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('ADMIN_PATH', ROOT_PATH . 'admin/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('UPLOADS_PATH', ASSETS_PATH . 'uploads/');

// === URL DU SITE (une seule ligne à changer pour le domaine) ===
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('SITE_URL', $protocol . '://' . $host);
define('ASSETS_URL', SITE_URL . '/assets');
define('UPLOADS_URL', ASSETS_URL . '/uploads');

// === INFO SITE ===
define('SITE_NAME', 'Grand Mall de Conakry');
define('SITE_TAGLINE', 'L\'expérience shopping réinventée');
define('SITE_DESCRIPTION', 'Le plus grand centre commercial de Guinée — 83 000 m² de shopping, divertissement et bien-être au cœur de Conakry.');
define('SITE_LANG', 'fr');
define('SITE_VERSION', '1.0.0');

// === SÉCURITÉ ===
define('ADMIN_SESSION_NAME', 'gm_admin_session');
define('CSRF_TOKEN_NAME', 'gm_csrf_token');
define('PASSWORD_COST', 12); // bcrypt cost

// === UPLOAD ===
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10 Mo
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
define('ALLOWED_VIDEO_TYPES', ['video/mp4', 'video/webm']);
define('THUMBNAIL_WIDTH', 400);
define('THUMBNAIL_HEIGHT', 300);

// === TIMEZONE ===
date_default_timezone_set('Africa/Conakry');

// === DÉMARRER LA SESSION ===
if (session_status() === PHP_SESSION_NONE) {
    session_name(ADMIN_SESSION_NAME);
    session_start();
}
