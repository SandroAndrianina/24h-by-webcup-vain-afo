<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($dash['name']) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboardAdmin.css') ?>">
<script>window.DASH = <?= json_encode($dash, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js" defer></script>
<script src="<?= base_url('assets/js/dashboardAdmin.js') ?>" defer></script>
</head>
<body>
<div id="app" class="stage">
 <div class="shell" :class="{ ready }">

  <header class="top">
    <a class="brand" href="<?= site_url('admin/dashboard') ?>" aria-label="Tableau de bord TERRA NOVA"><img class="brand__logo" src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
   <nav><button class="pill">Aperçu</button><button class="pill">Support</button></nav>
   <div class="top-r">
    <button class="pill">Français ▾</button>
    <button class="pill">Compte</button>
    <button class="pill solid">Alertes ({{ d.alerts }})</button>
   </div>
  </header>

  <main class="bento">
   <article class="hero">
    <small class="eyebrow">CENTRE DE PILOTAGE</small>
    <h1>Votre activité,<br><mark>en un coup d’œil.</mark></h1>
    <p><span class="live-dot"></span>Données de démonstration · actualisées à l’instant</p>
   </article>

   <article class="b stat">
    <div class="card-kicker"><small class="chip">REVENUS</small><span class="trend">{{ d.best.change }}</span></div>
    <h3>{{ d.best.label }}</h3>
    <strong class="big">{{ fmt(bestN) }}{{ d.best.suffix }}</strong>
    <svg class="stat-chart" viewBox="0 0 240 62" preserveAspectRatio="none" role="img" aria-label="Courbe des revenus"><path class="chart-area" :d="bestArea"/><path class="chart-line" :d="bestPath"/></svg>
    <ul><li v-for="(k, i) in d.kpis" :key="k.label"><span>{{ k.label }}</span><b>{{ fmt(kpiN[i]) }}</b><small :class="'change-' + k.direction">{{ k.change }}</small></li></ul>
   </article>

   <article class="b traffic">
    <div class="chart-head"><div><small class="eyebrow">ACQUISITION</small><h2>Visites</h2></div><strong>{{ fmt(d.traffic.total) }} <small>cette semaine</small></strong></div>
    <div class="traffic-change"><span class="trend">{{ d.traffic.change }}</span><span>vs. semaine précédente</span></div>
    <svg class="traffic-chart" viewBox="0 0 300 104" preserveAspectRatio="none" role="img" aria-label="Courbe des visites"><path class="chart-area" :d="trafficArea"/><path class="chart-line" :d="trafficPath"/></svg>
    <div class="chart-labels"><span v-for="label in d.traffic.labels" :key="label">{{ label }}</span></div>
   </article>

   <article class="b modules-card">
    <div class="modules-head"><div><small class="eyebrow">RÉPARTITION</small><h2>Par module</h2></div><span class="modules-total">{{ fmt(d.modules.reduce((total, item) => total + item.count, 0)) }} éléments</span></div>
    <div class="module-bars">
     <button v-for="m in d.modules" :key="m.tag" class="module-row" :class="{ selected: m.tag === mod.tag }" @click="mod = m">
      <span class="module-label">{{ m.tag }}</span><span class="bar-track"><i :style="{ width: `${Math.max(8, (m.count / d.modules[0].count) * 100)}%` }"></i></span><b>{{ fmt(m.count) }}</b>
     </button>
    </div>
   </article>

   <article class="b mini">
    <div class="mini-head"><small class="eyebrow">{{ mod.tag }}</small><span class="trend">+8,4%</span></div>
    <strong class="big">{{ fmt(modN) }}</strong><span class="mini-caption">éléments actifs</span>
    <svg class="mini-chart" viewBox="0 0 180 48" preserveAspectRatio="none" role="img" :aria-label="`Tendance ${mod.tag}`"><path class="mini-area" :d="moduleArea"/><path class="mini-line" :d="modulePath"/></svg>
    <span class="mini-foot">Tendance sur 8 périodes</span>
   </article>

   <article class="b dark">
    <div class="activity-head"><div><small class="eyebrow">TENDANCE</small><h2>Activité</h2></div><div class="r-tabs"><button v-for="(v, k) in d.ranges" :key="k" class="range-tab" :class="{ on: k === range }" @click="range = k">{{ k }}</button></div></div>
    <strong class="activity-total">{{ fmt(rangeData.total) }} <small>actions</small></strong>
    <svg class="activity-chart" viewBox="0 0 300 82" preserveAspectRatio="none" role="img" :aria-label="`Activité sur ${range}`"><path class="activity-area" :d="rangeArea"/><path class="activity-line" :key="range" :d="rangePath"/></svg>
    <div class="activity-labels"><span>Début</span><span>{{ range }}</span><span>Aujourd’hui</span></div>
   </article>
  </main>

 </div>
</div>
</body>
</html>
