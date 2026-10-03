<?php
$crumb = [
    ['label' => lang('App.nav.home'),      'url' => site_url('menu')],
    ['label' => lang('App.nav.services'),  'url' => site_url('menu')],
    ['label' => $service['name'],          'url' => null],
];
?>
<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($service['name']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
</head>
<body>

<?php if (!empty($activeAlert)): ?>
  <div class="alert-banner" role="alert">
    <span class="alert-banner__dot"></span>
    <strong><?= esc($activeAlert['title']) ?></strong>
  </div>
<?php endif; ?>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>
      <a class="nav-button" href="<?= site_url('lang/' . (session()->get('lang') === 'en' ? 'fr' : 'en')) ?>"><?= lang('App.locale.switch') ?></a>
      <?php if (session()->get('logged_in')): ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
      <?php endif; ?>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <?php foreach ($crumb as $i => $c): ?>
      <?php if ($c['url']): ?>
        <a href="<?= $c['url'] ?>"><?= esc($c['label']) ?></a>
      <?php else: ?>
        <span aria-current="page"><?= esc($c['label']) ?></span>
      <?php endif; ?>
      <?php if ($i < count($crumb) - 1): ?><span class="breadcrumb__sep">›</span><?php endif; ?>
    <?php endforeach; ?>
  </nav>

  <article class="service-detail">
    <h1><?= esc($service['name']) ?></h1>
    <p class="service-detail__lead"><?= esc($service['short_description']) ?></p>
    <?php if (!empty($service['details'])): ?>
      <div class="service-detail__body"><?= nl2br(esc($service['details'])) ?></div>
    <?php endif; ?>

    <a class="btn-cta" href="<?= session()->get('logged_in') ? site_url('citoyen/requests/new') : site_url('login') ?>">
      <?= lang('App.service.cta') ?> →
    </a>
  </article>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>