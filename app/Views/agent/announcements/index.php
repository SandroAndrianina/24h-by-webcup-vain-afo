<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Annonces</title>
</head>

<body>
    <?= $this->include('agent/navbar') ?>

    <h1>Mes annonces</h1>

    <?php if (session()->getFlashdata('success')): ?>

        <p>
            <?= esc(session()->getFlashdata('success')) ?>
        </p>

    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>

        <p>
            <?= esc(session()->getFlashdata('error')) ?>
        </p>

    <?php endif; ?>

    <p>
        <a href="<?= site_url('agent/announcements/new') ?>">
            + Créer une annonce
        </a>
    </p>

    <hr>

    <?php if (empty($announcements)): ?>

        <p>
            Vous n'avez encore publié aucune annonce.
        </p>

    <?php else: ?>

        <?php foreach ($announcements as $announcement): ?>

            <article>

                <h2>
                    <?= esc($announcement['title']) ?>
                </h2>

                <?php if ((int) $announcement['is_alert'] === 1): ?>

                    <strong>
                        ⚠ ALERTE URGENTE
                    </strong>

                    <?php if (!empty($announcement['alert_category'])): ?>

                        <p>
                            Catégorie :
                            <?= esc($announcement['alert_category']) ?>
                        </p>

                    <?php endif; ?>

                <?php endif; ?>

                <p>
                    <?= nl2br(esc($announcement['content'])) ?>
                </p>

                <small>
                    Publiée le :
                    <?= esc($announcement['published_at']) ?>
                </small>

            </article>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="<?= site_url('agent') ?>">
        Retour au dashboard
    </a>

</body>
</html>