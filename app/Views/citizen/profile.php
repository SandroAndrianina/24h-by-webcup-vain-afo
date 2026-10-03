<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Mon profil</h1>

<form action="<?= site_url('citoyen/profile') ?>" method="post" class="card">
    <?= csrf_field() ?>
    <label for="name">Nom</label>
    <input id="name" name="name" type="text" maxlength="150" required value="<?= esc(old('name') ?? $user['name']) ?>">

    <label for="email">Email</label>
    <input id="email" type="email" value="<?= esc($user['email']) ?>" disabled>

    <button class="btn" type="submit">Enregistrer</button>
</form>
<?= $this->endSection() ?>
