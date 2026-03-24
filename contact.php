<?php
/**
 * Grand Mall de Conakry — Contact
 */
require_once __DIR__ . '/includes/functions.php';
bootstrap();

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = input('name');
    $email = input('email');
    $phone = input('phone');
    $subject = input('subject');
    $message = input('message');

    if (!$name || !$email || !$message) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } else {
        $to = getSetting('site_email', 'contact@grandmall.gn');
        $headers = "From: $name <$email>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
        $body = "Nom: $name\nEmail: $email\nTéléphone: $phone\nSujet: $subject\n\nMessage:\n$message";
        
        @mail($to, "Contact Grand Mall: $subject", $body, $headers);
        $success = true;
    }
}

$pageTitle = 'Contact';
$pageDescription = 'Contactez le Grand Mall de Conakry — investisseurs, enseignes, partenaires.';
require_once INCLUDES_PATH . 'header.php';
?>

    <section class="page-hero page-hero-sm">
        <div class="container">
            <span class="section-label" data-aos="fade-up">Contact</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Contactez-<span class="gold">nous</span></h1>
            <p data-aos="fade-up" data-aos-delay="200">Investisseurs, enseignes, partenaires — nous serions ravis d'échanger avec vous</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="contact-layout">
                <!-- Formulaire -->
                <div class="contact-form-wrap" data-aos="fade-right">
                    <?php if ($success): ?>
                        <div class="contact-success">
                            <div class="empty-icon">✅</div>
                            <h3>Message envoyé !</h3>
                            <p>Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</p>
                            <a href="<?= SITE_URL ?>/" class="btn btn-gold" style="margin-top:1rem;">← Retour à l'accueil</a>
                        </div>
                    <?php else: ?>
                        <?php if ($error): ?><div class="form-error"><?= e($error) ?></div><?php endif; ?>
                        <form method="POST" class="contact-form">
                            <div class="form-row">
                                <div class="form-group" style="flex:1"><label for="name">Nom complet *</label><input type="text" id="name" name="name" class="form-control" required value="<?= e(input('name', '')) ?>"></div>
                                <div class="form-group" style="flex:1"><label for="email">Email *</label><input type="email" id="email" name="email" class="form-control" required value="<?= e(input('email', '')) ?>"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group" style="flex:1"><label for="phone">Téléphone</label><input type="tel" id="phone" name="phone" class="form-control" value="<?= e(input('phone', '')) ?>"></div>
                                <div class="form-group" style="flex:1"><label for="subject">Sujet</label>
                                    <select id="subject" name="subject" class="form-control">
                                        <option value="general">Information générale</option>
                                        <option value="investissement">Investissement</option>
                                        <option value="location">Location d'espace</option>
                                        <option value="partenariat">Partenariat</option>
                                        <option value="presse">Presse & Médias</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label for="message">Message *</label><textarea id="message" name="message" class="form-control" rows="6" required><?= e(input('message', '')) ?></textarea></div>
                            <button type="submit" class="btn btn-gold btn-lg">📤 Envoyer le message</button>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- Info contact -->
                <div class="contact-info" data-aos="fade-left">
                    <div class="contact-card">
                        <div class="contact-card-icon">📍</div>
                        <h3>Adresse</h3>
                        <p><?= e(getSetting('site_address', 'Plateau de Koloma, Conakry, Guinée')) ?></p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon">📞</div>
                        <h3>Téléphone</h3>
                        <p><a href="tel:<?= e(getSetting('site_phone')) ?>"><?= e(getSetting('site_phone', '+224 000 000 000')) ?></a></p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon">✉️</div>
                        <h3>Email</h3>
                        <p><a href="mailto:<?= e(getSetting('site_email')) ?>"><?= e(getSetting('site_email', 'contact@grandmall.gn')) ?></a></p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon">🕐</div>
                        <h3>Horaires</h3>
                        <p>Lun — Sam: 9h00 — 18h00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once INCLUDES_PATH . 'footer.php'; ?>
