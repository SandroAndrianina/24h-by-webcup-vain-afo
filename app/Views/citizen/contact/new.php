<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Contacter la mairie</h1>
<p class="muted">Une question ou une difficulté ? Écrivez aux services municipaux.</p>

<form action="<?= site_url('citoyen/contact') ?>" method="post" class="card">
    <?= csrf_field() ?>
    <label for="message">Votre message</label>
    <textarea id="message" name="message" rows="6" maxlength="2000" required><?= esc(old('message') ?? '') ?></textarea>
    <button class="btn" type="submit">Envoyer</button>
</form>
<?= $this->endSection() ?>
