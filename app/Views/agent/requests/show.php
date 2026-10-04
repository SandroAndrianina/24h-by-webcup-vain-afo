<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la demande</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main class="agent-page-shell">

        <div class="agent-page-header">
            <div>
                <span class="agent-badge">Suivi de demande</span>
                <h1>Détail de la demande</h1>
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

        <div class="agent-stack">
            <section class="agent-card">
                <div class="agent-meta">
                    <span class="status-pill status-pill--<?= match ($request->status()->value()) {
                        'nouveau' => 'new',
                        'en_cours' => 'progress',
                        'resolu' => 'done',
                        default => 'done',
                    } ?>"><?= esc($request->status()->label()) ?></span>
                    <span><?= esc($request->createdAt() ?? '') ?></span>
                </div>
                <h2><?= esc($request->type()->label()) ?></h2>
                <p><strong>Description</strong></p>
                <p><?= nl2br(esc($request->description())) ?></p>
                <p><strong>Lieu :</strong> <?= esc($request->location() ?? 'Non précisé') ?></p>
            </section>

            <section class="agent-card">
                <h2>Modifier le statut</h2>

                <form class="agent-form"
            method="post"
            action="<?= site_url('agent/requests/' . $request->id() . '/status') ?>"
        >

            <?= csrf_field() ?>

                    <div class="field">
                        <label for="status">Nouveau statut</label>
                        <select name="status" id="status">

                <option value="nouveau">
                    Nouveau
                </option>

                <option value="en_cours">
                    En cours
                </option>

                <option value="resolu">
                    Résolu
                </option>

                        </select>
                    </div>
                    <div class="agent-actions">
                        <button type="submit">Modifier le statut</button>
                        <a class="agent-link" href="<?= site_url('agent/requests') ?>">Retour aux demandes</a>
                    </div>
                </form>
            </section>
        </div>

    </main>

</body>
</html>