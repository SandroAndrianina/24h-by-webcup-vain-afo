<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($request->type()->label()) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/shell.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
<script src="<?= base_url('assets/js/shell.js') ?>" defer></script>
</head>
<body>

<div class="stage">
 <div class="shell">

  <header class="top">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="pill" href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
      <a class="pill" href="<?= site_url('menu') ?>">Accueil</a>
      <a class="pill solid" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= site_url('menu') ?>">Accueil</a>
    <span class="breadcrumb__sep">›</span>
    <a href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
    <span class="breadcrumb__sep">›</span>
    <span aria-current="page">Demande #<?= esc($request->id()) ?></span>
  </nav>

  <?php
    $steps = [
      'nouveau'  => ['label' => 'Reçue',    'desc' => 'Votre demande a été enregistrée.'],
      'en_cours' => ['label' => 'En cours', 'desc' => 'Les services municipaux la traitent.'],
      'resolu'   => ['label' => 'Résolue',  'desc' => 'Le problème a été résolu.'],
    ];
    $order      = array_keys($steps);
    $current    = $request->status()->value();
    $currentIdx = array_search($current, $order, true);
    $progress   = $currentIdx === false ? 0 : $currentIdx;
  ?>

  <section class="bento req-show-bento">
    <article class="b b--dark b--fill">
      <header class="req-show__head">
        <span class="req-badge req-badge--lg" style="--bg: <?= esc($request->status()->color()) ?>">
          <?= esc($request->status()->label()) ?>
        </span>
        <span class="req-show__id">#<?= esc($request->id()) ?></span>
      </header>

      <small class="eyebrow"><?= esc($request->type()->label()) ?></small>
      <h1 style="margin-top:14px;font-size:clamp(1.8rem,3vw,2.7rem);font-weight:400;line-height:1.05;"><?= esc($request->type()->label()) ?></h1>

      <?php if ($request->location()): ?>
        <p class="req-show__loc" style="margin-top:14px;color:rgba(203,203,203,.7);"><?= esc($request->location()) ?></p>
      <?php endif; ?>

      <div class="track-progress" role="img" aria-label="Progression : étape <?= (int) $progress + 1 ?> sur <?= count($steps) ?>">
        <?php foreach ($steps as $i => $info): ?>
          <span class="track-progress__seg <?= $i <= $progress ? 'is-done' : '' ?>"></span>
        <?php endforeach; ?>
      </div>

      <div class="req-show__actions" style="margin-top:auto;padding-top:22px;">
        <a href="<?= site_url('citoyen/requests') ?>" class="btn btn--ghost-light">← Retour à mes demandes</a>
      </div>
    </article>

    <article class="b b--surface b--fill">
      <small class="eyebrow">DÉTAIL</small>
      <h2 class="chart-headline" style="margin-top:6px;">Description</h2>
      <p class="req-show__desc" style="margin-top:14px;"><?= nl2br(esc($request->description())) ?></p>
    </article>

    <article class="b b--acc b--fill">
      <small class="eyebrow">SUIVI</small>
      <h2 class="chart-headline" style="margin-top:6px;">Avancement</h2>
      <ol class="track__list" style="margin-top:16px;">
        <?php $i = 0; foreach ($steps as $info): ?>
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
    </article>
  </section>

 </div>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>