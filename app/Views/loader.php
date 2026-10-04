<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#211d1c">
    <title><?= esc(config(\Config\TerraNova::class)->brand) ?> — Start</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>">
    <link rel="prefetch" href="<?= site_url('menu') ?>" as="document">
    <!-- Précharge la vidéo le plus tôt possible -->
    <link rel="preload" href="<?= base_url('assets/images/terra-nova-start.mp4') ?>" as="video" type="video/mp4">
</head>
<body>
<main class="launch">
    <img class="launch__image" src="<?= base_url('assets/images/background.jpg') ?>" alt="" fetchpriority="high">
    <video class="launch__video" poster="<?= base_url('assets/images/background.jpg') ?>" playsinline preload="auto" muted aria-label="Vidéo de présentation TERRA NOVA">
        <source src="<?= base_url('assets/images/terra-nova-start.mp4') ?>" type="video/mp4">
    </video>

    <div class="launch__preload" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>

    <section class="launch__content is-hidden" aria-label="TERRA NOVA">
        <a class="launch__start" href="<?= site_url('menu') ?>">START</a>
    </section>
</main>
<script>
  const launch     = document.querySelector('.launch')
  const introVideo = document.querySelector('.launch__video')
  const startLink  = document.querySelector('.launch__start')
  const preload    = document.querySelector('.launch__preload')
  const content    = document.querySelector('.launch__content')

  let videoReady = false
  let timerDone  = false

  introVideo.load()
  fetch('<?= site_url('prewarm/en') ?>', { credentials: 'same-origin' }).catch(()=>{})
  fetch('<?= site_url('menu') ?>', { credentials: 'same-origin' }).catch(()=>{})

  // Condition 1 : vidéo prête
  introVideo.addEventListener('canplay', () => {
    videoReady = true
    maybeReveal()
  }, { once: true })

  // Condition 2 : 800ms minimum écoulé
  setTimeout(() => {
    timerDone = true
    maybeReveal()
  }, 800)

  function maybeReveal() {
    if (!videoReady || !timerDone) return
    preload.style.display = 'none'
    content.classList.remove('is-hidden')
  }

  function goToMenu() {
    document.documentElement.style.background = '#cbcbcb'
    window.location.replace(startLink.href)
  }

  introVideo.addEventListener('ended', goToMenu)

  document.addEventListener('visibilitychange', () => {
    if (!document.hidden && launch.classList.contains('is-playing') && introVideo.paused) {
      introVideo.play().catch(goToMenu)
    }
  })

  startLink.addEventListener('click', event => {
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return
    event.preventDefault()
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return goToMenu()

    introVideo.muted = false
    launch.classList.add('is-playing')

    introVideo.play().catch(goToMenu)
  })
</script>
</body>
</html>