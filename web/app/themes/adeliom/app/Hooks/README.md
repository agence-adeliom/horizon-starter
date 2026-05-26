# Hooks

Chaque classe ici étend `Adeliom\HorizonTools\Hooks\AbstractHook` et est
auto-découverte par Horizon Tools — pas besoin de l'enregistrer manuellement.

À placer dans ce dossier : toute logique métier branchée sur des hooks WordPress
(rôles, capabilities, admin, SEO, back-office, etc.).

Le bootstrap Sage classique (theme_support, enqueue d'assets, widgets, settings
de l'éditeur) reste dans `app/setup.php` ; les filtres WP très courts dans
`app/filters.php`.

Pour scaffolder un nouveau hook :

```bash
ddev acorn make:hook MyHook
```
