<?php
use App\Models\CitizenRequestModel as M;
$status  = $request['status'];
$taken   = in_array($status, ['en_cours', 'traite'], true);
$done    = $status === 'traite';
?>
<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Demande n°<?= (int) $request['id'] ?></h1>

<div class="card">
    <h2 style="margin-top:0"><?= esc($request['title']) ?></h2>
    <p><span class="badge"><?= esc(M::STATUS[$status] ?? $status) ?></span></p>
    <dl>
        <dt class="muted">Type</dt><dd><?= esc(M::TYPES[$request['type']] ?? $request['type']) ?></dd>
        <dt class="muted">Lieu</dt><dd><?= esc($request['location']) ?></dd>
        <dt class="muted">Description</dt><dd><?= nl2br(esc($request['description'])) ?></dd>
    </dl>
</div>

<div class="card">
    <h2 style="margin-top:0">Suivi</h2>
    <ol class="steps">
        <li class="done">Demande envoyée — <?= esc(date('d/m/Y H:i', strtotime($request['created_at']))) ?></li>
        <li class="<?= $taken ? 'done' : 'todo' ?>">Prise en charge par un agent</li>
        <li class="<?= $done ? 'done' : 'todo' ?>">Demande traitée<?= $done ? ' — ' . esc(date('d/m/Y H:i', strtotime($request['updated_at']))) : '' ?></li>
    </ol>
</div>

<a href="<?= site_url('citoyen/requests') ?>">← Retour à mes demandes</a>
<?= $this->endSection() ?>
