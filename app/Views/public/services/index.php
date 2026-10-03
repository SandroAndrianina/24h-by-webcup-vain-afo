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

<main class="wrap">
    <h1>Services de la ville</h1>
    <p class="lead">Retrouvez les principaux services municipaux de Terra Nova et les informations utiles pour chacun.</p>

    <?php if (empty($services)): ?>
        <p class="empty">Aucun service disponible pour le moment.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($services as $s): ?>
                <a class="card" href="<?= site_url('services/' . (int) $s['id']) ?>">
                    <span class="icon"><?= $icons[$s['icon'] ?? ''] ?? '🛰️' ?></span>
                    <h2><?= esc($s['name']) ?></h2>
                    <p><?= esc($s['short_description']) ?></p>
                    <span class="more">Voir le service →</span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
