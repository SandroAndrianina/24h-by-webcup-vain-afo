<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($page['brand']) ?> — Connexion</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
<div id="app" v-cloak>
  <main class="stage" :class="{ 'is-ready': site.loaded }" :style="stageStyle">
    <section class="card" :class="{ 'is-signup': mode === 'signup' }">
      <!-- GAUCHE -->
      <aside ref="hero" class="hero">
        <img class="hero__img" :src="site.images.hero" :style="{ objectPosition: site.heroPosition }" alt="">
        <p class="hero__quote">{{ t('quote') }}</p>
      </aside>

      <!-- DROITE -->
      <div class="panel">
        <div class="panel__body">
          <img class="brand-logo" src="<?= base_url('assets/images/logo.png') ?>" alt="<?= esc($page['brand']) ?>" width="683" height="352">

          <div class="form-stack">
            <form class="form login-form" :class="{ 'is-active': mode === 'login' }" :aria-hidden="mode !== 'login'" :inert="mode !== 'login'" novalidate @submit.prevent="submit">
              <input v-model.trim="form.email" type="email" autocomplete="email" :placeholder="t('email')" :aria-label="t('email')">
              <input v-model="form.password" type="password" autocomplete="current-password" :placeholder="t('password')" :aria-label="t('password')">

              <div class="form__row">
                <p class="status" :class="'is-' + status.type" role="status">{{ status.key && t(status.key, status.vars) }}</p>
              </div>

              <button class="btn-login" type="submit" :disabled="loading">
                <i v-if="loading" class="spinner"></i><template v-else>{{ t('login') }}</template>
              </button>

              <p class="signup">{{ t('noAccount') }} <button class="red form__switch" type="button" @click="switchMode('signup')">{{ t('signUp') }}</button></p>
            </form>

            <form class="form signup-form" :class="{ 'is-active': mode === 'signup' }" :aria-hidden="mode !== 'signup'" :inert="mode !== 'signup'" novalidate @submit.prevent="submitSignup">
              <h2 class="form__title">{{ t('signupTitle') }}</h2>
              <input v-model.trim="signupForm.name" type="text" autocomplete="name" :placeholder="t('name')" :aria-label="t('name')">
              <input v-model.trim="signupForm.email" type="email" autocomplete="email" :placeholder="t('email')" :aria-label="t('email')">
              <input v-model="signupForm.password" type="password" autocomplete="new-password" :placeholder="t('password')" :aria-label="t('password')">
              <input v-model="signupForm.confirmPassword" type="password" autocomplete="new-password" :placeholder="t('confirmPassword')" :aria-label="t('confirmPassword')">

              <div class="form__row">
                <p class="status" :class="'is-' + status.type" role="status">{{ status.key && t(status.key, status.vars) }}</p>
              </div>

              <button class="btn-login" type="submit" :disabled="loading">{{ t('signupAction') }}</button>
              <p class="signup">{{ t('alreadyRegistered') }} <button class="red form__switch" type="button" @click="switchMode('login')">{{ t('login') }}</button></p>
            </form>
          </div>

          <div v-if="mode === 'login'" class="social">
            <a :href="site.links.linkedin" target="_blank" rel="noopener" aria-label="LinkedIn">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path></svg>
            </a>
            <a :href="site.links.instagram" target="_blank" rel="noopener" aria-label="Instagram">
              <svg viewBox="0 0 24 24"><rect width="24" height="24" rx="6" fill="currentColor"></rect><g fill="none" stroke="#fff" stroke-width="2"><rect x="5" y="5" width="14" height="14" rx="4"></rect><circle cx="12" cy="12" r="3.3"></circle></g><circle cx="16.4" cy="7.6" r="1.1" fill="#fff"></circle></svg>
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>

<script>
  // Données envoyées par le contrôleur Auth::index()
  window.TERRA_NOVA = <?= json_encode($page, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>;
</script>
<script src="https://unpkg.com/vue@3.5.13/dist/vue.global.prod.js"></script>
<script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>
</html>
