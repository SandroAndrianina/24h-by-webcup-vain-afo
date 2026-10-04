<!DOCTYPE html>
<html lang="<?= session()->get('lang') ?? 'fr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nouvelle demande — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
</head>
<body>

<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('menu') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
      <a class="nav-button" href="<?= site_url('menu') ?>">Accueil</a>
      <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= site_url('citoyen/requests') ?>">Mes demandes</a>
    <span class="breadcrumb__sep">›</span>
    <span aria-current="page">Nouvelle demande</span>
  </nav>

  <header class="head"><h1>NOUVELLE DEMANDE</h1></header>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <?php $errors = session()->getFlashdata('errors') ?? []; ?>
  <?php if (!empty($errors)): ?>
    <div class="flash flash--error">
      <ul style="margin:0;padding-left:18px;">
        <?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form class="req-form" method="post" action="<?= site_url('citoyen/requests') ?>">
    <?= csrf_field() ?>

    <label class="req-form__field">
      <span class="req-form__label">Type de demande *</span>
      <select name="type" required>
        <option value="">— Choisir —</option>
        <?php foreach ($types as $value => $label): ?>
          <option value="<?= esc($value) ?>" <?= old('type') === $value ? 'selected' : '' ?>>
            <?= esc($label) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <label class="req-form__field">
      <span class="req-form__label">Localisation</span>
      <input type="text" name="location" value="<?= esc(old('location') ?? '') ?>"
             placeholder="Ex : Rue des Manguiers, quartier Sud" maxlength="255">
    </label>

    <label class="req-form__field">
      <span class="req-form__label">Description *</span>
      <textarea name="description" rows="6" required minlength="10"
                placeholder="Décrivez votre demande en quelques phrases…"><?= esc(old('description') ?? '') ?></textarea>
      <small class="req-form__hint">10 caractères minimum.</small>
    </label>

    <div class="req-form__actions">
      <a href="<?= site_url('citoyen/requests') ?>" class="btn-ghost">Annuler</a>
      <button type="submit" class="btn-cta">Envoyer ma demande →</button>
    </div>
  </form>
</div>

<?= view('partials/a11y_widget') ?>
</body>
</html>