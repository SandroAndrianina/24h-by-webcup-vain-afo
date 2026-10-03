<div class="a11y" role="group" aria-label="Taille du texte">
  <button type="button" class="a11y__btn" data-a11y="down" aria-label="Réduire le texte">A−</button>
  <button type="button" class="a11y__btn" data-a11y="reset" aria-label="Taille normale">A</button>
  <button type="button" class="a11y__btn" data-a11y="up" aria-label="Agrandir le texte">A+</button>
</div>
<script>
(function () {
  const root = document.documentElement;
  const sizes = [90, 100, 115, 130, 150];
  let i = parseInt(localStorage.getItem('a11ySize') || '1', 10);
  if (isNaN(i) || i < 0 || i >= sizes.length) i = 1;

  function apply() {
    root.style.fontSize = sizes[i] + '%';
    localStorage.setItem('a11ySize', i);
  }
  apply();

  document.addEventListener('click', e => {
    const b = e.target.closest('[data-a11y]');
    if (!b) return;
    const a = b.dataset.a11y;
    if (a === 'up'    && i < sizes.length - 1) i++;
    if (a === 'down'  && i > 0) i--;
    if (a === 'reset') i = 1;
    apply();
  });
})();
</script>