<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu — <?= esc($menu['name']) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<script>window.MENU = <?= json_encode($menu, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js" defer></script>
<script src="<?= base_url('assets/js/accordion.js') ?>" defer></script>
</head>
<body>
<div id="app" class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>" aria-label="TERRA NOVA, liste des services"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav" aria-label="Navigation principale">
      <a class="nav-button" href="<?= site_url('') ?>">Accueil</a>
      <a class="nav-button" href="<?= site_url('admin/dashboard') ?>">Administration</a>
      <a class="nav-button nav-button--accent" href="<?= site_url('login') ?>">Connexion</a>
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
        <span class="open">Ouvrir <i>→</i></span>
      </span>
    </button>
  </nav>
</div>
</body>
</html>
