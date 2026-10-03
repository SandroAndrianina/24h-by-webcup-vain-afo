<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu — <?= esc($menu['name']) ?></title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;700;800&display=swap">
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script>window.MENU = <?= json_encode($menu, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js" defer></script>
<script src="<?= base_url('assets/js/accordion.js') ?>" defer></script>
</head>
<body>
<div id="app" class="page">
  <header class="head"><b>MENU DE</b><span>{{ name }}</span></header>

  <nav class="acc" :style="{ '--n': items.length }" aria-label="Menu principal">
    <a v-for="(it, i) in items" :key="it.num" :href="it.url" class="panel"
       :class="{ on: i === active }" :style="{ '--i': i }"
       @mouseenter="active = i" @focus="active = i">
      <span class="num">{{ it.num }}</span>
      <span class="ico" v-html="icons[it.icon]"></span>
      <span class="txt">
        <strong>{{ it.title }}</strong>
        <em>{{ it.text }}</em>
        <span class="open">Ouvrir <i>→</i></span>
      </span>
    </a>
  </nav>
</div>
</body>
</html>
