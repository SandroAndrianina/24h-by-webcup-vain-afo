<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Bonjour <?= esc((string) session()->get('name')) ?></h1>
<p class="muted">Bienvenue dans votre espace personnel. Que souhaitez-vous faire ?</p>

<div class="grid">
    <a class="card tile" href="<?= site_url('citoyen/requests/new') ?>"><h2>Faire une demande</h2><p class="muted">Signaler un problème (lampadaire, route, fuite…).</p></a>
    <a class="card tile" href="<?= site_url('citoyen/requests') ?>"><h2>Mes demandes</h2><p class="muted">Retrouver l'historique et l'état de mes démarches.</p></a>
    <a class="card tile" href="<?= site_url('citoyen/contact') ?>"><h2>Contacter la mairie</h2><p class="muted">Poser une question aux services municipaux.</p></a>
    <a class="card tile" href="<?= site_url('citoyen/profile') ?>"><h2>Mon profil</h2><p class="muted">Vérifier et compléter mes informations.</p></a>
</div>
<?= $this->endSection() ?>
