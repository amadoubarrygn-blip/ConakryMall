<?php
/**
 * Grand Mall de Conakry — Admin Logout
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();
Auth::logout();
redirect(SITE_URL . '/admin/login.php');
