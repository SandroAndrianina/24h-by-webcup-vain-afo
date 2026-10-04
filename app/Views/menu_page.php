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
<div id="app" class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="nav-button" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="nav-button" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>

      <?php if (session()->get('logged_in') && session()->get('role') === 'admin'): ?>
        <a class="nav-button" href="<?= site_url('admin/dashboard') ?>">Administration</a>
      <?php endif; ?>

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
    <section class="alert-banner" role="region" aria-label="Alerte active" id="alertBanner">
      <div class="alert-banner__identity"><span class="alert-banner__dot"></span><span>ALERTE ACTIVE</span></div>
      <div class="alert-banner__message">
        <strong><?= esc($activeAlert['title']) ?></strong>
        <p><?= esc($activeAlert['content_trim']) ?>…</p>
      </div>
      <div class="alert-banner__actions">
        <?php if (!empty($alertAdvice)): ?>
          <button type="button" class="alert-banner__toggle"
                  aria-expanded="false"
                  aria-controls="alertAdvice"
                  onclick="(function(btn){
                    var p=document.getElementById('alertAdvice');
                    if(p.hasAttribute('hidden')){ p.removeAttribute('hidden'); btn.setAttribute('aria-expanded','true'); }
                    else { p.setAttribute('hidden',''); btn.setAttribute('aria-expanded','false'); }
                  })(this)">
            Recommandations IA <span aria-hidden="true">⌄</span>
          </button>
        <?php endif; ?>
        <a href="<?= site_url('menu?regen=1') ?>" class="alert-banner__regen" title="Régénérer les recommandations" aria-label="Régénérer les recommandations">↻</a>
        <button class="alert-banner__close" aria-label="Fermer l’alerte"
                onclick="document.getElementById('alertBanner')?.remove(); document.getElementById('alertAdvice')?.remove();">×</button>
      </div>
    </section>

    <?php if (!empty($alertAdvice)): ?>
      <section id="alertAdvice" class="alert-advice" hidden aria-label="Recommandations IA">
        <header class="alert-advice__head">
          <span class="alert-advice__badge">IA</span>
          <div><h2>Recommandations personnalisées</h2><p>Suggestions liées à l’alerte active</p></div>
        </header>
        <ul class="advice-list">
          <?php foreach ($alertAdvice['tips'] as $i => $tip): ?>
            <li><span class="advice-list__icon"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span><span><?= esc($tip) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <p class="alert-advice__foot">
          Généré par <strong><?= esc($alertAdvice['model']) ?></strong> · <?= esc($alertAdvice['time_ms']) ?> ms · Cache <?= $alertAdvice['cached'] ? 'actif' : 'inactif' ?>
        </p>
      </section>
    <?php endif; ?>
  <?php endif; ?>

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

<?php if ((session()->get('lang') ?? 'fr') === 'fr'): ?>
<script>
  // Réchauffe la version EN en arrière-plan (invisible)
  fetch('<?= site_url('prewarm/en') ?>', { credentials: 'same-origin' }).catch(()=>{});
</script>
<?php endif; ?>
</body>
</html>