<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Message citoyen</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main>

        <h1>Message citoyen</h1>

        <p>
            <strong>Message :</strong>
        </p>

        <p>
            <?= nl2br(esc($message['message'])) ?>
        </p>

        <p>
            <strong>Statut :</strong>
            <?= esc($message['status']) ?>
        </p>

        <p>
            <strong>Date :</strong>
            <?= esc($message['created_at']) ?>
        </p>

        <?php if (!empty($message['assigned_agent_id'])): ?>

            <p>
                <strong>Agent assigné :</strong>
                <?= esc($message['assigned_agent_id']) ?>
            </p>

        <?php endif; ?>

        <hr>

        <a href="<?= site_url('agent/messages') ?>">
            Retour aux messages
        </a>

    </main>

</body>
</html>