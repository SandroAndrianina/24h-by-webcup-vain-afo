<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= lang('App.nav.announcements') ?> — TERRA NOVA</title>
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

  <section class="bento ann-bento">
    <article class="b b--acc hero-stats">
      <small class="eyebrow">ACTUALITÉ</small>
      <h1>Toutes les<br><mark>annonces.</mark></h1>
      <p><span class="live-dot"></span><?= count($announcements) ?> annonce<?= count($announcements) > 1 ? 's' : '' ?> publiée<?= count($announcements) > 1 ? 's' : '' ?></p>
    </article>

    <article class="b b--dark b--fill">
      <div class="stat-row"><div><small class="eyebrow">RÉPARTITION</small><h2 class="chart-headline" style="margin-top:6px;">Types de service</h2></div></div>
      <ul class="req-ring-card__legend" style="margin-top:auto;">
        <?php foreach (array_slice($announcements, 0, 5) as $a): ?>
          <li><i style="background: var(--acc)"></i><span><?= esc($a['title']) ?></span><b><?= esc(date('d/m', strtotime($a['published_at']))) ?></b></li>
        <?php endforeach; ?>
        <?php if (empty($announcements)): ?><li><i></i><span>Aucune annonce</span><b>—</b></li><?php endif; ?>
      </ul>
    </article>
  </section>

  <ul class="news__list">
    <?php foreach ($announcements as $i => $a): ?>
      <li class="news__item" style="--i:<?= $i ?>">
        <a href="<?= site_url('announcements/' . $a['id']) ?>">
          <time datetime="<?= esc($a['published_at']) ?>">
            <?= esc(date('d M Y', strtotime($a['published_at']))) ?>
          </time>
          <h3><?= esc($a['title']) ?></h3>
          <p><?= esc($a['content_trim'] ?? mb_substr(strip_tags($a['content']), 0, 140)) ?>…</p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

 </div>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>