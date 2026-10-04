<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nouvelle annonce</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">
        <div class="agent-page-header">
            <div>
                <span class="agent-badge">Informations publiques</span>
                <h1>Créer une annonce</h1>
                <p>Agent : <?= esc($agent['name']) ?></p>
            </div>
        </div>

        <section class="agent-card">

    <?php if (session()->getFlashdata('error')): ?>

        <p class="agent-alert">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>

    <?php endif; ?>

    <form class="agent-form"
        method="post"
        action="<?= site_url('agent/announcements/create') ?>"
    >

        <?= csrf_field() ?>

        <div class="field">
            <label for="title">
                Titre
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= old('title') ?>"
                maxlength="200"
                required
            >

        </div>

        <div class="field">
            <label for="content">
                Contenu
            </label>

            <textarea
                id="content"
                name="content"
                rows="8"
                required
            ><?= old('content') ?></textarea>

        </div>

        <div class="field">

            <label>

                <input
                    type="checkbox"
                    name="is_alert"
                    value="1"
                    <?= old('is_alert') ? 'checked' : '' ?>
                >

                Publier comme alerte urgente

            </label>

        </div>

        <div class="field">
            <label for="alert_category">
                Catégorie de l'alerte
            </label>

            <select
                id="alert_category"
                name="alert_category"
            >

                <option value="">
                    Aucune
                </option>

                <option value="Sécurité">
                    Sécurité
                </option>

                <option value="Santé">
                    Santé
                </option>

                <option value="Météo">
                    Météo
                </option>

                <option value="Infrastructure">
                    Infrastructure
                </option>

                <option value="Urgence">
                    Urgence
                </option>

            </select>

        </div>

        <div class="agent-actions">
            <button type="submit">Publier l'annonce</button>
            <a class="agent-link" href="<?= site_url('agent/announcements') ?>">Retour aux annonces</a>
        </div>

    </form>

        </section>
        <div class="agent-actions">
            <a class="agent-link" href="<?= site_url('agent') ?>">Retour au dashboard</a>
        </div>
    </main>

</body>
</html>