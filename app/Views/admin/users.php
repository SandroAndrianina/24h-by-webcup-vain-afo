<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Utilisateurs — TERRA NOVA</title>
<link rel="stylesheet" href="<?= base_url('assets/css/accordion.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/citizen.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-users.css') ?>">
</head>
<body>
<div class="page">
  <header class="topbar">
    <a class="brand" href="<?= site_url('admin/dashboard') ?>"><img src="<?= base_url('assets/images/logo horizontale.png') ?>" alt="TERRA NOVA"></a>
    <nav class="top-nav">
      <a class="nav-button" href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
      <a class="nav-button" href="<?= site_url('menu') ?>">Accueil</a>
      <a class="nav-button nav-button--accent" href="<?= site_url('logout') ?>">Déconnexion</a>
    </nav>
  </header>

  <header class="head"><h1>UTILISATEURS</h1></header>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash flash--success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <table class="users-table">
    <thead>
      <tr><th>#</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Inscrit le</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= esc($u['id']) ?></td>
          <td><?= esc($u['name']) ?></td>
          <td><?= esc($u['email']) ?></td>
          <td><span class="role-tag role-<?= esc($u['role_code']) ?>"><?= esc($u['role_label']) ?></span></td>
          <td><?= esc($u['created_at'] ? date('d M Y', strtotime($u['created_at'])) : '—') ?></td>
          <td>
            <form method="post" action="<?= site_url('admin/users/' . $u['id'] . '/role') ?>" style="display:inline;">
              <?= csrf_field() ?>
              <select name="role" onchange="this.form.submit()">
                <?php foreach (['admin' => 'Admin', 'agent' => 'Agent', 'citoyen' => 'Citoyen'] as $code => $label): ?>
                  <option value="<?= $code ?>" <?= $u['role_code'] === $code ? 'selected' : '' ?>>
                    <?= $label ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?= view('partials/a11y_widget') ?>
</body>
</html>