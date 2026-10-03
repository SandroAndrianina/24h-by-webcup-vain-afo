const { createApp, ref, reactive, computed, onMounted, onBeforeUnmount } = Vue
const CFG = window.TERRA_NOVA

const messages = {
  quote: '« TERRA NOVA, là où les rêves d’hier deviennent les horizons de demain. »', signUp: 'Créer un compte',
  email: 'Adresse e-mail', password: 'Mot de passe', login: 'Connexion', noAccount: 'Pas encore de compte ?',
  errEmail: 'Adresse e-mail invalide', errPass: 'Mot de passe requis', errBad: 'Identifiants incorrects',
  errMany: 'Trop de tentatives', errNet: 'Serveur injoignable', errCsrf: 'Rechargez la page', ok: 'Bienvenue, {name} !',
}

createApp({
  setup() {
    const t = (k, vars = {}) =>
      Object.entries(vars).reduce((s, [a, b]) => s.replace(`{${a}}`, b), messages[k] ?? k)

    /* ---------- Config (vient de PHP) ---------- */
    const site = reactive({ loaded: false, brand: CFG.brand, heroPosition: CFG.heroPosition, images: CFG.images, links: CFG.links })
    const stageStyle = computed(() => ({ '--bg': `url("${site.images.background}")` }))
    let navigationTimer
    function navigateTo(url) {
      document.body.classList.add('is-closing')
      const delay = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 360
      navigationTimer = window.setTimeout(() => window.location.assign(url), delay)
    }
    function handleNavigation(event) {
      if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return
      const link = event.target.closest('a[href]')
      if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) return
      const destination = new URL(link.href, window.location.href)
      if (destination.origin === location.origin && destination.pathname === location.pathname && destination.search === location.search) return
      event.preventDefault()
      navigateTo(destination.href)
    }

    /* ---------- Panneau gauche : biseau à coins arrondis ---------- */
    const hero = ref(null)
    let observer
    function roundedPath(pts, r) {
      const n = pts.length
      const toward = (a, b) => {
        const len = Math.hypot(b.x - a.x, b.y - a.y), k = Math.min(r, len / 2) / len
        return `${(a.x + (b.x - a.x) * k).toFixed(1)} ${(a.y + (b.y - a.y) * k).toFixed(1)}`
      }
      return pts.map((p, i) =>
        `${i ? 'L' : 'M'}${toward(p, pts[(i + n - 1) % n])} Q${p.x} ${p.y} ${toward(p, pts[(i + 1) % n])}`).join(' ') + 'Z'
    }
    function shape() {
      const el = hero.value, w = el.offsetWidth, h = el.offsetHeight
      const SLANT = 0.31 // ← inclinaison de la diagonale (0 = droit)
      const pts = [{ x: 0, y: 0 }, { x: w, y: 0 }, { x: w * (1 - SLANT), y: h }, { x: 0, y: h }]
      el.style.clipPath = `path('${roundedPath(pts, w * 0.08)}')`
    }

    /* ---------- Formulaire ---------- */
    const form = reactive({ email: '', password: '' })
    const loading = ref(false)
    const status = reactive({ type: '', key: '', vars: {} })
    const setStatus = (type = '', key = '', vars = {}) => Object.assign(status, { type, key, vars })
    let csrf = CFG.csrf

    async function login(email, password) {
      const res = await fetch(CFG.loginUrl, {
        method: 'POST', credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json',
                   'X-Requested-With': 'XMLHttpRequest', [CFG.csrfHeader]: csrf },
        body: JSON.stringify({ email, password }),
      })
      const data = await res.json().catch(() => null)
      if (data?.csrf) csrf = data.csrf
      return { ok: res.ok && data?.ok === true, status: res.status, data }
    }

    async function submit() {
      if (loading.value) return
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) return setStatus('error', 'errEmail')
      if (!form.password) return setStatus('error', 'errPass')
      loading.value = true
      setStatus()
      try {
        const r = await login(form.email, form.password)
        if (r.ok) setStatus('success', 'ok', { name: r.data.user.name })
        else if (r.status === 403) setStatus('error', 'errCsrf')
        else setStatus('error', r.data?.error === 'too_many_attempts' ? 'errMany' : 'errBad')
      } catch {
        setStatus('error', 'errNet')
      } finally {
        loading.value = false
      }
    }
    onMounted(() => {
      document.documentElement.lang = 'fr'
      document.addEventListener('click', handleNavigation)
      shape()
      observer = new ResizeObserver(shape)
      observer.observe(hero.value)
      site.loaded = true
    })
    onBeforeUnmount(() => {
      observer?.disconnect()
      document.removeEventListener('click', handleNavigation)
      window.clearTimeout(navigationTimer)
    })

    return { t, site, stageStyle, hero, form, loading, status, submit }
  },
}).mount('#app')
