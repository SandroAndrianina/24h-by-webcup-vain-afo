<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#211d1c">
    <title><?= esc(config(\Config\TerraNova::class)->brand) ?> — Start</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>">
</head>
<body>
<main class="launch">
    <img class="launch__image" src="<?= base_url('assets/images/background.jpg') ?>" alt="" fetchpriority="high">
  <video class="launch__video" poster="<?= base_url('assets/images/background.jpg') ?>" playsinline preload="auto" aria-label="Vidéo de présentation TERRA NOVA">
    <source src="<?= base_url('assets/images/terra-nova-start.mp4') ?>" type="video/mp4">
  </video>
    <section class="launch__content" aria-label="TERRA NOVA">
        <a class="launch__start" href="<?= site_url('login') ?>">START</a>
    </section>
</main>
<script>
  const launch = document.querySelector('.launch')
  const introVideo = document.querySelector('.launch__video')
  const startLink = document.querySelector('.launch__start')
  let transitionTimer
  let introTimer

  function openLogin() {
    if (launch.classList.contains('is-transitioning')) return
    introVideo.pause()
    window.clearTimeout(introTimer)
    launch.classList.add('is-transitioning')
    const delay = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 450
    transitionTimer = window.setTimeout(() => window.location.assign(startLink.href), delay)
  }

  introVideo.addEventListener('ended', openLogin)
  introVideo.addEventListener('error', openLogin)
  document.addEventListener('visibilitychange', () => {
    if (!document.hidden && launch.classList.contains('is-playing') && introVideo.paused) {
      introVideo.play().catch(openLogin)
    }
  })
  startLink.addEventListener('click', event => {
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return
    event.preventDefault()
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return openLogin()
    launch.classList.add('is-playing')
    introVideo.play().then(() => {
      introTimer = window.setTimeout(openLogin, Math.min(introVideo.duration * 1000, 4800))
    }).catch(openLogin)
  })
</script>
</body>
</html>