<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription agent — TERRA NOVA</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body>
    <main class="auth-page">
        <header class="auth-topbar">
            <a class="auth-logo" href="<?= site_url('menu') ?>" aria-label="Retour à TERRA NOVA">
                <img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA">
            </a>
            <a class="auth-back" href="<?= site_url('login') ?>">Déjà inscrit ? <span>Connexion</span></a>
        </header>

        <div class="auth-layout">
            <section class="auth-intro">
                <span class="auth-eyebrow"><i></i> ESPACE PROFESSIONNEL</span>
                <h1>Rejoignez<br><span>nos équipes.</span></h1>
                <p>Présentez votre profil et votre spécialité pour rejoindre le réseau de prestataires TERRA NOVA.</p>
                <div class="auth-index"><span>01</span><b>INSCRIPTION AGENT</b></div>
            </section>

            <section class="auth-card" aria-labelledby="agent-title">
                <div class="auth-card__head">
                    <div>
                        <span class="auth-eyebrow">NOUVEAU COMPTE</span>
                        <h2 id="agent-title">Inscription agent</h2>
                    </div>
                    <span class="auth-step">01 <i>/ 01</i></span>
                </div>

                <?php if (empty($services)): ?>
                    <p class="auth-notice" role="status">Les services ne sont pas disponibles pour le moment. Vous pouvez compléter le formulaire, mais le choix du service sera nécessaire pour valider l’inscription.</p>
                <?php endif; ?>

                <form class="auth-form" action="<?= site_url('register-agent') ?>" method="post">
                    <?= csrf_field() ?>
                    <label class="auth-field">
                        <span>Nom complet</span>
                        <input type="text" name="name" autocomplete="name" placeholder="Ex. Marie Rakoto" required minlength="2">
                    </label>
                    <label class="auth-field">
                        <span>Adresse e-mail</span>
                        <input type="email" name="email" autocomplete="email" placeholder="nom@exemple.com" required>
                    </label>
                    <label class="auth-field">
                        <span>Mot de passe</span>
                        <input type="password" name="password" autocomplete="new-password" placeholder="8 caractères minimum" required minlength="8">
                    </label>
                    <label class="auth-field">
                        <span>Service principal</span>
                        <select name="service_id" required>
                            <option value=""><?= empty($services) ? 'Aucun service disponible' : 'Sélectionnez votre service' ?></option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= esc($service['id']) ?>"><?= esc($service['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <div class="auth-submit">
                        <p>Vos informations seront utilisées pour créer votre accès agent.</p>
                        <button type="submit" <?= empty($services) ? 'disabled' : '' ?>>Créer mon compte <span aria-hidden="true">→</span></button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
