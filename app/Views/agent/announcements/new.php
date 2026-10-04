<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nouvelle annonce</title>
</head>

<body>

    <h1>Créer une annonce</h1>

    <p>
        Agent : <?= esc($agent['name']) ?>
    </p>

    <?php if (session()->getFlashdata('error')): ?>

        <p>
            <?= esc(session()->getFlashdata('error')) ?>
        </p>

    <?php endif; ?>

    <form
        method="post"
        action="<?= site_url('agent/announcements/create') ?>"
    >

        <?= csrf_field() ?>

        <div>

            <label for="title">
                Titre
            </label>

            <br>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= old('title') ?>"
                maxlength="200"
                required
            >

        </div>

        <br>

        <div>

            <label for="content">
                Contenu
            </label>

            <br>

            <textarea
                id="content"
                name="content"
                rows="8"
                required
            ><?= old('content') ?></textarea>

        </div>

        <br>

        <div>

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

        <br>

        <div>

            <label for="alert_category">
                Catégorie de l'alerte
            </label>

            <br>

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

        <br>

        <button type="submit">
            Publier l'annonce
        </button>

    </form>

    <br>

    <a href="<?= site_url('agent/announcements') ?>">
        Retour aux annonces
    </a>

    <br>

    <a href="<?= site_url('agent') ?>">
        Retour au dashboard
    </a>

</body>
</html>