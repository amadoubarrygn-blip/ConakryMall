<?php
/**
 * Grand Mall de Conakry — Admin Login
 */
require_once __DIR__ . '/../includes/functions.php';
bootstrap();

// Déjà connecté ?
if (Auth::isLoggedIn()) {
    redirect(SITE_URL . '/admin/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = input('username');
    $password = input('password');

    if (Auth::login($username, $password)) {
        // Mettre à jour last_login
        Database::update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$_SESSION['admin_id']]);
        redirect(SITE_URL . '/admin/');
    } else {
        $error = 'Identifiants incorrects.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion — <?= e(SITE_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0A1628;
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #C9A351, #E8D48B);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 0 30px rgba(201,163,81,0.2);
        }
        .logo h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #C9A351;
        }
        .logo p {
            font-size: 0.85rem;
            color: #94948F;
            margin-top: 0.3rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none;
        }
        input:focus {
            border-color: #C9A351;
            box-shadow: 0 0 0 3px rgba(201,163,81,0.15);
        }
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #C9A351, #E8D48B);
            border: none;
            border-radius: 10px;
            color: #0A1628;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(201,163,81,0.3);
        }
        .error {
            background: rgba(206,17,38,0.15);
            border: 1px solid #CE1126;
            color: #f87171;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #94948F;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .back-link:hover { color: #C9A351; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <div class="logo-icon">🏬</div>
            <h1><?= e(SITE_NAME) ?></h1>
            <p>Panel d'administration</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required autocomplete="username" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <a href="<?= SITE_URL ?>/" class="back-link">← Retour au site</a>
    </div>
</body>
</html>
