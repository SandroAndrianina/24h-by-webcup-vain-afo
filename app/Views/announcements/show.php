<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($announcement['title']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
</head>
<body>

<?php if (!empty($activeAlert)): ?>
  <div class="alert-banner" role="alert">
    <span class="alert-banner__dot"></span>
    <strong><?= esc($activeAlert['title']) ?></strong>
    <span><?= esc($activeAlert['content_trim'] ?? '') ?>…</span>
  </div>
<?php endif; ?>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.announcements.back') ?></a>
      <a class="nav-button" href="<?= site_url('lang/' . (session()->get('lang') === 'en' ? 'fr' : 'en')) ?>"><?= lang('App.locale.switch') ?></a>
      <?php if (session()->get('logged_in')): ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
      <?php endif; ?>
    </nav>
  </header>

  <article style="max-width: 780px; margin: 40px auto; padding: 32px; border: 1px solid var(--ink); border-radius: 16px;">
    <time style="font-size:.8rem; text-transform:uppercase; letter-spacing:.08em; opacity:.65;">
      <?= esc(date('d M Y', strtotime($announcement['published_at']))) ?>
    </time>
    <h1 style="font-size:2rem; font-weight:800; text-transform:uppercase; margin:16px 0 24px;">
      <?= esc($announcement['title']) ?>
    </h1>
    <div style="font-size:1rem; line-height:1.7;">
      <?= nl2br(esc($announcement['content'])) ?>
    </div>
  </article>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>