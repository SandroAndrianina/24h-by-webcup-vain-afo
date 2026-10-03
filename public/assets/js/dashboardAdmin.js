const { createApp, ref, computed, onMounted, watch } = Vue;

createApp({
  setup() {
    const d = window.DASH;
    const ready = ref(false);
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const range = ref("7j");
    const mod = ref(d.modules[0]);
    const bestN = ref(0);
    const kpiN = ref(d.kpis.map(() => 0));
    const modN = ref(0);

    const fmt = (n) => Math.round(n).toLocaleString("fr-FR");
    const rangeData = computed(() => d.ranges[range.value]);
    const curvePath = (values, width, height, padding = 8) => {
      const min = Math.min(...values), spread = Math.max(...values) - min || 1;
      const points = values.map((value, index) => ({
        x: (index / (values.length - 1)) * width,
        y: height - padding - ((value - min) / spread) * (height - padding * 2),
      }));
      return points.map((point, index) => {
        if (!index) return `M${point.x} ${point.y}`;
        const previous = points[index - 1], control = (point.x - previous.x) / 3;
        return `C${previous.x + control} ${previous.y} ${point.x - control} ${point.y} ${point.x} ${point.y}`;
      }).join(" ");
    };
    const areaPath = (values, width, height, padding = 8) =>
      `${curvePath(values, width, height, padding)} L${width} ${height} L0 ${height} Z`;
    const bestPath = computed(() => curvePath(d.best.series, 240, 62, 7));
    const bestArea = computed(() => areaPath(d.best.series, 240, 62, 7));
    const trafficPath = computed(() => curvePath(d.traffic.series, 300, 104, 9));
    const trafficArea = computed(() => areaPath(d.traffic.series, 300, 104, 9));
    const modulePath = computed(() => curvePath(mod.value.series, 180, 48, 5));
    const moduleArea = computed(() => areaPath(mod.value.series, 180, 48, 5));
    const rangePath = computed(() => curvePath(rangeData.value.series, 300, 82, 9));
    const rangeArea = computed(() => areaPath(rangeData.value.series, 300, 82, 9));

    // Compteurs animés
    const tween = (from, to, set, ms = 1400) => {
      const t0 = performance.now();
      const step = (t) => {
        const p = Math.max(0, Math.min((t - t0) / ms, 1)), e = 1 - Math.pow(1 - p, 4);
        set(from + (to - from) * e);
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };

    onMounted(() => {
      ready.value = true;
      if (reducedMotion) {
        bestN.value = d.best.value;
        d.kpis.forEach((k, i) => (kpiN.value[i] = k.value));
        modN.value = mod.value.count;
      } else {
        tween(0, d.best.value, (v) => (bestN.value = v));
        d.kpis.forEach((k, i) => tween(0, k.value, (v) => (kpiN.value[i] = v)));
        tween(0, mod.value.count, (v) => (modN.value = v));
      }
    });
    watch(mod, (m) => {
      if (reducedMotion) modN.value = m.count;
      else tween(modN.value, m.count, (v) => (modN.value = v), 700);
    });

    return { d, ready, range, mod, bestN, kpiN, modN, fmt, rangeData, bestPath, bestArea, trafficPath, trafficArea, modulePath, moduleArea, rangePath, rangeArea };
  },
}).mount("#app");
