<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages citoyens</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">

        <div class="agent-page-header">
            <div>
                <span class="agent-badge">Espace de communication</span>
                <h1>Messages des citoyens</h1>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>

            <p class="agent-alert">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>

        <?php endif; ?>

        <?php if (empty($messages)): ?>
            <div class="agent-empty">
                Aucun message.
            </div>

        <?php else: ?>

            <div class="agent-list">
                <?php foreach ($messages as $message): ?>
                    <article class="agent-card">
                        <div class="agent-meta">
                            <span class="status-pill"><?= esc($message['status']) ?></span>
                            <span><?= esc($message['created_at']) ?></span>
                        </div>
                        <h2>Message citoyen</h2>
                        <p><?= nl2br(esc($message['message'])) ?></p>
                        <div class="agent-actions">
                            <a class="agent-link" href="<?= site_url('agent/messages/' . $message['id']) ?>">
                                Voir le message
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </main>

</body>
</html>