<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mes demandes — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
</head>
<body>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('menu') ?>">Accueil</a>
      <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= site_url('menu') ?>">Accueil</a>
    <span class="breadcrumb__sep">›</span>
    <span aria-current="page">Mes demandes</span>
  </nav>

  <header class="head head--row">
    <h1>MES DEMANDES</h1>
    <a href="<?= site_url('citoyen/requests/new') ?>" class="btn-cta">+ Nouvelle demande</a>
  </header>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash flash--success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <?php if (empty($requests)): ?>
    <div class="empty">
      <p>Vous n'avez encore envoyé aucune demande.</p>
      <a href="<?= site_url('citoyen/requests/new') ?>" class="btn-cta">Créer ma première demande →</a>
    </div>
  <?php else: ?>
    <ul class="req-list">
      <?php foreach ($requests as $r): ?>
        <li class="req-item">
          <a href="<?= site_url('citoyen/requests/' . $r->id()) ?>">
            <header class="req-item__head">
              <span class="req-badge" style="--bg: <?= esc($r->status()->color()) ?>">
                <?= esc($r->status()->label()) ?>
              </span>
              <time class="req-item__date">
                <?= esc(date('d M Y', strtotime($r->createdAt()))) ?>
              </time>
            </header>
            <h3 class="req-item__title"><?= esc($r->type()->label()) ?></h3>
            <p class="req-item__desc"><?= esc(mb_substr($r->description(), 0, 140)) ?>…</p>
            <?php if ($r->location()): ?>
              <span class="req-item__loc">📍 <?= esc($r->location()) ?></span>
            <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>