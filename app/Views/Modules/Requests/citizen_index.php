<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mes demandes — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/shell.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
<script src="<?= base_url('assets/js/shell.js') ?>" defer></script>
</head>
<body>

<div class="stage">
 <div class="shell shell--tall shell--flush">

  <header class="top">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="pill" href="<?= site_url('menu') ?>">Accueil</a>
      <a class="pill solid" href="<?= site_url('citoyen/requests/new') ?>">+ Nouvelle demande</a>
      <a class="pill" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= site_url('menu') ?>">Accueil</a>
    <span class="breadcrumb__sep">›</span>
    <span aria-current="page">Mes demandes</span>
  </nav>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash flash--success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <section class="bento req-bento">
    <article class="b b--acc hero-stats">
      <small class="eyebrow">ESPACE CITOYEN</small>
      <h1>Mes demandes,<br><mark>en un regard.</mark></h1>
      <p><span class="live-dot"></span><?= (int) $stats['total'] ?> demande<?= $stats['total'] > 1 ? 's' : '' ?> · <?= (int) $stats['rate'] ?> % résolue<?= $stats['total'] > 1 ? 's' : '' ?></p>
    </article>

    <article class="b b--bg stat b--fill">
      <div class="stat-row"><small class="chip">VOLUME</small><span class="trend trend--up">6 mois</span></div>
      <h3>Demandes envoyées</h3>
      <strong class="big" data-count="<?= (int) $stats['total'] ?>" data-speed="1200">0</strong>
      <svg class="chart chart--draw stat-chart" viewBox="0 0 240 58" preserveAspectRatio="none" role="img" aria-label="Évolution des demandes"
           data-chart="<?= esc(json_encode($stats['timeline']['series'])) ?>" data-width="240" data-height="58" data-padding="7">
        <path class="chart-area"></path><path class="chart-line"></path>
      </svg>
      <ul class="stat-list">
        <?php foreach (array_slice($stats['timeline']['series'], -3) as $offset => $count): ?>
          <li><span><?= esc($stats['timeline']['labels'][count($stats['timeline']['series']) - 3 + $offset]) ?></span><b><?= (int) $count ?></b><small><?= $count > 0 ? 'envoyée' . ($count > 1 ? 's' : '') : '—' ?></small></li>
        <?php endforeach; ?>
      </ul>
    </article>

    <article class="b b--surface req-ring-card">
      <div class="ring"
           data-ring="<?= esc(json_encode(array_map(static fn (array $s): array => ['value' => (int) $s['value'], 'color' => $s['color']], $stats['statuses']))) ?>"
           data-total="<?= (int) $stats['total'] ?>">
        <div class="ring__hole"><b data-count="<?= (int) $stats['rate'] ?>" data-speed="1200">0</b><small>% résolu</small></div>
      </div>
      <div class="req-ring-card__body">
        <small class="eyebrow">RÉPARTITION</small>
        <h2>Statuts</h2>
        <ul class="req-ring-card__legend">
          <?php foreach ($stats['statuses'] as $status): ?>
            <li><i style="background: <?= esc($status['color']) ?>"></i><span><?= esc($status['label']) ?></span><b><?= (int) $status['value'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </article>

    <article class="b b--deep b--fill">
      <div class="stat-row"><div><small class="eyebrow">PAR TYPE</small><h2 class="chart-headline" style="margin-top:6px;">Répartition</h2></div></div>
      <div class="req-bars">
        <?php $max = $stats['types'] ? max(array_column($stats['types'], 'count')) : 0; ?>
        <?php if (empty($stats['types'])): ?>
          <p class="muted" style="font-size:.75rem;">Aucune donnée pour le moment.</p>
        <?php else: ?>
          <?php foreach ($stats['types'] as $type): ?>
            <div class="req-bar">
              <span class="bar-label"><?= esc($type['label']) ?></span>
              <span class="bar-track"><i style="width: <?= $max > 0 ? max(8, (int) round($type['count'] / $max * 100)) : 8 ?>%"></i></span>
              <b><?= (int) $type['count'] ?></b>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </article>

    <article class="b b--dark b--fill">
      <div class="stat-row"><div><small class="eyebrow">ACTIVITÉ</small><h2 class="chart-headline" style="margin-top:6px;">Six derniers mois</h2></div></div>
      <svg class="chart chart--draw" viewBox="0 0 300 92" preserveAspectRatio="none" role="img" aria-label="Demandes envoyées sur six mois"
           data-chart="<?= esc(json_encode($stats['timeline']['series'])) ?>" data-width="300" data-height="92" data-padding="9"
           style="height:92px;margin-top:auto;">
        <path class="chart-area"></path><path class="chart-line"></path>
      </svg>
      <div class="chart-labels" style="color:rgba(203,203,203,.62);">
        <?php foreach ($stats['timeline']['labels'] as $label): ?><span><?= esc($label) ?></span><?php endforeach; ?>
      </div>
    </article>
  </section>

  <?php if (empty($requests)): ?>
    <section class="b b--outline req-empty">
      <div>
        <p>Vous n'avez encore envoyé aucune demande.</p>
        <a href="<?= site_url('citoyen/requests/new') ?>" class="btn btn--acc">Créer ma première demande →</a>
      </div>
    </section>
  <?php else: ?>
    <header class="head">
      <div><small class="eyebrow">HISTORIQUE</small><h2 class="chart-headline" style="margin-top:6px;">Toutes mes demandes</h2></div>
      <a class="btn btn--acc" href="<?= site_url('citoyen/requests/new') ?>">+ Nouvelle demande</a>
    </header>

    <ul class="req-list">
      <?php foreach ($requests as $i => $r): ?>
        <li class="req-item" style="--i:<?= $i ?>">
          <a href="<?= site_url('citoyen/requests/' . $r->id()) ?>">
            <header class="req-item__head">
              <span class="req-badge" style="--bg: <?= esc($r->status()->color()) ?>">
                <?= esc($r->status()->label()) ?>
              </span>
              <time class="req-item__date" datetime="<?= esc($r->createdAt()) ?>">
                <?= esc(date('d M Y', strtotime($r->createdAt()))) ?>
              </time>
            </header>
            <h3 class="req-item__title"><?= esc($r->type()->label()) ?></h3>
            <p class="req-item__desc"><?= esc(mb_substr($r->description(), 0, 140)) ?>…</p>
            <footer class="req-item__foot">
              <?php if ($r->location()): ?>
                <span class="req-item__loc"><?= esc($r->location()) ?></span>
              <?php else: ?>
                <span class="req-item__loc">Sans localisation</span>
              <?php endif; ?>
              <span class="req-item__id">#<?= (int) $r->id() ?></span>
            </footer>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

 </div>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>