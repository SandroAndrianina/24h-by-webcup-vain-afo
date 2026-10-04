<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($announcement['title']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
</head>
<body>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.announcements.back') ?></a>
      <?php $currentLang = session()->get('lang') ?? 'fr'; ?>
      <a class="language-switch <?= $currentLang === 'en' ? 'is-en' : 'is-fr' ?>"
         href="<?= site_url('lang/' . ($currentLang === 'en' ? 'fr' : 'en')) ?>"
         role="switch" aria-checked="<?= $currentLang === 'en' ? 'true' : 'false' ?>"
         aria-label="<?= $currentLang === 'en' ? 'Langue active : anglais. Passer en français.' : 'Langue active : français. Passer en anglais.' ?>"
         title="<?= $currentLang === 'en' ? 'Passer en français' : 'Switch to English' ?>">
        <span class="language-switch__label" data-lang="fr">FR</span><span class="language-switch__track" aria-hidden="true"><i></i></span><span class="language-switch__label" data-lang="en">EN</span>
      </a>
      <?php if (session()->get('logged_in')): ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
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