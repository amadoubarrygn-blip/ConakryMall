<?php
/**
 * Grand Mall de Conakry — Authentification Admin
 */

class Auth {
    /**
     * Vérifier si l'utilisateur est connecté
     */
    public static function isLoggedIn(): bool {
        return isset($_SESSION['admin_id']) && isset($_SESSION['admin_role']);
    }

    /**
     * Exiger une connexion (rediriger sinon)
     */
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ' . SITE_URL . '/admin/login.php');
            exit;
        }
    }

    /**
     * Connexion
     */
    public static function login(string $username, string $password): bool {
        $user = Database::fetch(
            "SELECT * FROM users WHERE username = ? LIMIT 1",
            [$username]
        );

        if ($user && password_verify($password, $user['password_hash'])) {
            // Régénérer l'ID de session (prévention fixation de session)
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['admin_login_time'] = time();

            return true;
        }
        return false;
    }

    /**
     * Déconnexion
     */
    public static function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }

    /**
     * Obtenir l'utilisateur courant
     */
    public static function currentUser(): ?array {
        if (!self::isLoggedIn()) return null;
        return [
            'id' => $_SESSION['admin_id'],
            'username' => $_SESSION['admin_username'],
            'role' => $_SESSION['admin_role'],
        ];
    }

    /**
     * Vérifier le rôle admin
     */
    public static function isAdmin(): bool {
        return self::isLoggedIn() && $_SESSION['admin_role'] === 'admin';
    }

    /**
     * Générer un token CSRF
     */
    public static function generateCSRF(): string {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    /**
     * Vérifier un token CSRF
     */
    public static function verifyCSRF(string $token): bool {
        return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }

    /**
     * Champ HTML caché pour CSRF
     */
    public static function csrfField(): string {
        return '<input type="hidden" name="csrf_token" value="' . self::generateCSRF() . '">';
    }

    /**
     * Hasher un mot de passe
     */
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
    }
}
