# TERRA NOVA login — CodeIgniter 4 (PHP + Vue.js CDN + SCSS)

Colle chaque dossier dans ton projet CI4 en gardant la même arborescence :

```
app/Config/TerraNova.php        ← images, marque, liens, utilisateurs de démo
app/Controllers/Auth.php        ← page + traitement du login
app/Views/auth/login.php        ← la page
public/assets/css/login.scss    ← source SCSS
public/assets/css/login.css     ← CSS compilé (celui qui est chargé)
public/assets/js/login.js       ← Vue 3
public/assets/images/           ← hero.jpg · background.jpg
```

## Routes : ajoute dans app/Config/Routes.php
```php
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::attempt');
```
Puis ouvre `http://localhost:8080/login` (avec `php spark serve`).
Compte de démo : `designer@terranova.com` / `terranova123`

## Changer les images
Remplace les fichiers dans `public/assets/images/` en gardant le même nom, ou change les chemins dans `app/Config/TerraNova.php`.

## Modifier le SCSS
Après modification de `login.scss`, recompile :
`sass public/assets/css/login.scss public/assets/css/login.css`
(le fichier est du SCSS « plat » : il se compile tel quel).

## Notes
- Si le filtre CSRF est actif (Config/Filters.php), c'est déjà géré : le jeton est envoyé en en-tête et renouvelé à chaque réponse.
- La session CI4 doit fonctionner (`writable/session`), ainsi que le cache (limite de 5 essais/minute).
- Pour tes vrais utilisateurs : remplace la ligne `config(TerraNova::class)->users[...]` dans `Auth::attempt()` par ton modèle.
