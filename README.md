# Starter WordPress 2024 - Projet de test

## Technologies

- WordPress BedRock
- Thème Sage
- Acorn
- HorizonTools
- DDEV
- PHP 8.3
- Node 20

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
    wp_enqueue_script('mon-block-js', BudService::getUrl('mon-block.js'));
    wp_enqueue_style('mon-block-css', BudService::getUrl('mon-block.css'));
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