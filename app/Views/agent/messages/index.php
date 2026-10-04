<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Messages citoyens</title>
</head>

<body>

    <?= $this->include('agent/navbar') ?>

    <main>

        <h1>Messages des citoyens</h1>

        <?php if (session()->getFlashdata('error')): ?>

            <p>
                <?= esc(session()->getFlashdata('error')) ?>
            </p>

        <?php endif; ?>

        <hr>

        <?php if (empty($messages)): ?>

            <p>
                Aucun message.
            </p>

        <?php else: ?>

            <?php foreach ($messages as $message): ?>

                <div>

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

                    <a href="<?= site_url('agent/messages/' . $message['id']) ?>">
                        Voir le message
                    </a>

                </div>

                <hr>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>
</html>