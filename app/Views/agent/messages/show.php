<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message citoyen</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">

        <div class="agent-page-header">
            <div>
                <span class="agent-badge">Espace de communication</span>
                <h1>Message citoyen</h1>
            </div>
        </div>

        <section class="agent-card">
            <div class="agent-meta">
                <span class="status-pill"><?= esc($message['status']) ?></span>
                <span><?= esc($message['created_at']) ?></span>
            </div>
            <h2>Contenu du message</h2>
            <p><?= nl2br(esc($message['message'])) ?></p>

        <?php if (!empty($message['assigned_agent_id'])): ?>

            <p><strong>Agent assigné :</strong> <?= esc($message['assigned_agent_id']) ?></p>

        <?php endif; ?>

            <div class="agent-actions">
                <a class="agent-link" href="<?= site_url('agent/messages') ?>">Retour aux messages</a>
            </div>
        </section>

    </main>

</body>
</html>