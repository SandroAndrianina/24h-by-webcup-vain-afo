<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Détail de la demande</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main>

        <h1>Détail de la demande</h1>

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

        <p>
            <strong>Type :</strong>
            <?= esc($request->type()->label()) ?>
        </p>

        <p>
            <strong>Description :</strong>
        </p>

        <p>
            <?= nl2br(esc($request->description())) ?>
        </p>

        <p>
            <strong>Lieu :</strong>
            <?= esc($request->location() ?? 'Non précisé') ?>
        </p>

        <p>
            <strong>Statut actuel :</strong>
            <?= esc($request->status()->label()) ?>
        </p>

        <p>
            <strong>Date :</strong>
            <?= esc($request->createdAt() ?? '') ?>
        </p>

        <hr>

        <h2>Modifier le statut</h2>

        <form
            method="post"
            action="<?= site_url('agent/requests/' . $request->id() . '/status') ?>"
        >

            <?= csrf_field() ?>

            <label for="status">
                Nouveau statut :
            </label>

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

            <button type="submit">
                Modifier le statut
            </button>

        </form>

        <hr>

        <a href="<?= site_url('agent/requests') ?>">
            Retour aux demandes
        </a>

    </main>

</body>
</html>