<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Nouvelle demande</h1>
<p class="muted">Décrivez ce qui s'est passé et indiquez où cela se trouve.</p>

<form action="<?= site_url('citoyen/requests') ?>" method="post" class="card">
    <?= csrf_field() ?>

    <label for="type">Type de problème</label>
    <select id="type" name="type" required>
        <option value="">— Choisir —</option>
        <?php foreach (\App\Models\CitizenRequestModel::TYPES as $key => $label): ?>
            <option value="<?= esc($key) ?>" <?= old('type') === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="title">Objet (résumé court)</label>
    <input id="title" name="title" type="text" maxlength="150" required value="<?= esc(old('title') ?? '') ?>" placeholder="Ex. Lampadaire cassé">

    <label for="description">Que s'est-il passé ?</label>
    <textarea id="description" name="description" rows="5" maxlength="2000" required><?= esc(old('description') ?? '') ?></textarea>

    <label for="location">Lieu</label>
    <input id="location" name="location" type="text" maxlength="255" required value="<?= esc(old('location') ?? '') ?>" placeholder="Ex. 12 rue des Serres, quartier sud">

    <button class="btn" type="submit">Envoyer la demande</button>
</form>
<?= $this->endSection() ?>
