<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> · TERRA NOVA</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/services.css') ?>">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>">TERRA NOVA</a>
    <nav>
        <span class="user"><?= esc((string) session()->get('name')) ?></span>
        <a href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
</header>

<main class="wrap narrow">
    <a class="back" href="<?= site_url('services') ?>">← Tous les services</a>

    <article class="detail">
        <span class="icon big"><?= $icons[$service['icon'] ?? ''] ?? '🛰️' ?></span>
        <h1><?= esc($service['name']) ?></h1>
        <p class="lead"><?= esc($service['short_description']) ?></p>

        <?php if (! empty($service['details'])): ?>
            <div class="details"><?= nl2br(esc($service['details'])) ?></div>
        <?php endif; ?>
    </article>
</main>
</body>
</html>
