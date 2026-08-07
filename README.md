# Starter WordPress 2024 - Projet de test

## Technologies

- WordPress BedRock
- Thème Sage 11
- Acorn 5
- Horizon Tools
- Horizon Blocks
- Horizon PostTypes
- DDEV
- PHP 8.4
- Node 22

## Installation

Démarrer le projet
```bash
ddev start
```

Dupliquer le fichier `.env.example` et le renommer en `.env`

Dupliquer le fichier `auth.example.json`, le renommer en `auth.json` et modifier la clé API ACF

Installer la clé de sécurité pour Acorn / Livewire (cette commande va renseigner la ligne APP_KEY du `.env`)
```bash
ddev acorn key:generate
```

## Créer du contenu

### Créer un Post-Type

```bash
ddev acorn make:posttype Dossier/Du/PostType/NomDuPostType
```

Cette commande aura pour effet de créer une nouvelle classe de Post-Type dans le dossier `app/PostTypes/Dossier/Du/PostType`.

Il ne reste plus qu'à modifier quelques valeurs pour le personnaliser au besoin

### Créer une Taxonomie

```bash
ddev acorn make:taxonomy Dossier/DeLa/Taxonomie/NomDeLaTaxonomie
```

Cette commande aura pour effet de créer une nouvelle classe de Taxonomie dans le dossier `app/Taxonomies/Dossier/DeLa/Taxonomie`.

Il ne reste plus qu'à modifier quelques valeurs pour le personnaliser au besoin

### Créer un block Gutenberg ACF

```bash
ddev acorn make:block Dossier/Du/Block/NomDuBlock
```

Cette commande aura pour effet de créer un nouveau block ACF dans le dossier `app/Blocks/Dossier/Du/Block`.

Il ne reste plus qu'à modifier quelques valeurs pour le personnaliser au besoin

### Créer un Template

Cette commande aura pour effet de créer un nouveau template (entendre des blocks ajoutés par défaut à la création de
tel ou tel post de tel ou tel post-type) dans le dossier `app/Templates`.

```bash
ddev acorn make:template Dossier/Du/Template/NomDuTemplate
```

### Créer un Admin

Cette commande aura pour effet de créer un nouvel Admin dans le dossier `app/Admin`.

```bash
ddev acorn make:admin Dossier/DeLAdmin/NomDeLAdmin
```

### Créer un Hook

Cette commande aura pour effet de créer une nouvelle classe pour déclarer des hooks dans le dossier `app/Hooks`.

```bash
ddev acorn make:hook Dossier/Du/Hook/NomDuHook
```

## Lister le contenu

Des commandes permettent de lister les différents contenus existants :

```bash
ddev acorn list:blocks
```

```bash
ddev acorn list:posttypes
```

```bash
ddev acorn list:taxonomies
```

## Deployer : commandes distantes

### Lancer une commande WP-CLI sur un environnement distant

```bash
ddev deployer wp-cli <stage> --command="<commande wp-cli>"
```

Exemple :
```bash
ddev deployer wp-cli production --command="cache flush"
```

### Lancer une commande Acorn sur un environnement distant

```bash
ddev deployer acorn <stage> --command="<commande acorn>"
```

Exemple :
```bash
ddev deployer acorn production --command="icons:cache"
```

### Transférer la base de données et les uploads

