const { createApp, ref } = Vue;

const svg = (inner) =>
  `<svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${inner}</svg>`;

const icons = {
  orbit: svg('<ellipse cx="32" cy="32" rx="27" ry="14" transform="rotate(-28 32 32)"/><circle cx="13" cy="42" r="3.5" fill="currentColor"/><circle cx="51" cy="22" r="3.5" fill="currentColor"/>'),
  blob: svg('<path d="M20 12c6-6 18-6 24 0 4 5 2 9 6 13 5 5 2 11-3 14-5 3-7 9-14 10-8 1-15-4-19-9-4-5-2-11-1-17 1-5 3-8 7-11z"/><circle cx="32" cy="32" r="4"/>'),
  atom: svg('<ellipse cx="32" cy="32" rx="27" ry="10"/><ellipse cx="32" cy="32" rx="27" ry="10" transform="rotate(60 32 32)"/><ellipse cx="32" cy="32" rx="27" ry="10" transform="rotate(120 32 32)"/><circle cx="32" cy="32" r="3" fill="currentColor"/>'),
  waves: svg([14, 22, 30, 38, 46].map((y) => `<path d="M8 ${y}c8-7 14 7 24 0s16-7 24 0"/>`).join("")),
  flower: svg('<ellipse cx="32" cy="32" rx="8" ry="25"/><ellipse cx="32" cy="32" rx="8" ry="25" transform="rotate(60 32 32)"/><ellipse cx="32" cy="32" rx="8" ry="25" transform="rotate(120 32 32)"/>'),
  gear: svg('<circle cx="32" cy="32" r="9"/><path d="M32 6v10M32 48v10M6 32h10M48 32h10M14 14l7 7M43 43l7 7M50 14l-7 7M21 43l-7 7"/>'),
};

createApp({
  setup() {
    const { name, items } = window.MENU;
    const active = ref(0); // la section survolée reste ouverte, les autres restent verticales
    const ready = ref(false);
    return { name, items, icons, active, ready };
  },
  mounted() {
    this.ready = true;
  },
}).mount("#app");