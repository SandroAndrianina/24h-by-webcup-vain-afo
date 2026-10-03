<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Agent</title>
</head>
<body>
    <h1>Inscription Agent</h1>

    <form action="/register-agent" method="post">
        <?= csrf_field() ?>

        <input type="text" name="name" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
