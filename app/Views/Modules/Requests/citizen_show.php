<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($request->type()->label()) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
</head>
<body>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
      <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= site_url('menu') ?>">Accueil</a>
    <span class="breadcrumb__sep">›</span>
    <a href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
    <span class="breadcrumb__sep">›</span>
    <span aria-current="page">Demande #<?= esc($request->id()) ?></span>
  </nav>

  <article class="service-detail">
    <header class="req-show__head">
      <span class="req-badge req-badge--lg" style="--bg: <?= esc($request->status()->color()) ?>">
        <?= esc($request->status()->label()) ?>
      </span>
      <span class="req-show__id">Demande #<?= esc($request->id()) ?></span>
    </header>

    <h1><?= esc($request->type()->label()) ?></h1>

    <?php if ($request->location()): ?>
      <p class="req-show__loc">📍 <?= esc($request->location()) ?></p>
    <?php endif; ?>

    <p class="req-show__desc"><?= nl2br(esc($request->description())) ?></p>

    <!-- ÉTAPES DE SUIVI -->
    <section class="track">
      <h2>Suivi de la demande</h2>
      <?php
        $steps = [
          'nouveau'  => ['label' => 'Reçue',      'desc' => 'Votre demande a été enregistrée.'],
          'en_cours' => ['label' => 'En cours',   'desc' => 'Les services municipaux la traitent.'],
          'resolu'   => ['label' => 'Résolue',    'desc' => 'Le problème a été résolu.'],
        ];
        $current = $request->status()->value();
        $order   = array_keys($steps);
        $currentIdx = array_search($current, $order, true);
      ?>
      <ol class="track__list">
        <?php $i = 0; foreach ($steps as $key => $info): ?>
          <?php
            $state = 'pending';
            if ($i < $currentIdx)      $state = 'done';
            elseif ($i === $currentIdx) $state = 'current';
          ?>
          <li class="track__step track__step--<?= $state ?>">
            <span class="track__dot"></span>
            <div class="track__body">
              <strong><?= esc($info['label']) ?></strong>
              <small><?= esc($info['desc']) ?></small>
            </div>
          </li>
        <?php $i++; endforeach; ?>
      </ol>
    </section>

    <div class="req-show__actions">
      <a href="<?= site_url('citoyen/requests') ?>" class="btn-ghost">← Retour à mes demandes</a>
    </div>
  </article>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>