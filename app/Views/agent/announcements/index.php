<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Annonces</title>
</head>

<body>
    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">
    <div class="agent-page-header">
        <div>
            <span class="agent-badge">Informations publiques</span>
            <h1>Mes annonces</h1>
        </div>
        <a class="agent-btn" href="<?= site_url('agent/announcements/new') ?>">Créer une annonce</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>

        <p class="agent-info">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>

    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>

        <p class="agent-alert">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>

    <?php endif; ?>

    <?php if (empty($announcements)): ?>
        <div class="agent-empty">
            Vous n'avez encore publié aucune annonce.
        </div>

    <?php else: ?>

        <div class="agent-list">
        <?php foreach ($announcements as $announcement): ?>

            <article class="agent-card<?= (int) $announcement['is_alert'] === 1 ? ' agent-card--alert' : '' ?>">

                <h2>
                    <?= esc($announcement['title']) ?>
                </h2>

                <?php if ((int) $announcement['is_alert'] === 1): ?>

                    <strong class="agent-badge">
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

        <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <div class="agent-actions">
        <a class="agent-link" href="<?= site_url('agent') ?>">Retour au dashboard</a>
    </div>
    </main>

</body>
</html>