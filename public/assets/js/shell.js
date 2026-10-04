/* ============================================================
   TERRA NOVA — Coquille partagée (Runtime)
   Révélation du card flottant, tracés de graphiques SVG,
   compteurs animés et barres qui se remplissent.
   Utilisable sans Vue : window.TerraShell
   ============================================================ */
window.TerraShell = (function () {
  'use strict';

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Révélation de la coquille (sans Vue) ---------- */
  function reveal(root) {
    const scope = root || document;
    const shells = scope.querySelectorAll('.shell:not(.ready)');
    if (!shells.length) return;
    if (reducedMotion) {
      shells.forEach((el) => el.classList.add('ready'));
      return;
    }
    requestAnimationFrame(() => requestAnimationFrame(() => {
      shells.forEach((el) => el.classList.add('ready'));
    }));
  }

  /* ---------- Tracés de courbes (Bézier lissée) ---------- */
  function curvePath(values, width, height, padding) {
    padding = padding === undefined ? 8 : padding;
    if (!values || !values.length) return '';
    if (values.length === 1) values = [values[0], values[0]];
    const min = Math.min.apply(null, values);
    const max = Math.max.apply(null, values);
    const spread = max - min || 1;
    const points = values.map((value, index) => ({
      x: (index / (values.length - 1)) * width,
      y: height - padding - ((value - min) / spread) * (height - padding * 2),
    }));
    return points.map((point, index) => {
      if (!index) return 'M' + point.x + ' ' + point.y;
      const previous = points[index - 1];
      const control = (point.x - previous.x) / 3;
      return 'C' + (previous.x + control) + ' ' + previous.y + ' ' +
             (point.x - control) + ' ' + point.y + ' ' + point.x + ' ' + point.y;
    }).join(' ');
  }

  function areaPath(values, width, height, padding) {
    padding = padding === undefined ? 8 : padding;
    const line = curvePath(values, width, height, padding);
    if (!line) return '';
    return line + ' L' + width + ' ' + height + ' L0 ' + height + ' Z';
  }

  /* ---------- Anneau (donut) en degrading conique ---------- */
  function ringBackground(segments, total) {
    const parts = [];
    let cursor = 0;
    (segments || []).forEach(function (segment) {
      const share = total > 0 ? segment.value / total : 0;
      if (share <= 0) return;
      parts.push(segment.color + ' ' + (cursor).toFixed(4) + 'turn ' + (cursor + share).toFixed(4) + 'turn');
      cursor += share;
    });
    if (!parts.length) return 'rgba(33,29,28,.1) 0turn';
    return parts.join(',');
  }

  /* ---------- Compteur animé ---------- */
  function tween(from, to, set, ms) {
    ms = ms || 1400;
    if (reducedMotion) { set(to); return; }
    const t0 = performance.now();
    const step = function (t) {
      const p = Math.max(0, Math.min((t - t0) / ms, 1));
      const eased = 1 - Math.pow(1 - p, 4);
      set(from + (to - from) * eased);
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  /* ---------- Rendu des graphiques déclaratifs ---------- */
  function paint(scope) {
    (scope || document).querySelectorAll('[data-chart]').forEach(function (svg) {
      const values = JSON.parse(svg.dataset.chart || '[]');
      const width = parseFloat(svg.dataset.width || '300');
      const height = parseFloat(svg.dataset.height || '100');
      const padding = parseFloat(svg.dataset.padding || '9');
      const area = svg.querySelector('.chart-area');
      const line = svg.querySelector('.chart-line');
      if (area) area.setAttribute('d', areaPath(values, width, height, padding));
      if (line) line.setAttribute('d', curvePath(values, width, height, padding));
    });
    (scope || document).querySelectorAll('[data-ring]').forEach(function (ring) {
      const segments = JSON.parse(ring.dataset.ring || '[]');
      const total = parseFloat(ring.dataset.total || '0');
      ring.style.background = 'conic-gradient(' + ringBackground(segments, total) + ')';
    });
    (scope || document).querySelectorAll('[data-count]').forEach(function (el) {
      const target = parseFloat(el.dataset.count || '0');
      const decimals = parseInt(el.dataset.decimals || '0', 10);
      tween(0, target, function (value) {
        el.textContent = value.toLocaleString('fr-FR', {
          minimumFractionDigits: decimals,
          maximumFractionDigits: decimals,
        });
      }, parseInt(el.dataset.speed || '1400', 10));
    });
  }

  function boot() {
    reveal(document);
    paint(document);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  return { reveal: reveal, paint: paint, curvePath: curvePath, areaPath: areaPath, ringBackground: ringBackground, tween: tween };
})();