Ces tâches sont fournies par le package [`agence-adeliom/horizon-deployer-recipe`](https://github.com/agence-adeliom/horizon-deployer-recipe),
chargé dans `deploy.php`. Se référer à son README pour le détail des garde-fous et des options de configuration.

Un « environnement » est soit `local`, soit l'alias d'un hôte déclaré dans `deploy.php`.

| Commande | Sens | Effet |
| --- | --- | --- |
| `ddev deployer db:pull <stage>` | distant → local | Télécharge un dump `.sql.gz` à la racine du projet, puis propose l'import local et la réécriture d'URLs |
| `ddev deployer uploads:pull <stage>` | distant → local | Télécharge une archive `.tar.gz`, puis propose l'extraction dans `web/app/uploads` |
| `ddev deployer db:push --from=X --to=Y` | local\|distant → distant | Sauvegarde la base de destination, importe, puis propose la réécriture d'URLs |
| `ddev deployer uploads:push --from=X --to=Y` | local\|distant → distant | Synchronise les uploads, en fusion (`merge`) ou en miroir (`mirror`) |

```bash
# Rapatrier la production en local
ddev deployer db:pull production
ddev deployer uploads:pull production

# Récupérer uniquement le favicon (quelques Ko au lieu de plusieurs Go d'uploads)
ddev deployer uploads:pull production --favicon-only

# Rafraîchir la préproduction depuis la production
ddev deployer db:push --from=production --to=staging
ddev deployer uploads:push --from=production --to=staging

# Envoyer sa base locale en préproduction
ddev deployer db:push --from=local --to=staging
```

`--from` et `--to` sont facultatifs : ils sont demandés interactivement si absents. La destination d'un `push` est
toujours un environnement distant — pour rapatrier vers le local, utiliser les tâches `pull`.

Options utiles :
- `--strategy=merge|mirror` : `uploads:push`, fusion ou miroir (le miroir supprime à la destination)
- `--checksum` : `uploads:push`, compare les fichiers sur leur contenu et non sur taille + date (lent mais fiable)
- `--precise` : force le traitement PHP de toutes les colonnes lors du search-replace (gourmand en mémoire)
- `--favicon-only` : `uploads:pull`, ne récupère que le favicon (`site_icon`) et ses déclinaisons

**Garde-fous :** un `pull` ne modifie jamais l'environnement distant. Un `push` demande toujours confirmation, et exige
la saisie de l'alias en clair pour un hôte protégé (par défaut, tout alias ou stage contenant `prod`). La base de
destination est systématiquement dumpée avant import, dans `{{deploy_path}}/.dep/backups`, et cette sauvegarde est conservée.

**Prérequis :** le dépôt du package est privé. Le `auth.json` du projet doit contenir un token GitHub sous `github-oauth`
(un token *fine-grained* avec la permission **Contents : Read-only** sur l'organisation `agence-adeliom` suffit).

## Gestion des menus

### Créer un emplacement de menu

Sage permet de rajouter facilement des emplacements de menu via la fonction `register_nav_menus` dans le fichier `app/setup.php` du thème.

### Récupérer un menu

Il est possible de récupérer un menu dans un ViewModel récupérant :
- Les éléments du menu de façon hiérarchique
- Les éventuels champs ACF

Pour cela, il suffit d'utiliser la classe `MenuViewModel` en l'instanciant avec le slug de l'emplacement du menu

Cela peut se faire :
- Dans un Composer de vue _(à privilégier)_
- Directement dans le template

## Gestion des assets

### Installation des assets du thème

```bash
ddev theme:install
```

### Compilation des assets (watch)

```bash
ddev theme:dev
```

**Attention :** pour constater les changements refresh en live, ne pas oublier de rajouter le port `3001` à la fin du nom de domaine

Exemples :
- `https://site.ddev.site:3001`
- `https://site.ddev.site:3001/slug/de/page/`

En utilisant cette URL, les changements effectués dans les fichiers `.css` et `.js` seront automatiquement compilés et injectés dans la page

Pour les modifications effectuées dans les templates, il sera nécessaire de recharger la page.

### Compilation des assets (production)

```bash
ddev theme:build
```

### Compiler un fichier de façon autonome (sans le lier aux fichiers principaux app.css et app.js)

Pour arriver à ce résultat :
- Se render dans le fichier `bud.config.js`
- Rajouter une `entry`

```javascript
  app
    .entry('app', ['@scripts/app', '@styles/app'])
    .entry('editor', ['@scripts/editor', '@styles/editor'])
    .entry('mon-block', ['@scripts/blocks/mon-block.js'])
    .runtime('multiple')
    .hash();
```

Un fichier `mon-block.js` sera donc généré, indépendant des autres.

Pour ajouter ce fichier à un block, il suffit de se rendre dans sa classe et de compléter la méthode suivante :

```php
public function renderBlockCallback(): void
{
    wp_enqueue_script('mon-block-js', Compilation::getUrl('mon-block.js'));
    wp_enqueue_style('mon-block-css', Compilation::getUrl('mon-block.css'));
}
```

## Gestion des médias

### Autoriser les fichiers SVG

Pour autoriser les fichiers SVG dans la médiathèque WordPress, il suffit de se rendre dans le dossier du thème, puis
de modifier le fichier `config/medias.php`.

Il est également possible de sanitize automatiquement le fichier SVG lors de l'envoi afin d'éviter les failles de sécurité.

## Gestion des contenus

### Modifier le prefix des articles (posts)

Il est possible de modifier facilement le préfixe des articles sans toucher aux permaliens en accédant au fichier
`config/posts.php` du thème

```php
<?php

return [
    'prefix' => 'articles',
];
```