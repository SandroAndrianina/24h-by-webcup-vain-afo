<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($menu['name']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script>window.MENU = <?= json_encode($menu, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js" defer></script>
<script src="<?= base_url('assets/js/accordion.js') ?>" defer></script>
</head>
<body>

<?php if (!empty($activeAlert)): ?>
  <div class="alert-banner" role="alert">
    <span class="alert-banner__dot"></span>
    <strong><?= esc($activeAlert['title']) ?></strong>
    <span><?= esc($activeAlert['content_trim']) ?>…</span>
    <button class="alert-banner__close" aria-label="Fermer" onclick="this.parentElement.remove()">×</button>
  </div>
<?php endif; ?>

<div id="app" class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA, liste des services"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="nav-button" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>

      <?php if (session()->get('logged_in') && session()->get('role') === 'admin'): ?>
        <a class="nav-button" href="<?= site_url('admin/dashboard') ?>">Administration</a>
      <?php endif; ?>

      <a class="nav-button" href="<?= site_url('lang/' . (session()->get('lang') === 'en' ? 'fr' : 'en')) ?>">
        <?= lang('App.locale.switch') ?>
      </a>

      <?php if (session()->get('logged_in')): ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="nav-button nav-button--accent" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
      <?php endif; ?>
    </nav>
  </header>

  <header class="head"><h1>{{ name }}</h1></header>

  <nav class="acc" :style="{ '--n': items.length }" aria-label="Menu principal">
    <button v-for="(it, i) in items" :key="it.num" type="button" class="panel"
       :class="{ on: i === active }" :style="{ '--i': i }"
       :aria-expanded="i === active" @mouseenter="active = i" @focus="active = i" @click="active = i">
      <img class="panel__image" :src="it.image" alt="">
      <span class="num">{{ it.num }}</span>
      <span class="ico" v-html="icons[it.icon]"></span>
      <span class="txt">
        <strong>{{ it.title }}</strong>
        <em>{{ it.text }}</em>
        <a class="open" :href="'/services/' + it.id" @click.stop><?= lang('App.home.open') ?> <i>→</i></a>
      </span>
    </button>
  </nav>

  <?php if (!empty($announcements)): ?>
  <section class="news" aria-label="<?= lang('App.home.latest') ?>">
    <header class="news__head">
      <h2><?= lang('App.home.latest') ?></h2>
      <a class="news__all" href="<?= site_url('announcements') ?>"><?= lang('App.home.seeAll') ?> →</a>
    </header>
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
  </section>
  <?php endif; ?>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>