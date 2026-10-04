<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($menu['name']) ?> — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/shell.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script>window.MENU = <?= json_encode($menu, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js" defer></script>
<script src="<?= base_url('assets/js/accordion.js') ?>" defer></script>
<script src="<?= base_url('assets/js/shell.js') ?>" defer></script>
</head>
<body>
<div id="app" class="stage">
 <div class="shell shell--tall shell--flush" :class="{ ready }">

  <header class="top">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="pill" href="<?= site_url('menu') ?>"><?= lang('App.nav.home') ?></a>
      <a class="pill" href="<?= site_url('announcements') ?>"><?= lang('App.nav.announcements') ?></a>

      <?php if (session()->get('logged_in') && session()->get('role') === 'admin'): ?>
        <a class="pill" href="<?= site_url('admin/dashboard') ?>">Administration</a>
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
        <a class="pill" href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
        <a class="pill solid" href="<?= site_url('logout') ?>"><?= lang('App.nav.logout') ?></a>
      <?php else: ?>
        <a class="pill solid" href="<?= site_url('login') ?>"><?= lang('App.nav.login') ?></a>
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

  <section class="bento menu-bento">
    <article class="b b--acc hero-stats">
      <small class="eyebrow">TERRA NOVA · <?= str_pad(count($menu['items']), 2, '0', STR_PAD_LEFT) ?> SERVICES</small>
      <h1>Choisissez<br><mark>votre service.</mark></h1>
      <p><span class="live-dot"></span><?= $dash['announcements'] ?> annonce<?= $dash['announcements'] > 1 ? 's' : '' ?> publiée<?= $dash['announcements'] > 1 ? 's' : '' ?> · alertes <?= $dash['alert'] ? ' actives' : ' inactives' ?></p>
    </article>

    <article class="b b--bg stat b--fill">
      <div class="stat-row"><small class="chip">CATALOGUE</small><span class="trend trend--up">100% actif</span></div>
      <h3>Services en ligne</h3>
      <strong class="big" data-count="<?= (int) $dash['services'] ?>" data-speed="1100">0</strong>
      <svg class="chart chart--draw stat-chart" viewBox="0 0 240 58" preserveAspectRatio="none" role="img" aria-label="Courbe des publications"
           data-chart="<?= esc(json_encode($dash['timeline']['series'])) ?>" data-width="240" data-height="58" data-padding="7">
        <path class="chart-area"></path><path class="chart-line"></path>
      </svg>
      <ul class="stat-list">
        <?php foreach (array_slice($dash['timeline']['series'], -3) as $offset => $count): ?>
          <li><span><?= esc($dash['timeline']['labels'][count($dash['timeline']['series']) - 3 + $offset]) ?></span><b><?= (int) $count ?></b><small><?= $count > 0 ? 'publié' : '—' ?></small></li>
        <?php endforeach; ?>
      </ul>
    </article>

    <article class="b b--dark b--fill">
      <div class="stat-row">
        <div><small class="eyebrow">ÉDITORIAL</small><h2 class="chart-headline" style="margin-top:6px;font-size:1.2rem;font-weight:550;">Publications</h2></div>
        <strong style="font-size:1.05rem;"><?= (int) array_sum($dash['timeline']['series']) ?></strong>
      </div>
      <svg class="chart chart--draw" viewBox="0 0 300 96" preserveAspectRatio="none" role="img" aria-label="Publications des six derniers mois"
           data-chart="<?= esc(json_encode($dash['timeline']['series'])) ?>" data-width="300" data-height="96" data-padding="9"
           style="height:96px;margin-top:auto;">
        <path class="chart-area"></path><path class="chart-line"></path>
      </svg>
      <div class="chart-labels" style="color:rgba(203,203,203,.62);">
        <?php foreach ($dash['timeline']['labels'] as $label): ?><span><?= esc($label) ?></span><?php endforeach; ?>
      </div>
    </article>
  </section>

  <header class="head"><h1>{{ name }}</h1></header>

  <div class="acc" role="group" aria-label="Menu principal">
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
  </div>

  <?php if (!empty($announcements)): ?>
  <section class="news" aria-label="<?= lang('App.home.latest') ?>">
    <header class="news__head">
      <div><small class="eyebrow">ACTUALITÉ</small><h2 style="margin-top:6px;"><?= lang('App.home.latest') ?></h2></div>
      <a class="news__all" href="<?= site_url('announcements') ?>"><?= lang('App.home.seeAll') ?> →</a>
    </header>
    <ul class="news__list">
      <?php foreach ($announcements as $i => $a): ?>
        <li class="news__item" style="--i:<?= $i ?>">
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
</div>

<?= view('partials/a11y_widget') ?>

<?php if ((session()->get('lang') ?? 'fr') === 'fr'): ?>
<script>
  fetch('<?= site_url('prewarm/en') ?>', { credentials: 'same-origin' }).catch(()=>{});
</script>
<?php endif; ?>
</body>
</html>