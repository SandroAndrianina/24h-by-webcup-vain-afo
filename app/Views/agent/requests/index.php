<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Demandes</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main>

        <h1>Demandes des citoyens</h1>

        <?php if (session()->getFlashdata('error')): ?>

            <p>
                <?= esc(session()->getFlashdata('error')) ?>
            </p>

        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>

            <p>
                <?= esc(session()->getFlashdata('success')) ?>
            </p>

        <?php endif; ?>

        <hr>

        <?php if (empty($requests)): ?>

            <p>
                Aucune demande pour votre service.
            </p>

        <?php else: ?>

            <?php foreach ($requests as $request): ?>

                <div>

                    <p>
                        <strong>Type :</strong>
                        <?= esc($request->type()->label()) ?>
                    </p>

                    <p>
                        <strong>Description :</strong>
                        <?= esc($request->description()) ?>
                    </p>

                    <p>
                        <strong>Lieu :</strong>
                        <?= esc($request->location() ?? 'Non précisé') ?>
                    </p>

                    <p>
                        <strong>Statut :</strong>
                        <?= esc($request->status()->label()) ?>
                    </p>

                    <p>
                        <strong>Date :</strong>
                        <?= esc($request->createdAt() ?? '') ?>
                    </p>

                    <a href="<?= site_url('agent/requests/' . $request->id()) ?>">
                        Voir la demande
                    </a>

                </div>

                <hr>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>
</html>