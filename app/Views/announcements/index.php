<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= lang('App.nav.announcements') ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
</head>
<body>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>
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

  <header class="head"><h1><?= lang('App.announcements.title') ?></h1></header>

  <ul class="news__list">
    <?php foreach ($announcements as $a): ?>
      <li class="news__item">
        <a href="<?= site_url('announcements/' . $a['id']) ?>">
          <time datetime="<?= esc($a['published_at']) ?>">
            <?= esc(date('d M Y', strtotime($a['published_at']))) ?>
          </time>
          <h3><?= esc($a['title']) ?></h3>
          <p><?= esc($a['content_trim']) ?>…</p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>