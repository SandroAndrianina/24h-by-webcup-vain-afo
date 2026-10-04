<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contacter la mairie</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
</head>
<body>
    <nav>
        <a href="<?= base_url('citoyen/requests') ?>">Mes demandes</a>
        <a href="<?= base_url('citoyen/contact') ?>">Contact</a>
        <a href="<?= base_url('logout') ?>">Déconnexion</a>
    </nav>

    <main>
        <h1>Contacter la mairie</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert error">
                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <p><?= esc($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('citoyen/contact') ?>">
            <?= csrf_field() ?>

            <label>Sujet *</label>
            <input type="text" name="subject" required maxlength="200" value="<?= old('subject') ?>">

            <label>Message *</label>
            <textarea name="message" required minlength="10" rows="6"><?= old('message') ?></textarea>

            <button type="submit" class="btn">Envoyer</button>
        </form>
    </main>
</body>
</html>