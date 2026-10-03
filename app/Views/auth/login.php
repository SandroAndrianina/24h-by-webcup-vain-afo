<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Connexion</h1>
    <form action="/login" method="post">
        <?= csrf_field() ?>
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Mot de passe">
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>