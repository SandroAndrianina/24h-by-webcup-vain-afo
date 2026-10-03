<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Espace citoyen') ?> · TERRA NOVA</title>
    <style>
        :root { --bg:#0f172a; --card:#1e293b; --text:#f1f5f9; --muted:#cbd5e1; --accent:#38bdf8; --line:#334155; --ok:#22c55e; --err:#f87171; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, sans-serif; font-size:1rem; line-height:1.5; background:var(--bg); color:var(--text); }
        a { color: var(--accent); }
        :focus-visible { outline: 3px solid #facc15; outline-offset: 2px; }
        .skip { position:absolute; left:-999px; } .skip:focus { left:1rem; top:1rem; background:#fff; color:#000; padding:.5rem; z-index:9; }
        header.topbar { display:flex; flex-wrap:wrap; gap:1rem; justify-content:space-between; align-items:center; padding:1rem 1.5rem; background:var(--card); border-bottom:1px solid var(--line); }
        .brand { font-weight:700; letter-spacing:.1em; text-decoration:none; color:var(--text); }
        nav ul { list-style:none; display:flex; flex-wrap:wrap; gap:1rem; margin:0; padding:0; }
        main { max-width:56rem; margin:0 auto; padding:1.5rem; }
        .crumbs { font-size:.9rem; color:var(--muted); margin-bottom:1rem; }
        .crumbs a { color: var(--muted); }
        h1 { margin-top:0; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:.75rem; padding:1rem 1.25rem; margin-bottom:1rem; }
        .grid { display:grid; gap:1rem; grid-template-columns: repeat(auto-fit, minmax(14rem, 1fr)); }
        .tile { display:block; text-decoration:none; color:var(--text); }
        .tile:hover { border-color: var(--accent); }
        label { display:block; font-weight:600; margin:1rem 0 .25rem; }
        input, select, textarea { width:100%; padding:.6rem; font-size:1rem; border-radius:.5rem; border:1px solid var(--muted); background:#0b1220; color:var(--text); }
        .btn { display:inline-block; margin-top:1rem; padding:.7rem 1.2rem; border:0; border-radius:.5rem; background:var(--accent); color:#06223a; font-weight:700; font-size:1rem; text-decoration:none; cursor:pointer; }
        .alert { padding:.8rem 1rem; border-radius:.5rem; margin-bottom:1rem; border:1px solid; }
        .alert.ok { border-color:var(--ok); } .alert.err { border-color:var(--err); }
        .badge { display:inline-block; padding:.1rem .6rem; border-radius:1rem; border:1px solid var(--accent); font-size:.85rem; }
        table { width:100%; border-collapse:collapse; } th, td { text-align:left; padding:.6rem; border-bottom:1px solid var(--line); }
        .steps { list-style:none; padding:0; } .steps li { padding:.4rem 0; } .steps .done::before { content:"✔ "; color:var(--ok); } .steps .todo::before { content:"○ "; color:var(--muted); }
        .muted { color: var(--muted); }
    </style>
</head>
<body>
<a class="skip" href="#contenu">Aller au contenu</a>

<header class="topbar">
    <a class="brand" href="<?= site_url('citoyen') ?>">TERRA NOVA</a>
    <nav aria-label="Navigation principale">
        <ul>
            <li><a href="<?= site_url('citoyen/requests') ?>">Mes demandes</a></li>
            <li><a href="<?= site_url('citoyen/requests/new') ?>">Nouvelle demande</a></li>
            <li><a href="<?= site_url('citoyen/contact') ?>">Contact</a></li>
            <li><a href="<?= site_url('citoyen/profile') ?>">Mon profil</a></li>
            <li><a href="<?= site_url('logout') ?>">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main id="contenu">
    <?php if (! empty($crumbs)): ?>
        <nav class="crumbs" aria-label="Fil d'Ariane">
            <?php foreach ($crumbs as $i => [$label, $url]): ?>
                <?= $i > 0 ? ' › ' : '' ?>
                <?php if ($url): ?><a href="<?= site_url(ltrim($url, '/')) ?>"><?= esc($label) ?></a><?php else: ?><span aria-current="page"><?= esc($label) ?></span><?php endif; ?>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <div aria-live="polite">
        <?php if ($msg = session()->getFlashdata('success')): ?>
            <div class="alert ok" role="status"><?= esc($msg) ?></div>
        <?php endif; ?>
        <?php if ($errs = session()->getFlashdata('errors')): ?>
            <div class="alert err" role="alert">
                <ul style="margin:0;padding-left:1.2rem"><?php foreach ((array) $errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->renderSection('content') ?>
</main>
</body>
</html>
