<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes</title>
</head>
<body>

    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">
        <div class="agent-page-header">
            <div>
                <span class="agent-badge">Centre de gestion</span>
                <h1>Demandes des citoyens</h1>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="agent-alert">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <p class="agent-info">
                <?= esc(session()->getFlashdata('success')) ?>
            </p>
        <?php endif; ?>

        <?php if (empty($requests)): ?>
            <div class="agent-empty">
                Aucune demande pour votre service.
            </div>
        <?php else: ?>
            <div class="agent-list">
                <?php foreach ($requests as $request): ?>
                    <article class="agent-card">
                        <div class="agent-meta">
                            <span class="status-pill status-pill--<?= match ($request->status()->value()) {
                                'nouveau' => 'new',
                                'en_cours' => 'progress',
                                'resolu' => 'done',
                                default => 'done',
                            } ?>">
                                <?= esc($request->status()->label()) ?>
                            </span>
                            <span><?= esc($request->type()->label()) ?></span>
                            <span>•</span>
                            <span><?= esc($request->createdAt() ?? '') ?></span>
                        </div>

                        <h2><?= esc($request->type()->label()) ?></h2>

                        <p><?= nl2br(esc($request->description())) ?></p>

                        <p><strong>Lieu :</strong> <?= esc($request->location() ?? 'Non précisé') ?></p>

                        <div class="agent-actions">
                            <a class="agent-link" href="<?= site_url('agent/requests/' . $request->id()) ?>">
                                Voir la demande
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>
