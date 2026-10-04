<?php
$serviceImage = !empty($service['image']) ? base_url('assets/images/' . $service['image']) : null;
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
<link rel="stylesheet" href="<?= base_url('assets/css/shell.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script src="<?= base_url('assets/js/shell.js') ?>" defer></script>
</head>
<body>
<div class="stage">
 <div class="shell shell--tall shell--flush">

  <header class="top">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="pill" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="pill" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>

      <?php $currentLang = session()->get('lang') ?? 'fr'; ?>
      <a class="language-switch <?= $currentLang === 'en' ? 'is-en' : 'is-fr' ?>"
         href="<?= site_url('lang/' . ($currentLang === 'en' ? 'fr' : 'en')) ?>"
         role="switch" aria-checked="<?= $currentLang === 'en' ? 'true' : 'false' ?>"
         aria-label="<?= $currentLang === 'en' ? 'Langue active : anglais. Passer en français.' : 'Langue active : français. Passer en anglais.' ?>"
         title="<?= $currentLang === 'en' ? 'Passer en français' : 'Switch to English' ?>">
        <span class="language-switch__label" data-lang="fr">FR</span><span class="language-switch__track" aria-hidden="true"><i></i></span><span class="language-switch__label" data-lang="en">EN</span>
      </a>

      <?php if (session()->get('logged_in')): ?>
        <a class="pill solid" href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
        <a class="pill" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="pill solid" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
      <?php endif; ?>
    </nav>
  </header>

  <?php if (!empty($activeAlert)): ?>
    <section class="alert-banner alert-banner--compact" role="status" aria-label="Alerte active">
      <div class="alert-banner__identity"><span class="alert-banner__dot"></span><span>ALERTE ACTIVE</span></div>
      <div class="alert-banner__message">
        <strong><?= esc($activeAlert['title']) ?></strong>
        <p><?= esc($activeAlert['content_trim'] ?? '') ?>…</p>
      </div>
    </section>
  <?php endif; ?>

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

  <main class="service-page">
    <section class="service-hero">
      <div class="service-visual">
        <?php if ($serviceImage): ?>
          <img src="<?= esc($serviceImage) ?>" alt="<?= esc($service['name']) ?>" fetchpriority="high">
        <?php endif; ?>
        <span class="service-visual__index"><?= esc(str_pad((string) $service['id'], 2, '0', STR_PAD_LEFT)) ?> <i>/ 06</i></span>
        <span class="service-visual__label"><i></i> SERVICE TERRA NOVA</span>
      </div>

      <article class="service-detail">
        <span class="service-detail__eyebrow">EXPERTISE <i>·</i> <?= esc(str_pad((string) $service['id'], 2, '0', STR_PAD_LEFT)) ?></span>
        <h1><?= esc($service['name']) ?></h1>
        <p class="service-detail__lead"><?= esc($service['short_description']) ?></p>
        <a class="btn-cta" href="<?= session()->get('logged_in') ? site_url('citoyen/requests/new') : site_url('login') ?>">
          <?= lang('App.service.cta') ?> <span aria-hidden="true">→</span>
        </a>
      </article>
    </section>

    <?php if (!empty($service['details'])): ?>
      <section class="service-info">
        <header class="service-info__head">
          <span class="service-info__number">01</span>
          <div><span class="service-detail__eyebrow">TERRA NOVA</span><h2>À propos du service</h2></div>
        </header>
        <div class="service-detail__body"><?= nl2br(esc($service['details'])) ?></div>
      </section>
    <?php endif; ?>
  </main>

 </div>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>