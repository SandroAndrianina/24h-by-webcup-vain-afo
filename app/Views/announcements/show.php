<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($announcement['title']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/shell.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script src="<?= base_url('assets/js/shell.js') ?>" defer></script>
</head>
<body>

<div class="stage">
 <div class="shell">

  <header class="top">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="pill" href="<?= site_url('announcements') ?>"><?= lang('App.announcements.back') ?></a>

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

  <section class="bento article-bento">
    <article class="b b--acc hero-stats">
      <small class="eyebrow">ANNONCE</small>
      <h1><?= esc($announcement['title']) ?></h1>
      <p><span class="live-dot"></span><?= esc(date('d M Y', strtotime($announcement['published_at']))) ?></p>
    </article>

    <article class="b b--surface b--fill">
      <div class="article-body"><?= nl2br(esc($announcement['content'])) ?></div>
      <div class="req-show__actions" style="margin-top:auto;padding-top:22px;">
        <a href="<?= site_url('announcements') ?>" class="btn">← Toutes les annonces</a>
      </div>
    </article>
  </section>

 </div>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>