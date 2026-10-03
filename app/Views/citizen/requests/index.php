<?= $this->extend('citizen/layout') ?>
<?= $this->section('content') ?>
<h1>Mes demandes</h1>

<?php if (empty($requests)): ?>
    <div class="card"><p>Vous n'avez encore envoyé aucune demande.</p></div>
<?php else: ?>
    <div class="card" style="overflow-x:auto">
        <table>
            <caption class="muted" style="text-align:left;padding-bottom:.5rem">Historique de vos demandes</caption>
            <thead><tr><th scope="col">N°</th><th scope="col">Objet</th><th scope="col">Type</th><th scope="col">Date</th><th scope="col">État</th></tr></thead>
            <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= (int) $r['id'] ?></td>
                    <td><a href="<?= site_url('citoyen/requests/' . (int) $r['id']) ?>"><?= esc($r['title']) ?></a></td>
                    <td><?= esc(\App\Models\CitizenRequestModel::TYPES[$r['type']] ?? $r['type']) ?></td>
                    <td><?= esc(date('d/m/Y H:i', strtotime($r['created_at']))) ?></td>
                    <td><span class="badge"><?= esc(\App\Models\CitizenRequestModel::STATUS[$r['status']] ?? $r['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<a class="btn" href="<?= site_url('citoyen/requests/new') ?>">Nouvelle demande</a>
<?= $this->endSection() ?>
